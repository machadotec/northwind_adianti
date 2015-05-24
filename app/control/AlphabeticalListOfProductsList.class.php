<?php
/**
 * AlphabeticalListOfProductsList Listing
 * @author  <your name here>
 */
class AlphabeticalListOfProductsList extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('northwind');            // defines the database
        parent::setActiveRecord('AlphabeticalListOfProducts');   // defines the active record
        parent::setDefaultOrder('ProductID', 'asc');         // defines the default order
        parent::addFilterField('ProductID', 'like'); // add a filter field
        parent::addFilterField('ProductName', 'like'); // add a filter field
        parent::addFilterField('CategoryName', 'like'); // add a filter field
        
        // creates the form, with a table inside
        $this->form = new TQuickForm('form_search_AlphabeticalListOfProducts');
        $this->form->class = 'tform'; // CSS class
        $this->form->setFormTitle('AlphabeticalListOfProducts');
        

        // create the form fields
        $ProductID                      = new TEntry('ProductID');
        $ProductName                    = new TEntry('ProductName');
        $CategoryName                   = new TEntry('CategoryName');


        // add the fields
        $this->form->addQuickField('ProductID', $ProductID,  100);
        $this->form->addQuickField('ProductName', $ProductName,  200);
        $this->form->addQuickField('CategoryName', $CategoryName,  200);
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('AlphabeticalListOfProducts_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'ico_find.png');
        #$this->form->addQuickAction(_t('New'),  new TAction(array('AlphabeticalListOfProductsForm', 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(320);
        

        // creates the datagrid columns
        $ProductID = $this->datagrid->addQuickColumn('ProductID', 'ProductID', 'right', 100);
        $ProductName = $this->datagrid->addQuickColumn('ProductName', 'ProductName', 'left', 200);
        $QuantityPerUnit = $this->datagrid->addQuickColumn('QuantityPerUnit', 'QuantityPerUnit', 'left', 200);
        $UnitPrice = $this->datagrid->addQuickColumn('UnitPrice', 'UnitPrice', 'left', 200);
        $UnitsInStock = $this->datagrid->addQuickColumn('UnitsInStock', 'UnitsInStock', 'right', 100);
        $UnitsOnOrder = $this->datagrid->addQuickColumn('UnitsOnOrder', 'UnitsOnOrder', 'right', 100);
        $ReorderLevel = $this->datagrid->addQuickColumn('ReorderLevel', 'ReorderLevel', 'right', 100);
        $Discontinued = $this->datagrid->addQuickColumn('Discontinued', 'Discontinued', 'left', 200);
        $CategoryName = $this->datagrid->addQuickColumn('CategoryName', 'CategoryName', 'left', 200);

        
        // create the datagrid actions
        #$edit_action   = new TDataGridAction(array('AlphabeticalListOfProductsForm', 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        #$this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'id', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'ProductID', 'ico_delete.png');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = TVBox::pack( $this->form, $this->datagrid, $this->pageNavigation);
        parent::add($container);
    }
}
