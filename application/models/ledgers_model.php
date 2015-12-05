<?php
class Ledgers_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();

        $this->table = 'vouchers';
    }

    public function opening_balance_of_bank_accounts($keys)
    {
        if($keys['ac_title'] == '')
        {
            $bank_account_titles = $this->bank_ac_model->formatted_bank_ac_titles();
        }

        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.voucher_date <',$keys['from']);

        if($keys['ac_title'] != '')
        {
            $this->where_ac_title($keys['ac_title']);
        }else{
            $this->bank_account_titles($bank_account_titles);
        }
        if($keys['ac_type'] != '')
        {
            $this->where_ac_type($keys['ac_type']);
        }
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $opening_balance = $this->fetch_opening_balance($result);
        return $opening_balance;
    }

    public function opening_balance_of_withdrawl_accounts($keys)
    {
        if($keys['ac_title'] == '')
        {
            $withdraw_account_titles = $this->withdrawls_model->withdraw_account_titles();
        }
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.voucher_date <',$keys['from']);

        if($keys['ac_title'] != '')
        {
            $this->where_ac_title($keys['ac_title']);
        }else{
            $this->withdraw_titles($withdraw_account_titles);
        }
        if($keys['ac_type'] != '')
        {
            $this->where_ac_type($keys['ac_type']);
        }
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $opening_balance = $this->fetch_opening_balance($result);
        return $opening_balance;
    }

    function  opening_balance_for_cash_ledgers($from)
    {
        $this->db->select("
            (SUM(debit_amount) - SUM(credit_amount)) as opening_balance
        ");
        $this->db->where('voucher_date <', $from);
        $result = $this->db->get('cash_ledgers')->result();
        return doubleval($result[0]->opening_balance);die();
    }

    public function opening_balance($ledger, $keys)
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.voucher_date <',$keys['from']);
        switch($ledger)
        {
            case "customers":
                $this->get_customer_vouchers();
                if(isset($keys['customer']) && $keys['customer'] != '')
                    $this->where_customer($keys['customer']);
                break;
            case "suppliers":
                $this->get_supplier_vouchers();
                if(isset($keys['supplier']) && $keys['supplier'] != '')
                    $this->where_supplier($keys['supplier']);
                break;
            case "tankers":
                $this->get_tanker_vouchers();
                if(isset($keys['tanker']) && $keys['tanker'] != '')
                    $this->where_tanker($keys['tanker']);
                break;
        }
        if($keys['ac_title'] != '')
        {
            $this->where_ac_title($keys['ac_title']);
        }
        if($keys['ac_type'] != '')
        {
            $this->where_ac_type($keys['ac_type']);
        }
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $opening_balance = $this->fetch_opening_balance($result);
        return $opening_balance;
    }

    public function customer_ledger($keys, $sorting_info = null)
    {
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($keys['from'], $keys['to']);
        $this->get_customer_vouchers();
        if($keys['customer'] != '')
            $this->where_customer($keys['customer']);

        if($keys['ac_title'] != '')
            $this->where_ac_title($keys['ac_title']);

        if($keys['ac_type'] != '')
            $this->where_ac_type($keys['ac_type']);

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

    public function products_ledger($keys, $sorting_info = null)
    {
        /**
         * getting products
         **/
        $result = $this->products_model->get();
        $products = property_to_array('name',$result);

        /**
         * fetching ledgers..
         **/
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();

        if($keys['from'] != '')
            $this->db->where('vouchers.voucher_date >=',$keys['from']);
        if($keys['to'] != '')
            $this->db->where('vouchers.voucher_date <=',$keys['to']);

        $this->db->where_in('ac_title', $products);

        if($keys['ac_title'] != '')
            $this->where_ac_title($keys['ac_title']);

        if($keys['ac_type'] != '')
            $this->where_ac_type($keys['ac_type']);

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

    public function supplier_ledger($keys, $sorting_info = null)
    {
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($keys['from'], $keys['to']);
        $this->get_supplier_vouchers();
        if($keys['supplier'] != '')
            $this->where_supplier($keys['supplier']);

        if($keys['ac_title'] != '')
            $this->where_ac_title($keys['ac_title']);

        if($keys['ac_type'] != '')
            $this->where_ac_type($keys['ac_type']);

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
    public function tanker_ledger($keys)
    {
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($keys['from'], $keys['to']);
        $this->get_tanker_vouchers();
        if($keys['tanker'] != '')
            $this->where_tanker($keys['tanker']);

        if($keys['ac_title'] != '')
            $this->where_ac_title($keys['ac_title']);

        if($keys['ac_type'] != '')
            $this->where_ac_type($keys['ac_type']);

        $result = $this->db->get()->result();
        return $result;
    }

    public function bank_ac_ledger($keys, $sorting_info = null)
    {
        if($keys['ac_title'] == '')
        {
            $bank_account_titles = $this->bank_ac_model->formatted_bank_ac_titles();
        }
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($keys['from'], $keys['to']);

        if($keys['ac_title'] != '')
        {
            $this->where_ac_title($keys['ac_title']);
        }
        else
        {
            $this->bank_account_titles($bank_account_titles);
        }


        if($keys['ac_type'] != '')
            $this->where_ac_type($keys['ac_type']);

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

    public function withdrawls_ledger($keys, $sorting_info = null)
    {
        if($keys['ac_title'] == '')
        {
            $withdraw_account_titles = $this->withdrawls_model->withdraw_account_titles();
        }
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($keys['from'], $keys['to']);

        if($keys['ac_title'] != ''){
            $this->where_ac_title($keys['ac_title']);
        }
        else{
            $this->withdraw_titles($withdraw_account_titles);

        }

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
    /*********************************/

    public function cash_ledgers($keys = null, $sorting_info = null)
    {
        $this->db->select('*');
        if($keys != null){
            if($keys['from'] != ''){
                $this->db->where('voucher_date >=', $keys['from']);
            }
            if($keys['to'] != ''){
                $this->db->where('voucher_date <=', $keys['to']);
            }
        }

        /**
         * Sorting Section
         **/
        if($sorting_info != null)
        {
            $this->db->order_by($sorting_info['sort_by'],$sorting_info['order_by']);
        }
        /*------ Sorting Section Ends ------*/

        $result = $this->db->get('cash_ledgers')->result();
        return $result;
    }

    public function sortable_columns($section)
    {
        $columns = [];
        switch($section)
        {
            case "customers":
                $columns['voucher_id'] = 'vouchers.id';
                $columns['voucher_date'] = 'vouchers.voucher_date';
                break;
            case "suppliers":
                $columns['voucher_id'] = 'vouchers.id';
                $columns['voucher_date'] = 'vouchers.voucher_date';
                break;
            case "tankers":
                $columns['voucher_id'] = 'vouchers.id';
                $columns['voucher_date'] = 'vouchers.voucher_date';
                break;
            case "bank_accounts":
                $columns['voucher_id'] = 'vouchers.id';
                $columns['voucher_date'] = 'vouchers.voucher_date';
                break;
            case "withdrawls":
                $columns['voucher_id'] = 'vouchers.id';
                $columns['voucher_date'] = 'vouchers.voucher_date';
                break;
            case "cash":
                $columns['voucher_id'] = 'voucher_id';
                $columns['voucher_date'] = 'voucher_date';
                break;
        }
        return $columns;
    }

}

?>