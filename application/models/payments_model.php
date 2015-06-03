<?php
class Payments_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();

        $this->table = "vouchers";
    }

    public function total_payables($from, $to)
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->payables();
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $total_debit = 0;
        $total_credit = 0;

        if(sizeof($result) > 0)
        {
            foreach($result as $record)
            {
                if($record->dr_cr == 1)
                {
                    $total_debit = $record->total_amount;
                }
                else if($record->dr_cr == 0)
                {
                    $total_credit = $record->total_amount;
                }
            }
        }

        return round($total_credit - $total_debit, 3);
    }

    public function insert_payment()
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $bank_account = $this->input->post('bank_ac');
        $bank_account_parts = explode('_&&_',$bank_account);
        $account_title = $bank_account_parts[0];
        $sub_title = $bank_account_parts[1];

        // making voucher
        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('voucher_date');
        $voucher->summary = $this->input->post('summary');
        $voucher->voucher_type = 'payment';
        $voucher->bank_ac = $account_title;

        $voucher_entries = array();



        /*---------First ENTRY--------*/
        $voucher_entry_1 = new App_voucher_Entry();
        $voucher_entry_1->ac_title = 'cash';
        $voucher_entry_1->ac_sub_title = '';
        $voucher_entry_1->ac_type = 'payable';
        $voucher_entry_1->related_supplier = $this->input->post('supplier');
        $voucher_entry_1->amount = $this->input->post('amount');
        $voucher_entry_1->dr_cr = 1;

        array_push($voucher_entries, $voucher_entry_1);
        /*----------------------------------*/

        /*---------Second ENTRY--------*/
        $voucher_entry_2 = new App_voucher_Entry();
        $voucher_entry_2->ac_title = $account_title;
        $voucher_entry_2->ac_sub_title = $sub_title;
        $voucher_entry_2->ac_type = 'bank';
        $voucher_entry_2->related_business = $this->admin_model->business_name();
        $voucher_entry_2->amount = $this->input->post('amount');
        $voucher_entry_2->dr_cr = 0;

        array_push($voucher_entries, $voucher_entry_2);
        /*----------------------------------*/


        /*------------inserting voucher entries in the voucher container---------*/
        $voucher->entries = $voucher_entries;
        /*---------------------------------------------------------------------*/

        /*--------------Lets the game begin---------------*/
        $this->db->trans_begin();

        $voucher_inserted = $this->accounts_model->insert_voucher($voucher);


        if($this->db->trans_status() == false || $voucher_inserted == false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $voucher_inserted;
        }
        return false;
    }


    public function update_payment($voucher_id)
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $bank_account = $this->input->post('bank_ac');
        $bank_account_parts = explode('_&&_',$bank_account);
        $account_title = $bank_account_parts[0];
        $sub_title = $bank_account_parts[1];

        // making voucher
        $voucher = array();
        $voucher['voucher_date'] = $this->input->post('voucher_date');
        $voucher['summary'] = $this->input->post('summary');
        $voucher['bank_ac'] = $account_title;

        $this->db->trans_start();

        /**
         * Updating the voucher data
         **/
        $this->editing_model->update_voucher(array('vouchers.id'=>$voucher_id),$voucher);
        /*------------------------------------------*/



        /*---------Updating voucher Entries--------*/
        $voucher_entries_1 = array();
        $voucher_entries_1['related_supplier'] = $this->input->post('supplier');
        $voucher_entries_1['amount'] = $this->input->post('amount');


        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.related_supplier !='=>'',
        ),$voucher_entries_1);

        $voucher_entry_2 = array();
        $voucher_entry_2['ac_sub_title'] = $sub_title;
        $voucher_entry_2['ac_title'] = $account_title;

        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.dr_cr'=>0,
        ),$voucher_entry_2);

        /*----------------------------------*/

        return $this->db->trans_complete();

    }

    public function payment_history()
    {
        $this->select_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->with_debit_entries_only();
        $this->payment_vouchers();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }
    public function search_payment_history($keys, $sorting_info)
    {
        $this->select_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->with_debit_entries_only();
        $this->payment_vouchers();

        /**
         * applying search keys
         **/
        if(isset($keys['voucher_id']) && sizeof($keys['voucher_id']) > 0)
        {
            $this->db->where('vouchers.id',$keys['voucher_id']);
        }

        if(isset($keys['suppliers']) && sizeof($keys['suppliers']) > 0)
        {
            $this->where_related_suppliers($keys['suppliers']);
        }

        if(isset($keys['bank_acs']) &&sizeof($keys['bank_acs']) > 0)
        {
            $this->db->where_in('vouchers.bank_ac', $keys['bank_acs']);
        }

        if(isset($keys['to']) &&$keys['to'] != '')
        {
            $this->db->where('vouchers.voucher_date <=',$keys['to']);
        }
        if(isset($keys['from']) &&$keys['from'] != '')
        {
            $this->db->where('vouchers.voucher_date >=',$keys['from']);
        }
        /*------- End Of Search Keys-----*/

        /**
         * Sorting Section
         **/
        if($sorting_info != null)
        {
            $this->db->order_by($sorting_info['sort_by'],$sorting_info['order_by']);
        }
        /*------ Sorting Section Ends ------*/


        $result = $this->db->get()->result();

        return $result;
    }

    public function few_payments()
    {
        $this->select_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->with_debit_entries_only();
        $this->payment_vouchers();
        $this->db->limit(10);
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }

    public function today_payments() //paid vouchers
    {
        $this->select_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->with_debit_entries_only();
        $this->payment_vouchers();
        $this->today_vouchers();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }

    public function find($id){
        $invoices = $this->search_payment_history(array('voucher_id'=>$id), null);
        if(sizeof($invoices) > 0){
            $record = $invoices[0];
            return $record;
        }else{
            return null;
        }
    }

    public function sortable_columns()
    {
        return array(
            'invoice_number'=>'vouchers.id',
            'invoice_date'=>'vouchers.voucher_date',
            'supplier'=>'voucher_entries.related_supplier',
            'bank'=>'vouchers.bank_ac',
            'product'=>'voucher_entries.ac_title',
            'amount'=>'voucher_entries.amount',
            'summary'=>'vouchers.summary',
        );
    }
}

?>