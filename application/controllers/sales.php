<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Sales extends ParentController {
    //public variables...
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $target_function = $this->intelligent_router_model->get_last_saved_route_for_current_controller();

        if($target_function != 'index')
        {
            //setting section
            $this->bodyData['section'] = $target_function;
            //and there we go...
            redirect(base_url()."sales/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'cash_sale';
            }
            redirect(base_url()."sales/cash_sale");
        }
    }

    public function cash_sale()
    {
        $headerData['title']='Sale';
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['customers'] = $this->customers_model->customers();

        if(isset($_POST['save_cash_sale']))
        {
            $saved_invoice = $this->sales_model->insert_cash_sale();
            if($saved_invoice != 0){
                $this->helper_model->redirect_with_success('Invoice Saved Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
            }
        }
        $this->bodyData['invoice_number'] = $this->sales_model->next_invoice();
        $this->load->view('components/header',$headerData);
        $this->load->view('sales/cash/make', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function add_product_sale()
    {
        $headerData['title']='sale';
        $this->bodyData['section'] = 'add';
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['customers'] = $this->customers_model->get();

        $this->bodyData['customers_balance'] = $this->accounts_model->customers_balance();
        $this->bodyData['available_stock'] = $this->stock_model->get();
        $this->bodyData['tankers'] = $this->tankers_model->get_busy();
        $this->bodyData['invoice_number'] = $this->sales_model->next_invoice();
        $sales = $this->sales_model->few_product_sale_invoices();
        $this->bodyData['sales']= $sales;

        $this->load->view('components/header',$headerData);
        $this->load->view('sales/product_sale/make', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function product_sale_history()
    {
        $headerData['title']= 'Sale Invoices';

        $sales = $this->sales_model->search_limited_product_sale_invoices($this->search_keys, $this->sorting_info);
        $this->bodyData['sales']= $sales;
        $this->bodyData['customers'] = $this->customers_model->get();
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['section'] = 'invoices';

        $this->load->view('components/header', $headerData);
        $this->load->view('sales/product_sale/show', $this->bodyData);
        $this->load->view('components/footer');
    }
    public function add_product_with_freight()
    {
        $headerData['title']='sale';
        $this->bodyData['section'] = 'add';
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['customers'] = $this->customers_model->get();
        /*$this->bodyData['cities'] = $this->source_destination_model->get();*/

        $this->bodyData['customers_balance'] = $this->accounts_model->customers_balance();
        $this->bodyData['available_stock'] = $this->stock_model->get();
        $this->bodyData['tankers'] = $this->tankers_model->get_busy();
        $this->bodyData['invoice_number'] = $this->sales_model->next_invoice();
        $sales = $this->sales_model->few_product_with_freight_invoices();
        $this->bodyData['sales']= $sales;

        $this->load->view('components/header',$headerData);
        $this->load->view('sales/product_with_freight/make', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function product_with_freight_history()
    {
        $headerData['title']= 'Sale Invoices';

        $sales = $this->sales_model->search_limited_product_sale_with_freight_invoices($this->search_keys, $this->sorting_info);
        $this->bodyData['sales']= $sales;
        $this->bodyData['section'] = 'invoices';
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['customers'] = $this->customers_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('sales/product_with_freight/show', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function cash()
    {
        $headerData['title']= 'Cash Invoices';
        $sales = $this->sales_model->cash();
        $this->bodyData['sales']= $sales;

        $this->load->view('components/header', $headerData);
        $this->load->view('sales/cash/show', $this->bodyData);
        $this->load->view('components/footer');
    }


    public function _check_for_same_product_selection()
    {
        $pannel_count = $this->input->post('pannel_count');
        for($count1 = 1; $count1 < $pannel_count; $count1++)
        {
            $product1  = $_POST['product_'.$count1];
            for($count2 = 1; $count2 < $pannel_count; $count2++)
            {
                $product2 = $_POST['product_'.$count2];
                if($product1 == $product2 && $count2 != $count1)
                {
                    $this->form_validation->set_message('_check_for_same_product_selection','Same Product cannot be used twice.');
                    return false;
                }
            }
        }

        return true;
    }
    public function _check_for_any_product_selected()
    {
        $is_any_product_selected = false;

        $pannel_count = $this->input->post('pannel_count');
        for($count1 = 1; $count1 < $pannel_count; $count1++)
        {
            $product1  = $_POST['product_'.$count1];
            if($product1 != '')
                $is_any_product_selected = true;
        }

        if($is_any_product_selected == false)
        {
            $this->form_validation->set_message('_check_for_any_product_selected','Please select atleast one product.');
            return false;
        }

        return true;
    }

    public function _check_product_availability($var)
    {
        $tanker = $this->input->post('tanker');
        $products_quantity = array();
        $pannel_count = $this->input->post('pannel_count');

        for($i = 1; $i<$pannel_count; $i++)
        {
            $product = $this->input->post('product_'.$i);
            $quantity = $this->input->post('quantity_'.$i);
            if(isset($products_quantity[$product]))
            {
                $products_quantity[$product] += $quantity;
            }else{
                $products_quantity[$product] = $quantity;
            }
        }

        $fault_products = array();
        $available_stock = $this->stock_model->get();
        foreach($available_stock as $group)
        {
            foreach($group as $stock)
            {
                if($stock->tanker == $tanker && array_key_exists($stock->product_name, $products_quantity))
                {
                    if($stock->quantity < $products_quantity[$stock->product_name])
                    {
                        array_push($fault_products, $stock->product_name);
                    }
                }
            }
        }

        if(sizeof($fault_products) > 0)
        {
            $products = join(" and ", $fault_products);
            $this->form_validation->set_message('_check_product_availability','Not enough stock available for '.$products.'. Please try again');
            return false;
        }
        return true;
    }


    /**
     * Below functions are used t save or deleted
     * records in db if needed
     **/
    public function is_any_thing_needs_to_be_deleted()
    {

        /**
         * delete Product sale invoice on request
         **/
        if(isset($_POST['delete_product_sale_invoice'])){
            if($this->form_validation->run('delete_sale_invoice') == true){
                if( $this->deleting_model->delete_sale_invoice_item($_POST['invoice_number'], $_POST['product']) == true){
                    $this->helper_model->redirect_with_success('Invoice Removed Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }else{
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }

        /**
         * delete Product sale with freight invoice on request
         **/
        if(isset($_POST['delete_freight_sale_invoice'])){
            if($this->form_validation->run('delete_sale_invoice') == true){
                if( $this->deleting_model->delete_product_and_freight_sale_invoice($_POST['invoice_number']) == true){
                    $this->helper_model->redirect_with_success('Invoice Removed Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }else{
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }

    }
    public function is_any_thing_needs_to_be_saved()
    {

        /**
         * insert Product sale
         **/
        if(isset($_POST['add_product_sale']))
        {
            if($this->form_validation->run('add_product_sale') == true){
                $saved_invoice = $this->sales_model->insert_product_sale();
                if($saved_invoice != 0){
                    $this->helper_model->redirect_with_success('Invoice Saved Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }else{
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }

        /**
         * insert new Sale with freight invoice on request
         **/
        if(isset($_POST['add_product_with_freight']))
        {
            if($this->form_validation->run('add_product_with_freight') == true){
                $saved_invoice = $this->sales_model->insert_product_with_freight();
                if($saved_invoice != 0){
                    $this->helper_model->redirect_with_success('Invoice Saved Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }else{
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }
    }

    public function set_search_keys_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "product_sale_history":
                $from = '';
                $to ='';
                $customers = array();
                $products = array();
                if(isset($_GET['from']))
                {
                    $from = $_GET['from'];
                }
                else
                {
                    $date = Carbon::now()->toDateString();
                    $from = first_day_of_month($date);
                }
                if(isset($_GET['to']))
                {
                    $to = $_GET['to'];
                }
                else
                {
                    $date = Carbon::now()->toDateString();
                    $to = $date;
                }
                if(isset($_GET['product']))
                {
                    $products = $_GET['product'];
                }
                if(isset($_GET['customer']))
                {
                    $customers = $_GET['customer'];
                }
                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['customers'] = $customers;
                $this->search_keys['products'] = $products;

                break;

            case "product_with_freight_history":
                $from = '';
                $to ='';
                $customers = array();
                $products = array();
                if(isset($_GET['from']))
                {
                    $from = $_GET['from'];
                }
                else
                {
                    $date = Carbon::now()->toDateString();
                    $from = first_day_of_month($date);
                }
                if(isset($_GET['to']))
                {
                    $to = $_GET['to'];
                }
                else
                {
                    $date = Carbon::now()->toDateString();
                    $to = $date;
                }
                if(isset($_GET['product']))
                {
                    $products = $_GET['product'];
                }
                if(isset($_GET['customer']))
                {
                    $customers = $_GET['customer'];
                }
                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['customers'] = $customers;
                $this->search_keys['products'] = $products;

                break;
        }
    }

    public function set_sort_info_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "product_sale_history":
                $sortable_columns = $this->sales_model->product_sale_sortable_columns();
                $sort_by = 'vouchers.id';
                $order_by = 'desc';

                if(isset($_GET['sort_by']) && array_key_exists($_GET['sort_by'], $sortable_columns))
                {
                    $sort_by = $sortable_columns[$_GET['sort_by']];
                }
                if(isset($_GET['order']) && $_GET['order'] == 'asc')
                {
                    $order_by = 'asc';
                }

                $this->sorting_info['sort_by'] = $sort_by;
                $this->sorting_info['order_by'] = $order_by;

                break;

            case "product_with_freight_history":
                $sortable_columns = $this->sales_model->product_sale_with_freight_sortable_columns();
                $sort_by = 'vouchers.id';
                $order_by = 'desc';

                if(isset($_GET['sort_by']) && array_key_exists($_GET['sort_by'], $sortable_columns))
                {
                    $sort_by = $sortable_columns[$_GET['sort_by']];
                }
                if(isset($_GET['order']) && $_GET['order'] == 'asc')
                {
                    $order_by = 'asc';
                }

                $this->sorting_info['sort_by'] = $sort_by;
                $this->sorting_info['order_by'] = $order_by;

                break;
        }
    }
}
