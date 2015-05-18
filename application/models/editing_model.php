<?php
class Editing_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
    }

    public function edit_global_record($table, $pk, $name, $value){
        $this->db->where('id', $pk);
        $data = array(
            $name.'' => $value,
        );
        $result = $this->db->update($table, $data);
        return $result;
    }

    public function edit_product($property, $value, $pk)
    {
        /**
         * ---------------------------------
         * Tables Which will be update on
         * product editing
         * ---------------------------------
         * products ==> name
         * voucher_entries ==> ac_title
         */
        $this->db->trans_start();

        switch($property)
        {
            case "name":
                $this->update_table_column('voucher_entries','ac_title', $value, $pk);
                $this->update_table_column('products', 'name', $value, $pk);
                break;
        }
        return $this->db->trans_complete();
    }

    public function edit_customer($property, $value, $pk)
    {
        /**
         * ---------------------------------
         * Tables Which will be update on
         * Customer editing
         * ---------------------------------
         * customers ==> name
         * voucher_entries ==> related_customer
         */
        $this->db->trans_start();

        switch($property)
        {
            case "name":
                $this->update_table_column('voucher_entries','related_customer', $value, $pk);
                $this->update_table_column('customers', 'name', $value, $pk);
                break;
        }
        return $this->db->trans_complete();
    }

    public function edit_supplier($property, $value, $pk)
    {
        /**
         * ---------------------------------
         * Tables Which will be update on
         * Supplier editing
         * ---------------------------------
         * suppliers ==> name
         * voucher_entries ==> related_supplier
         */
        $this->db->trans_start();

        switch($property)
        {
            case "name":
                $this->update_table_column('voucher_entries','related_supplier', $value, $pk);
                $this->update_table_column('suppliers', 'name', $value, $pk);
                break;
        }
        return $this->db->trans_complete();
    }

    public function edit_tanker($property, $value, $pk)
    {
        /**
         * ---------------------------------
         * Tables Which will be update on
         * Tanker editing
         * ---------------------------------
         * tankers ==> number
         * stock ==> tanker
         * vouchers ==> tanker
         * voucher_entries ==> related_tanker
         */
        $this->db->trans_start();

        switch($property)
        {
            case "number":
                $this->update_table_column('voucher_entries','related_tanker', $value, $pk);
                $this->update_table_column('vouchers', 'tanker', $value, $pk);
                $this->update_table_column('stock', 'tanker', $value, $pk);
                $this->update_table_column('tankers', 'number', $value, $pk);
                break;
        }
        return $this->db->trans_complete();
    }

    public function edit_bank_account($property, $value, $pk)
    {

        /**
         * -------------------------------------
         * Fetching bank account data from DB
         * -------------------------------------
         */
        $bank_ac = $this->bank_ac_model->find($pk);
        $title = $bank_ac->title;
        $number = $bank_ac->account_number;
        $bank = $bank_ac->bank;
        $type = $bank_ac->type;
        $previous_formatted_title = $bank_ac->title." (".$bank_ac->bank." ".bn_masking($bank_ac->account_number).")";

        /**
         * ---------------------------------
         * Tables Which will be update on
         * bank editing
         * ---------------------------------
         * user_bank_accounts ==> complete table
         * voucher_entries ==> ac_title & ac_sub_title
         */
        $this->db->trans_start();

        switch($property)
        {
            case "account_number":
                $formatted_value = $bank_ac->title." (".$bank_ac->bank." ".bn_masking($value).")";

                $this->update_table_column('voucher_entries','ac_title', $formatted_value, $previous_formatted_title);
                $this->edit_global_record('user_bank_accounts', $pk, 'account_number', $value);
                break;

            case "title":

                $formatted_value = $value." (".$bank_ac->bank." ".bn_masking($bank_ac->account_number).")";

                $this->update_table_column('voucher_entries','ac_title', $formatted_value, $previous_formatted_title);
                $this->edit_global_record('user_bank_accounts', $pk, 'title', $value);
                break;

            case "bank":
                $formatted_value = $value." (".$value." ".bn_masking($bank_ac->account_number).")";

                $this->update_table_column('voucher_entries','ac_title', $formatted_value, $previous_formatted_title);
                $this->edit_global_record('user_bank_accounts', $pk, 'bank', $value);
                break;

            case "type":
                $this->update_table_column('user_bank_accounts', 'type', $value, $pk);
                $this->edit_global_record('user_bank_accounts', $pk, 'type', $value);
                break;
        }
        return $this->db->trans_complete();
    }
    public function edit_expense_title($property, $value, $pk)
    {
        /**
         * ---------------------------------
         * Tables Which will be update on
         * Expense Title editing
         * ---------------------------------
         * expense_titles ==> title
         * voucher_entries ==> ac_title
         */
        $this->db->trans_start();

        switch($property)
        {
            case "title":
                $this->update_table_column('voucher_entries','ac_title', $value, $pk);
                $this->update_table_column('expense_titles', 'title', $value, $pk);
                break;
        }
        return $this->db->trans_complete();
    }
    public function edit_withdraw_account_title($property, $value, $pk)
    {
        /**
         * ---------------------------------
         * Tables Which will be update on
         * Withdraw Account Title editing
         * ---------------------------------
         * withdraw_accounts ==> title
         * voucher_entries ==> ac_title
         */
        $this->db->trans_start();

        switch($property)
        {
            case "title":
                $this->update_table_column('voucher_entries','ac_title', $value, $pk);
                $this->update_table_column('withdraw_accounts', 'title', $value, $pk);
                break;
        }
        return $this->db->trans_complete();
    }
    public function update_table_column($table, $property, $value, $key)
    {
        $data = array(
            $property.''=>$value,
        );

        $this->db->where($table.'.'.$property,$key);
        $this->db->update($table,$data);
    }

    public function update_bank_account_type($bank_ac, $type)
    {
        $formatted_title = $bank_ac->title." (".$bank_ac->bank." ".bn_masking($bank_ac->account_number).")";
        $previous_type = $bank_ac->type;

        $this->db->where(array(
            'ac_title'=> $formatted_title,
            'ac_sub_title'=> $previous_type
        ));
        $data = array(
            'ac_sub_title'=>$type,
        );
        $this->db->update('voucher_entries', $data);
    }
}

?>