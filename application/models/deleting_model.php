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

    public function delete_purchase_invoice($invoice_number, $product)
    {
        $this->db->select('voucher_entries.ac_title as product_name, voucher_entries.quantity,
            vouchers.tanker,
        ');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.id',$invoice_number);
        $this->db->where('voucher_entries.ac_title',$product);
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


    public function safely_delete_purchase_invoice_items_where($where)
    {
        $this->db->select('voucher_entries.ac_title as product_name, voucher_entries.quantity,
            vouchers.tanker,
        ');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where($where);
        $this->purchase_vouchers();
        $this->with_debit_entries_only();
        $result = $this->db->get('vouchers')->result();

        if(sizeof($result) > 0)
        {
            $stock_entries = array();

            foreach($result as $entry)
            {
                /*----------Managing Stack-------------*/
                $stock_entry['product_name']=$entry->product_name;
                $stock_entry['quantity']=$entry->quantity;
                $stock_entry['tanker'] = $entry->tanker;
                array_push($stock_entries, $stock_entry);
                /*------------------------------------*/
            }

            $this->db->trans_start();
            $this->stock_model->decrease($stock_entries);
            $this->deleting_model->safely_delete_voucher_items_where($where);
            return $this->db->trans_complete();

        }
        return true;
    }

    public function delete_purchase_invoice_item($invoice_number, $item_id)
    {
        $this->db->select('voucher_entries.ac_title as product_name, voucher_entries.quantity,
            vouchers.tanker,
        ');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.id',$invoice_number);
        $this->db->where('voucher_entries.item_id',$item_id);
        $this->with_debit_entries_only();
        $result = $this->db->get('vouchers')->result();

        $entry = (sizeof($result) > 0)?$result[0]:null;

        if($entry != null)
        {
            $stock_entries = array();
            /*----------Managing Stack-------------*/
            $stock_entry['product_name']=$entry->product_name;
            $stock_entry['quantity']=$entry->quantity;
            $stock_entry['tanker'] = $entry->tanker;
            array_push($stock_entries, $stock_entry);
            /*------------------------------------*/

            $this->db->trans_start();
            $this->stock_model->decrease($stock_entries);
            $this->deleting_model->safely_delete_voucher_items_where(array(
                'voucher_entries.item_id'=>$item_id,
                'voucher_entries.voucher_id'=>$invoice_number,
            ));
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
        $this->active_vouchers();
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

    public function delete_sale_invoice_item($invoice_number, $product)
    {
        $this->db->select('voucher_entries.ac_title as product_name, voucher_entries.quantity,
            vouchers.tanker,
        ');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.id',$invoice_number);
        $this->db->where('voucher_entries.ac_title',$product);
        $this->with_debit_entries_only();
        $result = $this->db->get('vouchers')->result();

        $entry = (sizeof($result) > 0)?$result[0]:null;
        if($entry != null)
        {

            $stock_entries = array();
            $purchase_id = 0;
            /*----------Managing Stack-------------*/

            //getting the price per unit
            $previous_stock = $this->stock_model->get_where(array('price_per_unit','purchase_id'), array(
                'products.name'=>$entry->product_name,
                'stock.tanker'=>$entry->tanker,
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

            /*----------------------------------------*/
            $stock_entry['product_name']=$entry->product_name;
            $stock_entry['quantity']=$entry->quantity;
            $stock_entry['tanker'] = $entry->tanker;
            $stock_entry['cost_per_item'] = $cost_per_item;
            array_push($stock_entries, $stock_entry);
            /*------------------------------------*/

            $this->db->trans_start();
            $this->stock_model->increase($stock_entries, $purchase_id);
            $this->deleting_model->safely_delete_voucher_items_where(array(
                'voucher_entries.ac_title'=>$entry->product_name,
                'voucher_entries.voucher_id'=>$invoice_number,
            ));
            return $this->db->trans_complete();

        }
        return true;
    }

    public function safely_delete_sale_invoice_items_where($where)
    {
        $this->db->select('voucher_entries.ac_title as product_name, voucher_entries.quantity,
            vouchers.tanker,
        ');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where($where);
        $this->with_debit_entries_only();
        $result = $this->db->get('vouchers')->result();

        if(sizeof($result) > 0)
        {

            $stock_entries = array();
            $purchase_id = 0;

            foreach($result as $entry)
            {
                /*----------Managing Stack-------------*/

                //getting the price per unit
                $previous_stock = $this->stock_model->get_where(array('price_per_unit','purchase_id'), array(
                    'products.name'=>$entry->product_name,
                    'stock.tanker'=>$entry->tanker,
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

                /*----------------------------------------*/
                $stock_entry['product_name']=$entry->product_name;
                $stock_entry['quantity']=$entry->quantity;
                $stock_entry['tanker'] = $entry->tanker;
                $stock_entry['cost_per_item'] = $cost_per_item;
                array_push($stock_entries, $stock_entry);
                /*------------------------------------*/
            }


            $this->db->trans_start();
            $this->stock_model->increase($stock_entries, $purchase_id);
            $this->deleting_model->safely_delete_voucher_items_where($where);
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

    public function delete_product_and_freight_sale_invoice_item($invoice_number, $product)
    {
        $this->db->trans_start();
        $this->delete_sale_invoice_item($invoice_number,$product);

        $this->safely_delete_vouchers_where(array(
            'vouchers.product_for_freight_voucher'=>$product,
            'vouchers.product_sale_id'=>$invoice_number,
        ));
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

    public function safely_delete_voucher_items_where($where)
    {
        $this->db->select('voucher_entries.voucher_id');
        $this->db->distinct();
        $this->db->where($where);
        $this->active_voucher_entries();
        $result = $this->db->get('voucher_entries')->result();
        $voucher_ids = array();
        foreach($result as $record)
        {
            array_push($voucher_ids, $record->voucher_id);
        }

        /**
         * Below we will safely remove voucher_entries
         **/
        $this->deleting_model->safely_remove_voucher_entries_where($where);
        /**------------------------------------------------------**/

        /**
         * Below we will see if parent vouchers
         * are needed to be deleted or not.
         **/
        if(sizeof($voucher_ids) > 0)
        {
            $this->db->select("voucher_entries.voucher_id");
            $this->db->distinct();
            $this->db->where_in('voucher_entries.voucher_id',$voucher_ids);
            $this->active_voucher_entries();
            $this->db->group_by('voucher_entries.voucher_id');
            $result = $this->db->get('voucher_entries')->result();

            $voucher_ids_after_deleting_entries = array();
            foreach($result as $record)
            {
                array_push($voucher_ids_after_deleting_entries, $record->voucher_id);
            }

            $deletable_parent_vouchers = array();
            foreach($voucher_ids as $id)
            {
                if(!in_array($id,$voucher_ids_after_deleting_entries))
                {
                    array_push($deletable_parent_vouchers, $id);
                }
            }

            /**
             * Remove parent vouchers if needed
             **/
            $this->deleting_model->safely_remove_voucher_where_ids($deletable_parent_vouchers);
            /**-----------------------------------------**/
        }
    }

    public function safely_remove_voucher_where_ids($ids)
    {
        if(sizeof($ids) == 0)
        {
            return;
        }
        $this->db->where_in('vouchers.id',$ids);
        $data = array(
            'deleted_at'=>current_time(),
            'deleted'=>1,
        );
        $this->db->update('vouchers',$data);
    }

    public function safely_remove_voucher_entries_where($where)
    {
        $this->db->where($where);
        $data = array(
            'deleted_at'=>current_time(),
            'deleted'=>1,
        );
        $this->db->update('voucher_entries',$data);
    }

    public function safely_delete_vouchers_where($where)
    {
        $this->db->where($where);
        $data = array(
            'deleted_at'=>current_time(),
            'deleted'=>1,
        );
        $this->db->update('vouchers',$data);
    }
}


?>