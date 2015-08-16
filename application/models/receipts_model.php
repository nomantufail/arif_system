<?php
class Receipts_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();

        $this->table = "vouchers";
    }

    public function total_receivables($from, $to)
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->receivables();
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

        return round($total_debit - $total_credit, 3);
    }

    public function update_receipt($voucher_id)
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $agent_type = $this->input->post('agent_type');
        $agent = $this->input->post('agent');
        $payment_account = $this->input->post('account');
        $sub_title = "";
        if($payment_account != 'cash')
        {
            $bank_account_parts = explode('_&&_',$payment_account);
            $account_title = $bank_account_parts[0];
            $sub_title = ($bank_account_parts[1]);
        }else{
            $account_title = $payment_account;
        }


        // making voucher
        $voucher = array();
        $voucher['voucher_date'] = $this->input->post('voucher_date');
        $voucher['summary'] = $this->input->post('summary');
        $voucher['bank_ac'] = ($account_title != 'cash')?$account_title:'';

        $this->db->trans_start();

        /**
         * Updating the voucher data
         **/
        $this->editing_model->update_voucher(array('vouchers.id'=>$voucher_id),$voucher);
        /*------------------------------------------*/




        /*---------Updating voucher Entries--------*/


        $voucher_entry_1 = array();
        $voucher_entry_1['ac_sub_title'] = $sub_title;
        $voucher_entry_1['ac_title'] = $account_title;
        $voucher_entry_1['ac_type'] = ($account_title == "cash")?'cash':'bank';
        $voucher_entry_1['amount'] = $this->input->post('amount');

        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.dr_cr'=>1,
            'voucher_entries.deleted'=>0,
        ),$voucher_entry_1);


        $voucher_entry_2 = array();
        if($agent_type == 'customer'){
            $voucher_entry_2['ac_type'] = 'receivable';
            $voucher_entry_2['related_customer'] = $agent;
            $voucher_entry_2['related_supplier'] = "";
        }
        else if($agent_type == 'supplier'){
            $voucher_entry_2['ac_type'] = 'payable';
            $voucher_entry_2['related_supplier'] = $agent;
            $voucher_entry_2['related_customer'] = "";
        }
        $voucher_entry_2['amount'] = $this->input->post('amount');

        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.dr_cr'=>0,
            'voucher_entries.deleted'=>0,
        ),$voucher_entry_2);

        /*----------------------------------*/

        return $this->db->trans_complete();

    }

    public function insert_receipt()
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");


        $agent_type = $this->input->post('agent_type');
        $agent = $this->input->post('agent');
        $payment_account = $this->input->post('account');
        $sub_title = "";
        if($payment_account != 'cash')
        {
            $bank_account_parts = explode('_&&_',$payment_account);
            $account_title = $bank_account_parts[0];
            $sub_title = ($bank_account_parts[1]);
        }else{
            $account_title = $payment_account;
        }

        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('voucher_date');
        $voucher->summary = $this->input->post('summary');
        $voucher->voucher_type = 'receipt';
        $voucher->bank_ac = ($payment_account != 'cash')?$account_title:'';

        $voucher_entries = array();

        /*---------First ENTRY--------*/
        $voucher_entry_2 = new App_voucher_Entry();
        $voucher_entry_2->ac_title = $account_title;
        $voucher_entry_2->ac_sub_title = $sub_title;
        $voucher_entry_2->ac_type = ($account_title != 'cash')?'bank':'cash';
        $voucher_entry_2->related_business = $this->admin_model->business_name();
        $voucher_entry_2->amount = $this->input->post('amount');
        $voucher_entry_2->dr_cr = 1;

        array_push($voucher_entries, $voucher_entry_2);
        /*----------------------------------*/

        /*---------Second ENTRY--------*/
        $voucher_entry_2 = new App_voucher_Entry();
        $voucher_entry_2->ac_title = 'receipt';
        $voucher_entry_2->ac_sub_title = '';

        if($agent_type == 'customer'){
            $voucher_entry_2->ac_type = 'receivable';
            $voucher_entry_2->related_customer = $agent;
        }
        else if($agent_type == 'supplier'){
            $voucher_entry_2->ac_type = 'payable';
            $voucher_entry_2->related_supplier = $agent;
        }

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

    public function search_receipt_history($keys, $sorting_info)
    {
        $this->db->select("*");
        /**
         * applying search keys
         **/
        if(isset($keys['voucher_id']) && sizeof($keys['voucher_id']) > 0)
        {
            $this->db->where('voucher_id',$keys['voucher_id']);
        }

        if(isset($keys['suppliers']) && sizeof($keys['suppliers']) > 0)
        {
            $this->db->where('agent_type' , 'supplier');
            $this->db->where_in('agent', $keys['suppliers']);
        }

        if(isset($keys['customers']) && sizeof($keys['customers']) > 0)
        {
            $this->db->where('agent_type' , 'customer');
            $this->db->where_in('agent', $keys['customers']);
        }

        if(isset($keys['accounts']) &&sizeof($keys['accounts']) > 0)
        {
            $this->db->where_in('account', $keys['accounts']);
        }

        if(isset($keys['to']) &&$keys['to'] != '')
        {
            $this->db->where('voucher_date <=',$keys['to']);
        }
        if(isset($keys['from']) &&$keys['from'] != '')
        {
            $this->db->where('voucher_date >=',$keys['from']);
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


        $result = $this->db->get('receipts_view')->result();

        return $result;
    }

    public function receipt_history()
    {
        return $this->db->get('receipts_view')->result();
    }

    public function few_receipts()
    {
        $this->db->select('*');
        $this->db->order_by('voucher_id','desc');
        $this->db->limit(10);
        $result = $this->db->get('receipts_view')->result();
        return $result;
    }

    public function today_receipts() //paid vouchers
    {
        $this->select_receipt_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->receipt_vouchers();
        $this->with_credit_entries_only();
        $this->today_vouchers();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }

    public function find($id){
        $invoices = $this->db->get_where('receipts_view',array('voucher_id'=>$id))->result();
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
            'customer'=>'voucher_entries.related_customer',
            'bank'=>'vouchers.bank_ac',
            'amount'=>'voucher_entries.amount',
            'summary'=>'vouchers.summary',
        );
    }
}

?>