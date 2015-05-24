<?php
/**
 * CategoriesFormList Registration
 * @author  <your name here>
 */
class CategoriesFormList extends TStandardFormList
{
    protected $form; // form
    protected $datagrid; // datagrid
    protected $pageNavigation;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('northwind');            // defines the database
        parent::setActiveRecord('Categories');   // defines the active record
        parent::setDefaultOrder('CategoryID', 'asc');         // defines the default order
        
        // creates the form
        $this->form = new TQuickForm('form_Categories');
        $this->form->class = 'tform'; // CSS class
        $this->form->setFormTitle('Categories'); // define the form title
        


        // create the form fields
        $CategoryName                   = new TEntry('CategoryName');
        $Description                    = new TText('Description');

        // add the fields
        $this->form->addQuickField('CategoryName', $CategoryName,  200);
        $this->form->addQuickField('Description', $Description,  200);

        $Description->setSize(200, 40);

        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'ico_save.png');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(320);

        // creates the datagrid columns
        $CategoryName = $this->datagrid->addQuickColumn('CategoryName', 'CategoryName', 'left', 200);
        $Description = $this->datagrid->addQuickColumn('Description', 'Description', 'left', 200);
        
        // create the datagrid actions
        $edit_action   = new TDataGridAction(array($this, 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'CategoryID', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'CategoryID', 'ico_delete.png');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = TVBox::pack( $this->form, $this->datagrid, $this->pageNavigation);
        parent::add($container);
    }
}
