<?php
/**
 * SalesByCategory Active Record
 * @author  <your-name-here>
 */
class SalesByCategory extends TRecord
{
    const TABLENAME = 'sales_by_category';
    const PRIMARYKEY= 'CategoryID';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('CategoryName');
        parent::addAttribute('ProductName');
        parent::addAttribute('ProductSales');
    }


}
