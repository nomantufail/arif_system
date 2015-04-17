<?php

/*
 * --------------------------------------
 * Parent Model For Query Scopes
 * --------------------------------------
 * This model is used for query scopes
 * which scopes are global and can be
 * used in any model..
 * */

class Parent_Model extends CI_Model {

    //protected properties
    protected $table;

    public function __construct(){
        parent::__construct();

    }

    /**
     * Used to fetch only active records
     */
    public function active()
    {
        $this->db->where('deleted',0);
    }

    /**
     * Used to fetch only deleted records
     */
    public function deleted()
    {
        $this->db->where('deleted',1);
    }

    /**
     * Used to fetch latest records first
     */
    public function latest($table = null)
    {

        if($table != null)
        {
            $this->db->order_by($table.".id",'desc');
        }else{
            $this->db->order_by('id','desc');
        }
    }

    /**
     * Used to fetch only debit entries
     */
    public function with_debit_entries_only()
    {
        $this->db->where('voucher_entries.dr_cr',1);
    }

    /**
     * Used to fetch only credit etnries
     */
    public function with_credit_entries_only()
    {
        $this->db->where('voucher_entries.dr_cr',0);
    }

    /**
     * Used to fetch only purchase vouchers
     */
    public function purchase_vouchers()
    {
        $this->db->where('vouchers.voucher_type','purchase');
    }

    /**
     * Used to fetch only sale vouchers
     */
    public function sale_vouchers()
    {
        $this->db->where('vouchers.voucher_type','sale');
    }

    /**
     * Used to fetch only payment vouchers
     */
    public function payment_vouchers()
    {
        $this->db->where('vouchers.voucher_type','payment');
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function receipt_vouchers()
    {
        $this->db->where('vouchers.voucher_type','receipt');
    }

    /**
     * Used to join vouchers table with voucher_entries table
     */
    public function join_vouchers()
    {
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','left');
    }

    /**
     * Used to select all the sale contents which are needed
     */
    public function select_sale_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as invoice_date, vouchers.summary as invoice_summary,
            voucher_entries.related_customer, voucher_entries.ac_title as product_name, voucher_entries.quantity,
            voucher_entries.cost_per_item, voucher_entries.amount,
            voucher_entries.id as entry_id,

        ");
    }

    /**
     * Used to select all the purchases contents which are needed
     */
    public function select_purchases_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as invoice_date, vouchers.summary as invoice_summary,
            voucher_entries.related_supplier, voucher_entries.ac_title as product_name, voucher_entries.quantity,
            voucher_entries.cost_per_item, voucher_entries.amount,
            voucher_entries.id as entry_id,

        ");
    }

    /**
     * Used to select all the payment(paid) contents which are needed
     */
    public function select_payment_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
        ");
    }

    /**
     * Used to select all the receipt contents which are needed
     */
    public function select_receipt_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
        ");
    }

    /**
     * Used to fetch only today vouchers
     */
    public function today_vouchers()
    {
        $this->db->where(array(
            'vouchers.voucher_date'=>date('Y-m-d'),
        ));
    }


}

?>