<?php
/**
 * Territories Active Record
 * @author  <your-name-here>
 */
class Territories extends TRecord
{
    const TABLENAME = 'territories';
    const PRIMARYKEY= 'TerritoryID';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $region;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('TerritoryDescription');
        parent::addAttribute('RegionID');
    }

    
    /**
     * Method set_region
     * Sample of usage: $territories->region = $object;
     * @param $object Instance of Region
     */
    public function set_region(Region $object)
    {
        $this->region = $object;
        $this->RegionID = $object->id;
    }
    
    /**
     * Method get_region
     * Sample of usage: $territories->region->attribute;
     * @returns Region instance
     */
    public function get_region()
    {
        // loads the associated object
        if (empty($this->region))
            $this->region = new Region($this->RegionID);
    
        // returns the associated object
        return $this->region->RegionDescription;
    }
    


}
