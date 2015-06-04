<?php
class Withdrawls_model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "vouchers";
    }

    public function get(){
        $this->select_expense_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payable_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }
    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);
        
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function count($keys = "") {
        if($keys != "")
        {
            //search queries here
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function find($id){
        $invoices = $this->search_withdrawls_history(array('voucher_id'=>$id), null);
        if(sizeof($invoices) > 0){
            $record = $invoices[0];
            return $record;
        }else{
            return null;
        }
    }
    public function update_withdraw($voucher_id)
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
        $voucher_entries_1['ac_title'] = $this->input->post('withdraw_account');
        $voucher_entries_1['amount'] = $this->input->post('amount');


        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.dr_cr'=>1,
        ),$voucher_entries_1);

        $voucher_entry_2 = array();
        $voucher_entry_2['ac_sub_title'] = $sub_title;
        $voucher_entry_2['ac_title'] = $account_title;
        $voucher_entry_2['amount'] = $this->input->post('amount');

        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.dr_cr'=>0,
        ),$voucher_entry_2);

        /*----------------------------------*/

        return $this->db->trans_complete();

    }
    public function withdraw(){
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $bank_account = $this->input->post('bank_ac');
        $bank_account_parts = explode('_&&_',$bank_account);
        $account_title = $bank_account_parts[0];
        $sub_title = $bank_account_parts[1];

        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('voucher_date');
        $voucher->summary = $this->input->post('summary');
        $voucher->voucher_type = 'withdraw';
        $voucher->bank_ac = $account_title;

        $voucher_entries = array();


        /*---------First ENTRY--------*/
        $voucher_entry_1 = new App_voucher_Entry();
        $voucher_entry_1->ac_title = $this->input->post('withdraw_account');
        $voucher_entry_1->ac_sub_title = '';
        $voucher_entry_1->ac_type = 'dividend';
        $voucher_entry_1->amount = $this->input->post('amount');
        $voucher_entry_1->dr_cr = 1;

        array_push($voucher_entries, $voucher_entry_1);
        /*----------------------------------*/

        /*---------Second ENTRY--------*/
        $voucher_entry_2 = new App_voucher_Entry();
        $voucher_entry_2->ac_title = $account_title;
        $voucher_entry_2->ac_sub_title = $sub_title;
        $voucher_entry_2->ac_type = 'bank';
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

    public function search_withdrawls_history($keys, $sorting_info)
    {
        $this->select_withdraw_voucher_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->with_debit_entries_only();
        $this->withdraw_vouchers();

        /**
         * applying search keys
         **/
        if(isset($keys['voucher_id']) && sizeof($keys['voucher_id']) > 0)
        {
            $this->db->where('vouchers.id',$keys['voucher_id']);
        }

        if(isset($keys['withdraw_accounts']) && sizeof($keys['withdraw_accounts']) > 0)
        {
            $this->where_ac_titles($keys['withdraw_accounts']);
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
    public function withdraw_history()
    {
        include_once(APPPATH."models/helperClasses/Withdraw_Entry.php");

        $this->select_withdraw_voucher_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->withdraw_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }

    public function few_withdrawls()
    {
        include_once(APPPATH."models/helperClasses/Withdraw_Entry.php");

        $this->select_whole_voucher_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->withdraw_vouchers();
        $this->db->limit(10);
        $this->latest($this->table);
        $result = $this->db->get()->result();

        $journal = $this->accounts_model->make_vouchers_from_raw($result);
        $withdrawls = array();
        foreach($journal as $voucher)
        {
            array_push($withdrawls, new Withdraw_Entry($voucher));
        }
        return $withdrawls;
    }
    public function today_withdrawls()
    {
        include_once(APPPATH."models/helperClasses/Withdraw_Entry.php");

        $this->select_whole_voucher_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->withdraw_vouchers();
        $this->voucher_duration(date('Y-m-d'), date('Y-m-d'));
        $this->latest($this->table);
        $result = $this->db->get()->result();

        $journal = $this->accounts_model->make_vouchers_from_raw($result);
        $withdrawls = array();
        foreach($journal as $voucher)
        {
            array_push($withdrawls, new Withdraw_Entry($voucher));
        }
        return $withdrawls;
    }

    public function accounts()
    {
        $this->select_withdraw_accounts_content();
        $this->db->from('withdraw_accounts');
        $this->db->order_by('title','asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function withdraw_account_titles()
    {
        $accounts = $this->accounts();
        $titles = array();
        foreach($accounts as $account)
        {
            array_push($titles, $account->title);
        }
        return $titles;
    }

    public function add_account()
    {
        $data = array(
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('description'),
        );
        $result = $this->db->insert('withdraw_accounts', $data);
        return $result;
    }

    public function sortable_columns()
    {
        return array(
            'voucher_id'=>'vouchers.id',
            'voucher_date'=>'vouchers.voucher_date',
            'withdraw_account'=>'voucher_entries.ac_title',
            'bank'=>'vouchers.bank_ac',
            'amount'=>'voucher_entries.amount',
            'summary'=>'vouchers.summary',
        );
    }
}