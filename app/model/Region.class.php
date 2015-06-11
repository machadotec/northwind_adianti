<?php
/**
 * Region Active Record
 * @author  <your-name-here>
 */
class Region extends TRecord
{
    const TABLENAME = 'region';
    const PRIMARYKEY= 'RegionID';
    const IDPOLICY =  'max'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('RegionDescription');
    }
    
    public function get_all_regions()
    {
        try
        {
            TTransaction::open('northwind');
            $repository = new TRepository('Region');
            $result = $repository->load();   
            TTransaction::close();
            return $result;
        }
        catch(Exception $e)
        {
            new TMessage('error',$e->getMessage());
        }
    }    
}
