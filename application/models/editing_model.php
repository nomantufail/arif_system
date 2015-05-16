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

    public function update_table_column($table, $property, $value, $key)
    {
        $data = array(
            $property.''=>$value,
        );
        $this->db->where($table.'.'.$property,$key);
        $this->db->update($table,$data);
    }
}

?>