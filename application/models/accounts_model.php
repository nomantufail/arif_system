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

    public function make_vouchers_from_raw($raw_entries)
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");
        include_once(APPPATH."models/helperClasses/Supplier.php");

        $final_voucher_array = array();

        $previous_voucher_id = -1;
        $previous_entry_id = -1;

        $temp_voucher = new App_Voucher();
        $temp_voucher_entry = new App_voucher_Entry($temp_voucher);

        $count = 0;
        foreach($raw_entries as $record){
            $count++;

            //setting the parent details
            if($record->voucher_id != $previous_voucher_id)
            {
                $previous_voucher_id = $record->voucher_id;

                $temp_voucher = new App_voucher();

                //setting data in the parent object
                $temp_voucher->id = $record->voucher_id;
                $temp_voucher->voucher_date = $record->voucher_date;
                $temp_voucher->summary = $record->summary;

            }/////////////////////////////////////////////////

            /////////////////////////////////////////////////
            if($record->entry_id != $previous_entry_id)
            {
                $previous_entry_id = $record->entry_id;

                $temp_voucher_entry = new App_voucher_Entry($temp_voucher);

                //setting data in the Trip_Product_Data object
                $temp_voucher_entry->id = $record->entry_id;
                $temp_voucher_entry->ac_title = $record->ac_title;
                $temp_voucher_entry->ac_sub_title = $record->ac_sub_title;
                $temp_voucher_entry->related_supplier = $record->related_supplier;
                $temp_voucher_entry->related_customer = $record->related_customer;
                $temp_voucher_entry->related_business = $record->related_business;
                $temp_voucher_entry->related_other_agent = $record->related_other_agent;
                $temp_voucher_entry->amount = $record->amount;
                $temp_voucher_entry->dr_cr = $record->dr_cr;
            }/////////////////////////////////////////////////

            //pushing particals
            if($count != sizeof($raw_entries)){
                if($raw_entries[$count]->entry_id != $record->entry_id){
                    array_push($temp_voucher->entries, $temp_voucher_entry);
                }
                if($raw_entries[$count]->voucher_id != $record->voucher_id){
                    array_push($final_voucher_array, $temp_voucher);
                }
            }else{
                array_push($temp_voucher->entries, $temp_voucher_entry);
                array_push($final_voucher_array, $temp_voucher);
            }
        }
        return $final_voucher_array;
    }
}

?>