<?php
/**
 * SalesByCategoryReport Report
 * @author  <your name here>
 */
class SalesByCategoryReport extends TPage
{
    protected $form; // form
    protected $notebook;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        // create the form
        $this->form = new TQuickForm('form_SalesByCategory_report');
        $this->form->class = 'tform';
        $this->form->style = 'width: 500px';
        $this->form->setFormTitle('Report');
        


        // create the form fields
        $CategoryID                     = new TEntry('CategoryID');
        $CategoryName                   = new TEntry('CategoryName');
        $ProductName                    = new TEntry('ProductName');
        $ProductSales                   = new TEntry('ProductSales');
        $output_type                    = new TRadioGroup('output_type');


        // add the fields
        $this->form->addQuickField('CategoryID', $CategoryID,  50);
        $this->form->addQuickField('CategoryName', $CategoryName,  200);
        $this->form->addQuickField('ProductName', $ProductName,  300);
        $this->form->addQuickField('ProductSales', $ProductSales,  200);
        $this->form->addQuickField('Output', $output_type,  100, new TRequiredValidator );




        
        $output_type->addItems(array('html'=>'HTML', 'pdf'=>'PDF', 'rtf'=>'RTF'));;
        $output_type->setValue('pdf');
        $output_type->setLayout('horizontal');
        
        // add the action button
        $this->form->addQuickAction(_t('Generate'), new TAction(array($this, 'onGenerate')), 'ico_apply.png');
        
        // add the form to the page
        parent::add($this->form);
    }
    
    /**
     * method onGenerate()
     * Executed whenever the user clicks at the generate button
     */
    function onGenerate()
    {
        try
        {
            // open a transaction with database 'northwind'
            TTransaction::open('northwind');
            
            // get the form data into an active record
            $formdata = $this->form->getData();
            
            $repository = new TRepository('SalesByCategory');
            $criteria   = new TCriteria;
            
            if ($formdata->CategoryID)
            {
                $criteria->add(new TFilter('CategoryID', 'like', "%{$formdata->CategoryID}%"));
            }
            if ($formdata->CategoryName)
            {
                $criteria->add(new TFilter('CategoryName', 'like', "%{$formdata->CategoryName}%"));
            }
            if ($formdata->ProductName)
            {
                $criteria->add(new TFilter('ProductName', 'like', "%{$formdata->ProductName}%"));
            }
            if ($formdata->ProductSales)
            {
                $criteria->add(new TFilter('ProductSales', 'like', "%{$formdata->ProductSales}%"));
            }

           
            $objects = $repository->load($criteria);
            $format  = $formdata->output_type;
            
            if ($objects)
            {
                $widths = array(80,100,200,100);
                
                switch ($format)
                {
                    case 'html':
                        $tr = new TTableWriterHTML($widths);
                        break;
                    case 'pdf':
                        $tr = new TTableWriterPDF($widths);
                        break;
                    case 'rtf':
                        if (!class_exists('PHPRtfLite_Autoloader'))
                        {
                            PHPRtfLite::registerAutoloader();
                        }
                        $tr = new TTableWriterRTF($widths);
                        break;
                }
                
                // create the document styles
                $tr->addStyle('title', 'Arial', '10', 'B',   '#ffffff', '#6B6B6B');
                $tr->addStyle('datap', 'Arial', '10', '',    '#000000', '#E5E5E5');
                $tr->addStyle('datai', 'Arial', '10', '',    '#000000', '#ffffff');
                $tr->addStyle('header', 'Times', '16', 'B',  '#4A5590', '#C0D3E9');
                $tr->addStyle('footer', 'Times', '12', 'BI', '#4A5590', '#C0D3E9');
                
                // add a header row
                $tr->addRow();
                $tr->addCell('SalesByCategory', 'center', 'header', 4);
                
                // add titles row
                $tr->addRow();
                $tr->addCell('CategoryID', 'right', 'title');
                $tr->addCell('CategoryName', 'left', 'title');
                $tr->addCell('ProductName', 'left', 'title');
                $tr->addCell('ProductSales', 'right', 'title');

                
                // controls the background filling
                $colour= FALSE;
                
                // data rows
                foreach ($objects as $object)
                {
                    $style = $colour ? 'datap' : 'datai';
                    $tr->addRow();
                    $tr->addCell($object->CategoryID, 'right', $style);
                    $tr->addCell($object->CategoryName, 'left', $style);
                    $tr->addCell($object->ProductName, 'left', $style);
                    $tr->addCell($object->ProductSales, 'right', $style);

                    
                    $colour = !$colour;
                }
                
                // footer row
                $tr->addRow();
                $tr->addCell(date('Y-m-d h:i:s'), 'center', 'footer', 4);
                // stores the file
                if (!file_exists("app/output/SalesByCategory.{$format}") OR is_writable("app/output/SalesByCategory.{$format}"))
                {
                    $tr->save("app/output/SalesByCategory.{$format}");
                }
                else
                {
                    throw new Exception(_t('Permission denied') . ': ' . "app/output/SalesByCategory.{$format}");
                }
                
                // open the report file
                parent::openFile("app/output/SalesByCategory.{$format}");
                
                // shows the success message
                new TMessage('info', 'Report generated. Please, enable popups in the browser (just in the web).');
            }
            else
            {
                new TMessage('error', 'No records found');
            }
    
            // fill the form with the active record data
            $this->form->setData($formdata);
            
            // close the transaction
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
    }
}
