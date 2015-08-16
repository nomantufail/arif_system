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
                if($keys['customer'] != '')
                    $this->where_customer($keys['customer']);
                break;
            case "suppliers":
                $this->get_supplier_vouchers();
                if($keys['supplier'] != '')
                    $this->where_supplier($keys['supplier']);
                break;
            case "tankers":
                $this->get_tanker_vouchers();
                if($keys['tanker'] != '')
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

    public function customer_ledger($keys)
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

        $result = $this->db->get()->result();
        return $result;
    }

    public function supplier_ledger($keys)
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

    public function bank_ac_ledger($keys)
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

        $result = $this->db->get()->result();
        return $result;
    }

    public function withdrawls_ledger($keys)
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

        $result = $this->db->get()->result();
        return $result;
    }
    /*********************************/


}

?>