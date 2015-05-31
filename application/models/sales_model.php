<?php
class Sales_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "vouchers";
    }

    public function get(){

    }

    public function total_sales($from, $to)
    {
        $this->db->select("SUM(voucher_entries.amount) as total_sales");
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->all_sale_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $result = $this->db->get()->result();
        $total_sales = ($result[0]->total_sales != null)?$result[0]->total_sales:0;
        return round($total_sales, 3);
    }

    public function make_grouped_invoices_from_raw($raw_invoices)
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
                $temp_invoice->tanker = $record->tanker;

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
    public function make_invoices_from_raw($raw_invoices)
    {
        include_once(APPPATH."models/helperClasses/Sale_Invoice.php");
        include_once(APPPATH."models/helperClasses/Sale_Invoice_Entry.php");
        include_once(APPPATH."models/helperClasses/Customer.php");
        include_once(APPPATH."models/helperClasses/Product.php");

        $final_invoices_array = array();

        $temp_invoice = new Sale_Invoice();
        $temp_invoice_item = new Sale_Invoice_Entry($temp_invoice);

        foreach($raw_invoices as $record){

            /**
             * setting data related to parent object (Sale Invoice)
             */
            $temp_invoice = new Sale_Invoice();

            //setting data in the parent object
            $temp_invoice->id = $record->invoice_id;
            $temp_invoice->date = $record->invoice_date;
            $temp_invoice->customer = new Customer(null, $record->related_customer);
            $temp_invoice->summary = $record->invoice_summary;
            $temp_invoice->tanker = $record->tanker;

            /**
             * setting data related to Child object (Sale Invoice Item)
             */
            $temp_invoice_item = new Sale_Invoice_Entry($temp_invoice);

            //setting data in the Trip_Product_Data object
            $temp_invoice_item->id = $record->entry_id;
            $temp_invoice_item->product = new Product(null, $record->product_name);
            $temp_invoice_item->salePricePerItem = $record->cost_per_item;
            $temp_invoice_item->quantity = $record->quantity;

            //pushing particals
            array_push($temp_invoice->entries, $temp_invoice_item);
            array_push($final_invoices_array, $temp_invoice);

        }

        return $final_invoices_array;
    }

    public function make_product_sale_with_freight_invoices_from_raw($raw_invoices)
    {
        include_once(APPPATH."models/helperClasses/Sale_Invoice.php");
        include_once(APPPATH."models/helperClasses/Sale_With_Freight_Invoice_Entry.php");
        include_once(APPPATH."models/helperClasses/Customer.php");
        include_once(APPPATH."models/helperClasses/Product.php");

        $final_invoices_array = array();

        foreach($raw_invoices as $record){

            /**
             * setting data related to parent object (Sale Invoice)
             */
            $temp_invoice = new Sale_Invoice();

            //setting data in the parent object
            $temp_invoice->id = $record->invoice_id;
            $temp_invoice->date = $record->invoice_date;
            $temp_invoice->customer = new Customer(null, $record->related_customer);
            $temp_invoice->summary = $record->invoice_summary;
            $temp_invoice->tanker = $record->tanker;

            /**
             * setting data related to Child object (Sale Invoice Item)
             */
            $temp_invoice_item = new Sale_With_Freight_Invoice_Entry($temp_invoice);

            //setting data in the Trip_Product_Data object
            $temp_invoice_item->id = $record->entry_id;
            $temp_invoice_item->product = new Product(null, $record->product_name);
            $temp_invoice_item->salePricePerItem = $record->cost_per_item;
            $temp_invoice_item->quantity = $record->quantity;
            $temp_invoice_item->freight = $record->freight_amount;

            //pushing particals
            array_push($temp_invoice->entries, $temp_invoice_item);
            array_push($final_invoices_array, $temp_invoice);

        }

        return $final_invoices_array;
    }

    public function product_sale_invoices()
    {
        $this->select_sale_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_sale_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();
        return $this->sales_model->make_invoices_from_raw($raw_invoices);
    }
    public function search_limited_product_sale_invoices($keys, $sorting_info)
    {
        $this->select_sale_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_sale_vouchers();
        $this->with_debit_entries_only();

        /**
         * applying search keys
         **/
        if(sizeof($keys['customers']) > 0)
        {
            $this->where_related_customers($keys['customers']);
        }
        if(sizeof($keys['products']) > 0)
        {
            $this->where_ac_titles($keys['products']);
        }
        if($keys['to'] != '')
        {
            $this->db->where('vouchers.voucher_date <=',$keys['to']);
        }
        if($keys['from'] != '')
        {
            $this->db->where('vouchers.voucher_date >=',$keys['from']);
        }
        /*------- End Of Search Keys-----*/

        /**
         * Sorting Section
         **/
        $this->db->order_by($sorting_info['sort_by'],$sorting_info['order_by']);
        /*------ Sorting Section Ends ------*/

        $raw_invoices = $this->db->get()->result();
        return $this->sales_model->make_invoices_from_raw($raw_invoices);
    }

    public function product_sale_with_freight_invoices()
    {
        $this->select_sale_with_freight_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_with_freight_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();

        return $this->sales_model->make_product_sale_with_freight_invoices_from_raw($raw_invoices);
    }

    public function search_limited_product_sale_with_freight_invoices($keys, $sorting_info)
    {
        $this->select_sale_with_freight_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_with_freight_vouchers();
        $this->with_debit_entries_only();

        /**
         * applying search keys
         **/
        if(sizeof($keys['customers']) > 0)
        {
            $this->where_related_customers($keys['customers']);
        }
        if(sizeof($keys['products']) > 0)
        {
            $this->where_ac_titles($keys['products']);
        }
        if($keys['to'] != '')
        {
            $this->db->where('vouchers.voucher_date <=',$keys['to']);
        }
        if($keys['from'] != '')
        {
            $this->db->where('vouchers.voucher_date >=',$keys['from']);
        }
        /*------- End Of Search Keys-----*/

        /**
         * Sorting Section
         **/
        $this->db->order_by($sorting_info['sort_by'],$sorting_info['order_by']);
        /*------ Sorting Section Ends ------*/

        $raw_invoices = $this->db->get()->result();
        return $this->sales_model->make_product_sale_with_freight_invoices_from_raw($raw_invoices);
    }
    public function few_product_sale_invoices()
    {
        //fetching the vocuher ids
        $this->select_voucher_ids();
        $this->db->distinct();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_sale_vouchers();
        $this->with_debit_entries_only();
        $this->db->limit(5);
        $this->latest($this->table);
        $result = $this->db->get()->result();
        $voucher_ids = array(0,);
        if(sizeof($result) > 0)
        {
            foreach($result as $record)
            {
                array_push($voucher_ids, $record->voucher_id);
            }
        }
        /*************************************/

        //fetching the vouchers
        $this->select_sale_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where_in('vouchers.id',$voucher_ids);
        $this->product_sale_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();
        /*****************************************/

        return $this->sales_model->make_invoices_from_raw($raw_invoices);
    }

    public function few_product_with_freight_invoices()
    {
        //fetching the vocuher ids
        $this->select_voucher_ids();
        $this->db->distinct();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_with_freight_vouchers();
        $this->with_debit_entries_only();
        $this->db->limit(5);
        $this->latest($this->table);
        $result = $this->db->get()->result();
        $voucher_ids = array(0,);
        if(sizeof($result) > 0)
        {
            foreach($result as $record)
            {
                array_push($voucher_ids, $record->voucher_id);
            }
        }
        /*************************************/

        //fetching the vouchers
        $this->select_sale_with_freight_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where_in('vouchers.id',$voucher_ids);
        $this->product_with_freight_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();
        /*****************************************/

        return $this->sales_model->make_product_sale_with_freight_invoices_from_raw($raw_invoices);
    }

    public function today_sales()
    {
        $this->select_sale_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_sale_vouchers();
        $this->today_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();

        $product_sales = $this->sales_model->make_invoices_from_raw($raw_invoices);

        $this->select_sale_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->product_with_freight_vouchers();
        $this->today_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $raw_invoices = $this->db->get()->result();

        $product_sales_with_freight = $this->sales_model->make_invoices_from_raw($raw_invoices);

        $today_sales = array_merge($product_sales, $product_sales_with_freight);
        return $today_sales;
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

    public function insert_product_sale($voucher_type='product_sale'){
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");


        $pannel_count = $this->input->post('pannel_count');
        $tanker = $this->input->post('tanker');
        /**
         * Fetching the purchase price per unit of the selling
         * products
         * */
        $stock_elements = array();
        for($i = 1; $i<$pannel_count; $i++)
        {
            $product = $this->input->post('product_'.$i);
            $temp_arr = array(
                'tanker'=>$tanker,
                'product'=>$product,
            );
            if($product != '')
            {
                array_push($stock_elements, $temp_arr);
            }
        }
        $purchase_prices = $this->stock_model->purchase_prices_of($stock_elements);
        /*--------------------------------------------------*/


        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('invoice_date');
        $voucher->summary = $this->input->post('extra_info');
        $voucher->tanker = $tanker;
        $voucher->voucher_type = $voucher_type;

        $voucher_entries = array();
        $stock_entries = array();
        for($i = 1; $i<$pannel_count; $i++)
        {

            $product = $this->input->post('product_'.$i);
            $quantity = $this->input->post('quantity_'.$i);
            $cost_per_item = $this->input->post('salePricePerItem_'.$i);
            $freight_amount = (isset($_POST['freight_amount_'.$i]))?$_POST['freight_amount_'.$i]:0;

            /* if product is empty than entry will not be added */
            if($product != '')
            {
                /*---------First ENTRY--------*/
                $voucher_entry_1 = new App_voucher_Entry();
                $voucher_entry_1->ac_title = $product;
                $voucher_entry_1->ac_type = 'receivable';
                $voucher_entry_1->related_customer = $this->input->post('customer');
                $voucher_entry_1->cost_per_item = $cost_per_item;
                $voucher_entry_1->purchase_price_per_item_for_sale = $purchase_prices[strtolower($product."_".$tanker)];
                $voucher_entry_1->quantity = $quantity;
                $voucher_entry_1->amount = $cost_per_item * $quantity;
                $voucher_entry_1->freight = $freight_amount;
                $voucher_entry_1->dr_cr = 1;

                array_push($voucher_entries, $voucher_entry_1);
                /*----------------------------------*/

                /*---------Second ENTRY--------*/
                $voucher_entry_2 = new App_voucher_Entry();
                $voucher_entry_2->ac_title = $product;
                $voucher_entry_2->ac_type = 'revenue';
                $voucher_entry_2->related_business = $this->admin_model->business_name();
                $voucher_entry_2->cost_per_item = $cost_per_item;
                $voucher_entry_2->purchase_price_per_item_for_sale = $purchase_prices[strtolower($product."_".$tanker)];
                $voucher_entry_2->quantity = $quantity;
                $voucher_entry_2->amount = $cost_per_item * $quantity;
                $voucher_entry_2->freight = $freight_amount;
                $voucher_entry_2->dr_cr = 0;

                array_push($voucher_entries, $voucher_entry_2);
                /*----------------------------------*/

                /*----------Managing Stack-------------*/
                $stock_entry['product_name']=$product;
                $stock_entry['quantity']=$quantity;
                $stock_entry['tanker'] = $this->input->post('tanker');
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
    public function insert_freight_sale($sale_id = 0){
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");


        $pannel_count = $this->input->post('pannel_count');
        $tanker = $this->input->post('tanker');

        $voucher_inserted = false;

        $this->db->trans_begin();

        for($i = 1; $i<$pannel_count; $i++)
        {
            $product = $this->input->post('product_'.$i);

            $voucher = new App_Voucher();
            $voucher->voucher_date = $this->input->post('invoice_date');
            $voucher->summary = $this->input->post('extra_info');
            $voucher->tanker = $tanker;
            $voucher->voucher_type = 'freight_sale';
            $voucher->product_sale_id = $sale_id;
            $voucher->product_for_freight_voucher = $product;

            $voucher_entries = array();

            $product = $this->input->post('product_'.$i);
            $freight_amount = $this->input->post('freight_amount_'.$i);

            /* if product is empty than entry will not be added */
            if($product != '')
            {
                /*---------First ENTRY--------*/
                $voucher_entry_1 = new App_voucher_Entry();
                $voucher_entry_1->ac_title = 'freight_cash';
                $voucher_entry_1->ac_type = 'receivable';
                $voucher_entry_1->related_business = $this->admin_model->business_name();
                $voucher_entry_1->amount = $freight_amount;
                $voucher_entry_1->dr_cr = 1;

                array_push($voucher_entries, $voucher_entry_1);
                /*----------------------------------*/

                /*---------Second ENTRY--------*/
                $voucher_entry_2 = new App_voucher_Entry();
                $voucher_entry_2->ac_title = 'freight a/c';
                $voucher_entry_2->ac_type = 'revenue';
                $voucher_entry_2->related_tanker = $this->input->post('tanker');
                $voucher_entry_2->amount = $freight_amount;
                $voucher_entry_2->dr_cr = 0;

                array_push($voucher_entries, $voucher_entry_2);
                /*----------------------------------*/

                /*------------inserting voucher entries in the voucher container---------*/
                $voucher->entries = $voucher_entries;
                /*---------------------------------------------------------------------*/

                /*--------------Inserting Voucher in The Database---------------*/
                $voucher_inserted = $this->accounts_model->insert_voucher($voucher);
            }
        }




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

    public function insert_product_with_freight()
    {
        $this->db->trans_begin();

        $sale_id = $this->insert_product_sale('product_sale_with_freight');
        if($this->db->trans_status() == false || $sale_id == false)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $freight_id = $this->insert_freight_sale($sale_id);
            if($this->db->trans_status() == false || $freight_id == false)
            {
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
                return $sale_id;
            }
        }
        return false;
    }

    public function next_invoice()
    {
        return $this->helper_model->next_id($this->table);
    }

    public function product_sale_sortable_columns()
    {
        return array(
            'invoice_number'=>'vouchers.id',
            'invoice_date'=>'vouchers.voucher_date',
            'customer'=>'voucher_entries.related_customer',
            'tanker'=>'vouchers.tanker',
            'product'=>'voucher_entries.ac_title',
            'quantity'=>'voucher_entries.quantity',
            'sale_price_item'=>'voucher_entries.cost_per_item',
            'total_cost'=>'voucher_entries.amount',
            'extra_info'=>'vouchers.summary',
        );
    }

    public function product_sale_with_freight_sortable_columns()
    {
        return array(
            'invoice_number'=>'vouchers.id',
            'invoice_date'=>'vouchers.voucher_date',
            'customer'=>'voucher_entries.related_customer',
            'tanker'=>'vouchers.tanker',
            'product'=>'voucher_entries.ac_title',
            'quantity'=>'voucher_entries.quantity',
            'sale_price_item'=>'voucher_entries.cost_per_item',
            'total_cost'=>'voucher_entries.amount',
            'freight'=>'voucher_entries.freight',
            'extra_info'=>'vouchers.summary',
        );
    }
}