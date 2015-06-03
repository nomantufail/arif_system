<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 3:41 AM
 */

class App_Voucher {
    //properties
    public $id;
    public $voucher_date;
    public $summary;
    public $tanker;
    public $product_sale_id;
    public $product_for_freight_voucher;
    public $product_number_for_freight_voucher;
    public $bank_ac;
    public $voucher_type;
    public $inserted_at;
    public $updated_at;
    public $deleted_at;
    public $deleted;

    public $entries;

    public function __construct()
    {
        $this->entries = array();
        $this->tanker = '';
        $this->product_for_freight_voucher = '';
        $this->product_number_for_freight_voucher = 0;
        $this->product_sale_id = 0;
        $this->bank_ac = '';
    }

    public function balance()
    {
        $total_debit = 0;
        $total_credit = 0;
        foreach($this->entries as $entry)
        {
            if($entry->dr_cr == 1)
            {
                $total_debit += $entry->amount;
            }
            else if($entry->dr_cr == 0)
            {
                $total_credit += $entry->amount;
            }
        }
        return round($total_debit-$total_credit);
    }

    public function debit_entries()
    {
        $entries = array();
        foreach($this->entries as $entry)
        {
            if($entry->dr_cr == 1)
            {
                array_push($entries, $entry);
            }
        }
        return $entries;
    }

    public function credit_entries()
    {
        $entries = array();
        foreach($this->entries as $entry)
        {
            if($entry->dr_cr == 0)
            {
                array_push($entries, $entry);
            }
        }
        return $entries;
    }
} 