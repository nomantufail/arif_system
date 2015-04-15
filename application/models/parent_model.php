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
     * Used to join vouchers table with voucher_entries table
     */
    public function join_vouchers()
    {
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','left');
    }

}

?>