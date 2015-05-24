<?php
/**
 * AlphabeticalListOfProducts Active Record
 * @author  <your-name-here>
 */
class AlphabeticalListOfProducts extends TRecord
{
    const TABLENAME = 'alphabetical_list_of_products';
    const PRIMARYKEY= 'ProductID';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('ProductName');
        parent::addAttribute('SupplierID');
        parent::addAttribute('CategoryID');
        parent::addAttribute('QuantityPerUnit');
        parent::addAttribute('UnitPrice');
        parent::addAttribute('UnitsInStock');
        parent::addAttribute('UnitsOnOrder');
        parent::addAttribute('ReorderLevel');
        parent::addAttribute('Discontinued');
        parent::addAttribute('CategoryName');
    }


}
