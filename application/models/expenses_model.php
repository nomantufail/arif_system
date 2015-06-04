<?php
class Expenses_Model extends Parent_Model {

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
    public function search_expense_history($keys, $sorting_info){
        $this->select_expense_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payable_vouchers();
        $this->with_debit_entries_only();


        /**
         * applying search keys
         **/
        if(isset($keys['voucher_id']) && sizeof($keys['voucher_id']) > 0)
        {
            $this->db->where('vouchers.id',$keys['voucher_id']);
        }

        if(isset($keys['titles']) && sizeof($keys['titles']) > 0)
        {
            die();
            $this->where_ac_titles($keys['titles']);
        }

        if(isset($keys['tankers']) &&sizeof($keys['tankers']) > 0)
        {
            $this->db->where_in('voucher_entries.related_tanker', $keys['tankers']);
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
        $invoices = $this->search_expense_history(array('voucher_id'=>$id), null);
        if(sizeof($invoices) > 0){
            $record = $invoices[0];
            return $record;
        }else{
            return null;
        }
    }

    public function find_payment($id){
        $invoices = $this->search_expense_payment_history(array('voucher_id'=>$id), null);
        if(sizeof($invoices) > 0){
            $record = $invoices[0];
            return $record;
        }else{
            return null;
        }
    }

    public function update_expense_payment($voucher_id)
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

        $this->db->trans_start();

        /**
         * Updating the voucher data
         **/
        $this->editing_model->update_voucher(array('vouchers.id'=>$voucher_id),$voucher);
        /*------------------------------------------*/



        /*---------Updating voucher Entries--------*/
        $voucher_entries_1 = array();
        $voucher_entries_1['amount'] = $this->input->post('amount');


        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
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

    public function update_expense($voucher_id)
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        // making voucher
        $voucher = array();
        $voucher['voucher_date'] = $this->input->post('expense_date');
        $voucher['summary'] = $this->input->post('summary');

        $this->db->trans_start();

        /**
         * Updating the voucher data
         **/
        $this->editing_model->update_voucher(array('vouchers.id'=>$voucher_id),$voucher);
        /*------------------------------------------*/



        /*---------Updating voucher Entries--------*/
        $voucher_entries_1 = array();
        $voucher_entries_1['related_tanker'] = $this->input->post('tanker');
        $voucher_entries_1['amount'] = $this->input->post('amount');


        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.related_tanker !='=>'',
        ),$voucher_entries_1);

        $voucher_entry_2 = array();
        $voucher_entry_2['ac_title'] = $this->input->post('expense_title');

        $this->editing_model->update_voucher_entries(array(
            'voucher_entries.voucher_id'=>$voucher_id,
            'voucher_entries.dr_cr'=>1,
        ),$voucher_entry_2);

        /*----------------------------------*/

        return $this->db->trans_complete();

    }

    public function insert(){
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('expense_date');
        $voucher->summary = $this->input->post('summary');
        $voucher->voucher_type = 'expense_payable';

        $voucher_entries = array();


        /*---------First ENTRY--------*/
        $voucher_entry_1 = new App_voucher_Entry();
        $voucher_entry_1->ac_title = $this->input->post('expense_title');
        $voucher_entry_1->ac_sub_title = '';
        $voucher_entry_1->ac_type = 'expense';
        $voucher_entry_1->related_tanker = $this->input->post('tanker');
        $voucher_entry_1->amount = $this->input->post('amount');
        $voucher_entry_1->dr_cr = 1;

        array_push($voucher_entries, $voucher_entry_1);
        /*----------------------------------*/

        /*---------Second ENTRY--------*/
        $voucher_entry_2 = new App_voucher_Entry();
        $voucher_entry_2->ac_title = 'expense a/c';
        $voucher_entry_2->ac_sub_title = '';
        $voucher_entry_2->ac_type = 'payable';
        $voucher_entry_2->related_business = $this->admin_model->business_name();
        $voucher_entry_2->amount = $this->input->post('amount');
        $voucher_entry_2->dr_cr = 0;
        $voucher_entry_2->description = $this->input->post('expense_title');

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

    public function few_expenses()
    {
        $this->select_expense_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payable_vouchers();
        $this->with_debit_entries_only();
        $this->db->limit(10);
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }

    public function today_expenses()
    {
        $this->select_expense_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payable_vouchers();
        $this->with_debit_entries_only();
        $this->voucher_duration(date('Y-m-d'),date('Y-m-d'));
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }


    public function insert_payment()
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('voucher_date');
        $voucher->summary = $this->input->post('summary');
        $voucher->voucher_type = 'expense payment';

        $voucher_entries = array();

        $bank_account = $this->input->post('bank_ac');
        $bank_account_parts = explode('_&&_',$bank_account);
        $account_title = $bank_account_parts[0];
        $sub_title = $bank_account_parts[1];

        /*---------First ENTRY--------*/
        $voucher_entry_1 = new App_voucher_Entry();
        $voucher_entry_1->ac_title = 'expense a/c';
        $voucher_entry_1->ac_sub_title = '';
        $voucher_entry_1->ac_type = 'payable';
        $voucher_entry_1->related_business = $this->admin_model->business_name();
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
    public function search_expense_payment_history($keys, $sorting_info)
    {
        $this->select_expense_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payment_vouchers();
        $this->with_credit_entries_only();
        /**
         * applying search keys
         **/
        if(isset($keys['voucher_id']) && sizeof($keys['voucher_id']) > 0)
        {
            $this->db->where('vouchers.id',$keys['voucher_id']);
        }

        if(isset($keys['bank_acs']) &&sizeof($keys['bank_acs']) > 0)
        {
            $this->db->where_in('voucher_entries.ac_title', $keys['bank_acs']);
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
    public function payment_history()
    {
        $this->select_expense_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payment_vouchers();
        $this->with_credit_entries_only();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }

    public function few_payments()
    {
        $this->select_expense_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payment_vouchers();
        $this->with_credit_entries_only();
        $this->db->limit(10);
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
    }

    public function total_expense($from, $to)
    {
        $this->db->select("SUM(voucher_entries.amount) as total_expense");
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->expense_payable_vouchers();
        $this->with_debit_entries_only();
        $result = $this->db->get()->result();

        return ($result[0]->total_expense != null)?round(doubleval($result[0]->total_expense), 3): 0;
    }

    public function sortable_columns($area)
    {
        switch($area)
        {
            case "expenses":
                return array(
                    'invoice_number'=>'vouchers.id',
                    'invoice_date'=>'vouchers.voucher_date',
                    'tanker'=>'voucher_entries.related_tanker',
                    'title'=>'voucher_entries.ac_title',
                    'amount'=>'voucher_entries.amount',
                    'summary'=>'vouchers.summary',
                );
            break;

            case "expense_payments":
                return array(
                    'invoice_number'=>'vouchers.id',
                    'invoice_date'=>'vouchers.voucher_date',
                    'bank'=>'voucher_entries.ac_title',
                    'amount'=>'voucher_entries.amount',
                    'summary'=>'vouchers.summary',
                );
        }
    }
}