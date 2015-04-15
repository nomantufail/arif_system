<?php
class Accounts_Model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function insert_voucher($voucher)
    {
        $this->db->trans_begin();

        $voucher_data = array(
            'voucher_date'=>$voucher->voucher_date,
            'summary'=>$voucher->summary,
            'voucher_type'=>$voucher->voucher_type,
        );
        $this->db->insert('vouchers',$voucher_data);
        $voucher_id = $this->db->insert_id();

        $voucher_entries = array();
        foreach($voucher->entries as $entry)
        {
            $voucher_entry = array(
                'voucher_id'=>$voucher_id,
                'ac_title'=>$entry->ac_title,
                'ac_sub_title'=>$entry->ac_sub_title,
                'ac_type'=>$entry->ac_type,
                'related_customer'=>$entry->related_customer,
                'related_business'=>$entry->related_business,
                'related_other_agent'=>$entry->related_other_agent,
                'related_supplier'=>$entry->related_supplier,
                'quantity'=>$entry->quantity,
                'cost_per_item'=>$entry->cost_per_item,
                'amount'=>$entry->amount,
                'dr_cr'=>$entry->dr_cr,
                'description'=>$entry->description,
            );
            array_push($voucher_entries, $voucher_entry);
        }

        /**
        * Checking voucher entries are validated or not!
        **/
        if($this->db->trans_status() == false
            || sizeof($voucher_entries)%2 != 0
            || sizeof($voucher_entries) == 0
            || $voucher->balance() != 0)
        {
            $this->db->trans_rollback();
            return false;
        }
        /*----------Check Complete--------------*/

        /*--------Inserting The Voucher Entries-----------*/
        $this->db->insert_batch('voucher_entries',$voucher_entries);
        /*------------------------------------------------*/

        if($this->db->trans_status() == false)
        {
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $voucher_id;
        }

        return false;
    }
}

?>