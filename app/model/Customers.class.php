<?php
/**
 * Customers Active Record
 * @author  <your-name-here>
 */
class Customers extends TRecord
{
    const TABLENAME = 'customers';
    const PRIMARYKEY= 'CustomerID';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('CompanyName');
        parent::addAttribute('ContactName');
        parent::addAttribute('ContactTitle');
        parent::addAttribute('Address');
        parent::addAttribute('City');
        parent::addAttribute('Region');
        parent::addAttribute('PostalCode');
        parent::addAttribute('Country');
        parent::addAttribute('Phone');
        parent::addAttribute('Fax');
    }


}
