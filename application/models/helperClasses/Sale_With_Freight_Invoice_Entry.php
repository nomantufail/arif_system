<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 5/26/15
 * Time: 6:42 AM
 */
include_once(APPPATH."models/helperClasses/Sale_Invoice_Entry.php");

class Sale_With_Freight_Invoice_Entry extends Sale_Invoice_Entry{

    public $freight;
    public function __construct(&$whole_obj)
    {
        $this->invoice = $whole_obj;
    }

} 