<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 3:41 AM
 */

class App_voucher_Entry {
    //properties
    public $id;
    public $item_id;    // a unique id for each selling and purchasing item for current invoice
    public $voucher_id;
    public $ac_title;
    public $ac_sub_title;
    public $ac_type;
    public $related_customer;
    public $related_supplier;
    public $related_business;
    public $related_other_agent;
    public $related_tanker;
    public $quantity;
    public $cost_per_item;
    public $purchase_price_per_item_for_sale;
    public $dr_cr;
    public $amount;
    public $freight;
    public $source;
    public $destination;
    public $description;
    public $inserted_at;
    public $updated_at;
    public $deleted_at;
    public $deleted;

    public $container;

    public function __construct(&$container = null)
    {
        $this->container = $container;
        $this->freight = 0;
        $this->item_id = 0;
    }

} 