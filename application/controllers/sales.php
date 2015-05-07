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
            $this->$target_function();
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'cash_sale';
            }
            $this->cash_sale();
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
                $this->bodyData['someMessage'] = array('message'=>'Invoice Saved Successfully! Invoice# was <b>'.$saved_invoice.'</b>', 'type'=>'alert-success');
            }else{
                $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
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
        if(isset($_POST['add_product_sale']))
        {
            if($this->form_validation->run('add_product_sale') == true){
                $saved_invoice = $this->sales_model->insert_product_sale();
                if($saved_invoice != 0){
                    $this->bodyData['someMessage'] = array('message'=>'Invoice Saved Successfully! Invoice# was <b>'.$saved_invoice.'</b>', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }

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
        $sales = $this->sales_model->product_sale_invoices();
        $this->bodyData['sales']= $sales;
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
        $this->bodyData['cities'] = $this->source_destination_model->get();
        if(isset($_POST['add_product_with_freight']))
        {
            if($this->form_validation->run('add_product_with_freight') == true){
                $saved_invoice = $this->sales_model->insert_product_with_freight();
                if($saved_invoice != 0){
                    $this->bodyData['someMessage'] = array('message'=>'Invoice Saved Successfully! Invoice# was <b>'.$saved_invoice.'</b>', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }
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
        $sales = $this->sales_model->product_sale_with_freight_invoices();
        $this->bodyData['sales']= $sales;
        $this->bodyData['section'] = 'invoices';

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

}
