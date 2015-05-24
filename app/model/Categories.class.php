<?php
/**
 * Categories Active Record
 * @author  <your-name-here>
 */
class Categories extends TRecord
{
    const TABLENAME = 'categories';
    const PRIMARYKEY= 'CategoryID';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('CategoryName');
        parent::addAttribute('Description');
        parent::addAttribute('Picture');
    }


}
