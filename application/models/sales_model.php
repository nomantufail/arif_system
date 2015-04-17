<?php
class Sales_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "vouchers";
    }

    public function get(){

    }

    public function cash()
    {
        include_once(APPPATH."models/helperClasses/Sale_Invoice.php");
        include_once(APPPATH."models/helperClasses/Sale_Invoice_Entry.php");
        include_once(APPPATH."models/helperClasses/Customer.php");
        include_once(APPPATH."models/helperClasses/Product.php");

        $this->db->select("
            sale_invoices.id as invoice_id, sale_invoices.invoice_date, sale_invoices.extra_info,
            customers.id as customer_id, customers.name as customer_name,
            sale_invoice_items.id as entry_id, sale_invoice_items.quantity as product_quantity,
            sale_invoice_items.sale_price_per_item,
            products.id as product_id, products.name as product_name,
        ");
        $this->db->from($this->table);
        $this->db->join('sale_invoice_items','sale_invoice_items.invoice_id = sale_invoices.id','left');
        $this->db->join('customers','customers.id = sale_invoices.customer_id','left');
        $this->db->join('products','products.id = sale_invoice_items.product_id','left');

        $this->db->where(array(
            'sale_invoices.deleted'=>0,
            'sale_invoices.transaction_type'=>1,
        ));
        $this->db->order_by('sale_invoices.id, sale_invoice_items.id');
        $raw_invoices = $this->db->get()->result();

        $final_invoices_array = array();

        $previous_invoice_id = -1;
        $previous_entry_id = -1;

        $temp_invoice = new Sale_Invoice();
        $temp_invoice_item = new Sale_Invoice_Entry($temp_invoice);

        $count = 0;
        foreach($raw_invoices as $record){
            $count++;

            //setting the parent details
            if($record->invoice_id != $previous_invoice_id)
            {
                $previous_invoice_id = $record->invoice_id;

                $temp_invoice = new Sale_Invoice();

                //setting data in the parent object
                $temp_invoice->id = $record->invoice_id;
                $temp_invoice->date = $record->invoice_date;
                $temp_invoice->customer = new Customer($record->customer_id, $record->customer_name);
                $temp_invoice->extra_info = $record->extra_info;

            }/////////////////////////////////////////////////

            /////////////////////////////////////////////////
            if($record->entry_id != $previous_entry_id)
            {
                $previous_entry_id = $record->entry_id;

                $temp_invoice_item = new Sale_Invoice_Entry($temp_invoice);

                //setting data in the Trip_Product_Data object
                $temp_invoice_item->id = $record->entry_id;
                $temp_invoice_item->product = new Product($record->product_id, $record->product_name);
                $temp_invoice_item->salePricePerItem = $record->sale_price_per_item;
                $temp_invoice_item->quantity = $record->product_quantity;
            }/////////////////////////////////////////////////

            //pushing particals
            if($count != sizeof($raw_invoices)){
                if($raw_invoices[$count]->entry_id != $record->entry_id){
                    array_push($temp_invoice->entries, $temp_invoice_item);
                }
                if($raw_invoices[$count]->invoice_id != $record->invoice_id){
                    array_push($final_invoices_array, $temp_invoice);
                }
            }else{

                array_push($temp_invoice->entries, $temp_invoice_item);
                array_push($final_invoices_array, $temp_invoice);
            }
        }

        return $final_invoices_array;
    }

    public function make_invoices_from_raw($raw_invoices)
    {
        include_once(APPPATH."models/helperClasses/Sale_Invoice.php");
        include_once(APPPATH."models/helperClasses/Sale_Invoice_Entry.php");
        include_once(APPPATH."models/helperClasses/Customer.php");
        include_once(APPPATH."models/helperClasses/Product.php");

        $final_invoices_array = array();

        $previous_invoice_id = -1;
        $previous_entry_id = -1;

        $temp_invoice = new Sale_Invoice();
        $temp_invoice_item = new Sale_Invoice_Entry($temp_invoice);

        $count = 0;
        foreach($raw_invoices as $record){
            $count++;

            //setting the parent details
            if($record->invoice_id != $previous_invoice_id)
            {
                $previous_invoice_id = $record->invoice_id;

                $temp_invoice = new Sale_Invoice();

                //setting data in the parent object
                $temp_invoice->id = $record->invoice_id;
                $temp_invoice->date = $record->invoice_date;
                $temp_invoice->customer = new Customer(null, $record->related_customer);
                $temp_invoice->summary = $record->invoice_summary;

            }/////////////////////////////////////////////////

            /////////////////////////////////////////////////
            if($record->entry_id != $previous_entry_id)
            {
                $previous_entry_id = $record->entry_id;

                $temp_invoice_item = new Sale_Invoice_Entry($temp_invoice);

                //setting data in the Trip_Product_Data object
                $temp_invoice_item->id = $record->entry_id;
                $temp_invoice_item->product = new Product(null, $record->product_name);
                $temp_invoice_item->salePricePerItem = $record->cost_per_item;
                $temp_invoice_item->quantity = $record->quantity;
            }/////////////////////////////////////////////////

            //pushing particals
            if($count != sizeof($raw_invoices)){
                if($raw_invoices[$count]->entry_id != $record->entry_id){
                    array_push($temp_invoice->entries, $temp_invoice_item);
                }
                if($raw_invoices[$count]->invoice_id != $record->invoice_id){
                    array_push($final_invoices_array, $temp_invoice);
                }
            }else{

                array_push($temp_invoice->entries, $temp_invoice_item);
                array_push($final_invoices_array, $temp_invoice);
            }
        }

        return $final_invoices_array;
    }

    public function invoices()
    {
        $this->select_sale_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->sale_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();

        return $this->sales_model->make_invoices_from_raw($raw_invoices);
    }

    public function today_sales()
    {
        $this->select_sale_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->sale_vouchers();
        $this->today_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();

        return $this->sales_model->make_invoices_from_raw($raw_invoices);
    }

    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);
        if($keys['agent_id'] != '')
        {
            $this->db->where('id',$keys['agent_id']);
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function count($keys = "") {
        if($keys != "")
        {
            if($keys['agent_id'] != '')
            {
                $this->db->where('id',$keys['agent_id']);
            }
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function find($id){
        $result = $this->db->get_where($this->table, array('id'=>$id))->result();
        if($result){
            $record = $result[0];
            return $record;
        }else{
            return null;
        }
    }

    public function insert_cash_sale(){
        $pannel_count = $this->input->post('pannel_count');
        $customer  = $this->input->post('customer');
        $invoice_date = $this->input->post('invoice_date');
        $extra_info = $this->input->post('extra_info');
        $transaction_type = 1;

        $invoice_data = array(
            'customer_id'=>$customer,
            'invoice_date'=>$invoice_date,
            'transaction_type'=>$transaction_type,
            'extra_info'=>$extra_info,
        );
        $invoice_entries = array();
        $stock_entries = array();
        for($i = 1; $i<$pannel_count; $i++)
        {
            $invoice_entry = array();

            $product = $this->input->post('product_'.$i);
            $quantity = $this->input->post('quantity_'.$i);
            $sale_price_per_item = $this->input->post('salePricePerItem_'.$i);

            $stock_entry['product_id']=$product;
            $stock_entry['quantity']=$quantity;

            $invoice_entry['product_id']=$product;
            $invoice_entry['quantity'] = $quantity;
            $invoice_entry['sale_price_per_item']= $sale_price_per_item;

            if($invoice_entry['product_id'] != '')
            {
                array_push($stock_entries, $stock_entry);
                array_push($invoice_entries, $invoice_entry);
            }

        }

        $invoice_id = 0;
        $this->db->trans_start();

        if(sizeof($invoice_entries) > 0)
        {
            $this->db->insert($this->table, $invoice_data);
            $invoice_id = $this->db->insert_id();

            $modified_invoice_entries = array();
            foreach($invoice_entries as $entry)
            {
                $entry['invoice_id'] = $invoice_id;
                array_push($modified_invoice_entries, $entry);
            }

            $this->db->insert_batch('sale_invoice_items',$modified_invoice_entries);

            $this->stock_model->decrease($stock_entries);
        }


        if($this->db->trans_complete() == true)
        {
            return $invoice_id;
        }
        return false;
    }

    public function insert_credit_sale(){
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");


        $pannel_count = $this->input->post('pannel_count');

        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('invoice_date');
        $voucher->summary = $this->input->post('extra_info');
        $voucher->voucher_type = 'sale';

        $voucher_entries = array();
        $stock_entries = array();
        for($i = 1; $i<$pannel_count; $i++)
        {

            $product = $this->input->post('product_'.$i);
            $quantity = $this->input->post('quantity_'.$i);
            $cost_per_item = $this->input->post('salePricePerItem_'.$i);

            /* if product is empty than entry will not be added */
            if($product != '')
            {
                /*---------First ENTRY--------*/
                $voucher_entry_1 = new App_voucher_Entry();
                $voucher_entry_1->ac_title = $product;
                $voucher_entry_1->ac_type = 'receivable';
                $voucher_entry_1->related_customer = $this->input->post('customer');
                $voucher_entry_1->cost_per_item = $cost_per_item;
                $voucher_entry_1->quantity = $quantity;
                $voucher_entry_1->amount = $cost_per_item * $quantity;
                $voucher_entry_1->dr_cr = 1;

                array_push($voucher_entries, $voucher_entry_1);
                /*----------------------------------*/

                /*---------Second ENTRY--------*/
                $voucher_entry_2 = new App_voucher_Entry();
                $voucher_entry_2->ac_title = $product;
                $voucher_entry_2->ac_type = 'revenue';
                $voucher_entry_2->related_business = $this->admin_model->business_name();
                $voucher_entry_2->cost_per_item = $cost_per_item;
                $voucher_entry_2->quantity = $quantity;
                $voucher_entry_2->amount = $cost_per_item * $quantity;
                $voucher_entry_2->dr_cr = 0;

                array_push($voucher_entries, $voucher_entry_2);
                /*----------------------------------*/

                /*----------Managing Stack-------------*/
                $stock_entry['product_name']=$product;
                $stock_entry['quantity']=$quantity;
                array_push($stock_entries, $stock_entry);
                /*------------------------------------*/
            }
        }

        /*------------inserting voucher entries in the voucher container---------*/
        $voucher->entries = $voucher_entries;
        /*---------------------------------------------------------------------*/

        /*--------------Lets the game begin---------------*/
        $this->db->trans_begin();

        $voucher_inserted = $this->accounts_model->insert_voucher($voucher);
        $stock_updated = $this->stock_model->decrease($stock_entries);


        if($this->db->trans_status() == false || $voucher_inserted == false || $stock_updated == false)
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


    public function next_invoice()
    {
        return $this->helper_model->next_id($this->table);
    }

}