<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/7/15
 * Time: 6:42 AM
 */

class Purchase_Invoice_Entry {

    public $id;
    public $item_id;
    public $product;
    public $quantity;
    public $costPerItem;
    public $amount;
    public $invoice;
    public function __construct(&$whole_obj)
    {
        $this->invoice = $whole_obj;
    }

    public function total_cost()
    {
        return round($this->quantity * $this->costPerItem, 3);
    }
} 