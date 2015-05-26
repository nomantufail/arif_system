<?php
class Deleting_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
    }

    public function force_delete_where($table, $where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }

    public function delete_product($name)
    {
        $product = $this->products_model->get_where(array('name'=>$name));
        $this->db->trans_start();
        if($product != null)
        {
            $this->deleting_model->force_delete_where('products', array('id'=>$product->id));
            $this->deleting_model->force_delete_where('stock',array('product_id'=>$product->id));
        }
        return $this->db->trans_complete();

    }
    public function delete_tanker($number)
    {
        $this->db->trans_start();
        $this->deleting_model->force_delete_where('tankers', array('number'=>$number));
        $this->deleting_model->force_delete_where('stock',array('tanker'=>$number));
        return $this->db->trans_complete();

    }

    public function delete_purchase_invoice($invoice_number)
    {
        $this->db->select('voucher_entries.ac_title as product_name, voucher_entries.quantity,
            vouchers.tanker,
        ');
        $this->join_vouchers();
        $this->active();
        $this->db->where('vouchers.id',$invoice_number);
        $this->with_debit_entries_only();
        $result = $this->db->get('vouchers')->result();
        if($result != null)
        {
            $stock_entries = array();
            foreach($result as $record){
                /*----------Managing Stack-------------*/
                $stock_entry['product_name']=$record->product_name;
                $stock_entry['quantity']=$record->quantity;
                $stock_entry['tanker'] = $record->tanker;
                array_push($stock_entries, $stock_entry);
                /*------------------------------------*/
            }

            $this->db->trans_start();
            $this->stock_model->decrease($stock_entries);
            $this->deleting_model->delete_voucher($invoice_number);
            return $this->db->trans_complete();

        }
        return true;
    }

    public function delete_sale_invoice($invoice_number)
    {
        $this->db->select('voucher_entries.ac_title as product_name, voucher_entries.quantity,
            vouchers.tanker,
        ');
        $this->join_vouchers();
        $this->active();
        $this->db->where('vouchers.id',$invoice_number);
        $this->with_debit_entries_only();
        $result = $this->db->get('vouchers')->result();
        if($result != null)
        {

            $stock_entries = array();
            $purchase_id = 0;
            foreach($result as $record){
                /*----------Managing Stack-------------*/

                //getting the price per unit
                $previous_stock = $this->stock_model->get_where(array('price_per_unit','purchase_id'), array(
                    'products.name'=>$record->product_name,
                    'stock.tanker'=>$record->tanker,
                ));
                $cost_per_item = 0;
                if(sizeof($previous_stock) > 0)
                {
                    $cost_per_item = $previous_stock[0]->price_per_unit;
                    $purchase_id = $previous_stock[0]->purchase_id;
                    if($purchase_id == 0)
                    {
                        redirect(page_url());die();
                    }
                }
                /*-------------*/
                $stock_entry['product_name']=$record->product_name;
                $stock_entry['quantity']=$record->quantity;
                $stock_entry['tanker'] = $record->tanker;
                $stock_entry['cost_per_item'] = $cost_per_item;
                array_push($stock_entries, $stock_entry);
                /*------------------------------------*/
            }

            $this->db->trans_start();
            $this->stock_model->increase($stock_entries, $purchase_id);
            $this->deleting_model->delete_voucher($invoice_number);
            return $this->db->trans_complete();

        }
        return true;
    }

    public function delete_product_and_freight_sale_invoice($invoice_number)
    {
        $this->db->trans_start();
        $this->delete_sale_invoice($invoice_number);

        $this->db->select('vouchers.id');
        $this->db->where('vouchers.product_sale_id',$invoice_number);
        $result = $this->db->get('vouchers')->result();
        $freight_ids = array(0,);
        foreach($result as $record)
        {
            array_push($freight_ids, $record->id);
        }

        $this->delete_vouchers($freight_ids);
        return $this->db->trans_complete();
    }

    public function delete_payment_invoice($invoice_number)
    {
        $this->db->trans_start();
        $this->delete_voucher($invoice_number);
        return $this->db->trans_complete();
    }

    public function delete_receipt_invoice($invoice_number)
    {
        $this->db->trans_start();
        $this->delete_voucher($invoice_number);
        return $this->db->trans_complete();
    }

    public function delete_expense_invoice($invoice_number)
    {
        $this->db->trans_start();
        $this->delete_voucher($invoice_number);
        return $this->db->trans_complete();
    }

    public function delete_expense_payment_invoice($invoice_number)
    {
        $this->db->trans_start();
        $this->delete_voucher($invoice_number);
        return $this->db->trans_complete();
    }

    public function delete_voucher($voucher_number)
    {
        $data = array(
            'deleted'=>1,
            'deleted_at'=>current_time(),
        );
        $this->db->where('vouchers.id',$voucher_number);
        return $this->db->update('vouchers',$data);
    }
    public function delete_vouchers($voucher_ids)
    {
        $data = array(
            'deleted'=>1,
            'deleted_at'=>current_time(),
        );
        $this->db->where_in('vouchers.id',$voucher_ids);
        return $this->db->update('vouchers',$data);
    }
}

?>