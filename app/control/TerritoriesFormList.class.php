<?php
/**
 * TerritoriesFormList Registration
 * @author  <your name here>
 */
class TerritoriesFormList extends TStandardFormList
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
        parent::setActiveRecord('Territories');   // defines the active record
        parent::setDefaultOrder('TerritoryID', 'asc');         // defines the default order
        
        // creates the form
        $this->form = new TQuickForm('form_Territories');
        $this->form->class = 'tform'; // CSS class
        $this->form->setFormTitle('Territories'); // define the form title
        


        // create the form fields
        $TerritoryID                    = new TEntry('TerritoryID');
        $TerritoryDescription           = new TEntry('TerritoryDescription');
        $RegionID                       = new TCombo('RegionID');
        $region = new Region();
        $itens_region = array();
        $rs_region = $region->get_all_regions();
        foreach($rs_region as $r)
        {
            $itens_region[$r->RegionID] = $r->RegionDescription;
        }
        $RegionID->addItems($itens_region);


        // add the fields
        $this->form->addQuickField('TerritoryID', $TerritoryID,  200);
        $this->form->addQuickField('TerritoryDescription', $TerritoryDescription,  200);
        $this->form->addQuickField('RegionID', $RegionID,  100);




        
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'ico_save.png');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'ico_new.png');
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(320);
        

        // creates the datagrid columns
        $TerritoryID = $this->datagrid->addQuickColumn('TerritoryID', 'TerritoryID', 'left', 200);
        $TerritoryDescription = $this->datagrid->addQuickColumn('TerritoryDescription', 'TerritoryDescription', 'left', 200);
        $RegionID = $this->datagrid->addQuickColumn('RegionID', 'RegionID', 'left', 100);

        
        // create the datagrid actions
        $edit_action   = new TDataGridAction(array($this, 'onEdit'));
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        
        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), $edit_action, 'TerritoryID', 'ico_edit.png');
        $this->datagrid->addQuickAction(_t('Delete'), $delete_action, 'TerritoryID', 'ico_delete.png');
        
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
