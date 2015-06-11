<?php
/**
 * CustomersList Listing
 * @author  <your name here>
 */
class CustomersList extends TStandardList
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
        parent::setActiveRecord('Customers');   // defines the active record
        parent::setDefaultOrder('CustomerID', 'asc');         // defines the default order
        parent::addFilterField('CustomerID', 'like'); // add a filter field
        parent::addFilterField('CompanyName', 'like'); // add a filter field
        parent::addFilterField('ContactName', 'like'); // add a filter field
        parent::addFilterField('ContactTitle', 'like'); // add a filter field
        parent::addFilterField('Address', 'like'); // add a filter field
        parent::addFilterField('City', 'like'); // add a filter field
        parent::addFilterField('Region', 'like'); // add a filter field
        parent::addFilterField('PostalCode', 'like'); // add a filter field
        parent::addFilterField('Country', 'like'); // add a filter field
        parent::addFilterField('Phone', 'like'); // add a filter field
        parent::addFilterField('Fax', 'like'); // add a filter field
        
        // creates the form, with a table inside
        $this->form = new TQuickForm('form_search_Customers');
        $this->form->class = 'tform'; // CSS class
        $this->form->setFormTitle('Customers');
        

        // create the form fields
        $CustomerID                     = new TEntry('CustomerID');
        $CompanyName                    = new TEntry('CompanyName');
        $ContactName                    = new TEntry('ContactName');
        $ContactTitle                   = new TEntry('ContactTitle');
        $Address                        = new TEntry('Address');
        $City                           = new TEntry('City');
        $Region                         = new TEntry('Region');
        $PostalCode                     = new TEntry('PostalCode');
        $Country                        = new TEntry('Country');
        $Phone                          = new TEntry('Phone');
        $Fax                            = new TEntry('Fax');


        // add the fields
        $this->form->addQuickField('CustomerID', $CustomerID,  200);
        $this->form->addQuickField('CompanyName', $CompanyName,  200);
        $this->form->addQuickField('ContactName', $ContactName,  200);
        $this->form->addQuickField('ContactTitle', $ContactTitle,  200);
        $this->form->addQuickField('Address', $Address,  200);
        $this->form->addQuickField('City', $City,  200);
        $this->form->addQuickField('Region', $Region,  200);
        $this->form->addQuickField('PostalCode', $PostalCode,  200);
        $this->form->addQuickField('Country', $Country,  200);
        $this->form->addQuickField('Phone', $Phone,  200);
        $this->form->addQuickField('Fax', $Fax,  200);



        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Customers_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'ico_find.png');
        #$this->form->addQuickAction(_t('New'),  new TAction(array('CustomersForm', 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(320);
        

        // creates the datagrid columns
        $CustomerID = $this->datagrid->addQuickColumn('CustomerID', 'CustomerID', 'left', 200);
        $CompanyName = $this->datagrid->addQuickColumn('CompanyName', 'CompanyName', 'left', 200);
        $ContactName = $this->datagrid->addQuickColumn('ContactName', 'ContactName', 'left', 200);
        $ContactTitle = $this->datagrid->addQuickColumn('ContactTitle', 'ContactTitle', 'left', 200);
        $Address = $this->datagrid->addQuickColumn('Address', 'Address', 'left', 200);
        $City = $this->datagrid->addQuickColumn('City', 'City', 'left', 200);
        $Region = $this->datagrid->addQuickColumn('Region', 'Region', 'left', 200);
        $PostalCode = $this->datagrid->addQuickColumn('PostalCode', 'PostalCode', 'left', 200);
        $Country = $this->datagrid->addQuickColumn('Country', 'Country', 'left', 200);
        $Phone = $this->datagrid->addQuickColumn('Phone', 'Phone', 'left', 200);
        $Fax = $this->datagrid->addQuickColumn('Fax', 'Fax', 'left', 200);

        
        // create the datagrid actions
        #$edit_action   = new TDataGridAction(array('CustomersForm', 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        #$this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'CustomerID', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'CustomerID', 'ico_delete.png');
        
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
