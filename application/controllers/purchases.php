<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Purchases extends ParentController {
    //public variables...
    public function __construct()
    {
        parent::__construct();

        //
    }

    public function index()
    {
        $target_function = $this->intelligent_router_model->get_last_saved_route_for_current_controller();

        if($target_function != 'index')
        {
            //setting section
            $this->bodyData['section'] = $target_function;
            //and there we go...
            redirect(base_url()."purchases/".$target_function);
        }
        else
        {
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'credit_purchase';
            }
            redirect(base_url()."purchases/credit_purchase");
        }
    }

    public function credit_purchase()
    {
        $headerData['title']='Purchase';
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['suppliers'] = $this->suppliers_model->get();

        $this->bodyData['suppliers_balance'] = $this->accounts_model->suppliers_balance();
        $this->bodyData['free_tankers'] = $this->tankers_model->get_free();
        $this->bodyData['busy_tankers'] = $this->tankers_model->get_busy();
        $this->bodyData['invoice_number'] = $this->purchases_model->next_invoice();
        $purchases = $this->purchases_model->few_invoices();
        $this->bodyData['purchases']= $purchases;

        $this->load->view('components/header',$headerData);
        $this->load->view('purchases/credit/make', $this->bodyData);
        $this->load->view('components/footer');
    }
    public function edit($id='')
    {
        if($id == '')
        {
            redirect(base_url()."purchases/credit_purchase");
        }
        if($this->accounts_model->voucher_active($id) == false)
        {
            redirect(base_url()."purchases/credit_purchase");
        }
        $headerData['title']='Purchase';
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['suppliers'] = $this->suppliers_model->get();

        $this->bodyData['suppliers_balance'] = $this->accounts_model->suppliers_balance();
        $this->bodyData['tankers'] = $this->tankers_model->get_free();
        $this->bodyData['invoice_number'] = $id;
        $this->bodyData['invoice'] = $this->purchases_model->find($id);
        $purchases = $this->purchases_model->few_invoices();
        $this->bodyData['purchases']= $purchases;
        $this->bodyData['next_item_id'] = $this->accounts_model->next_item_id($id);

        $this->load->view('components/header',$headerData);
        $this->load->view('purchases/credit/edit', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function invoices()
    {
        $headerData['title']= 'Purchase Invoices';

        $purchases = $this->purchases_model->search_limited_invoices($this->search_keys, $this->sorting_info);
        $this->bodyData['purchases']= $purchases;
        $this->bodyData['section'] = 'invoices';
        $this->bodyData['suppliers'] = $this->suppliers_model->get();
        $this->bodyData['products'] = $this->products_model->get();

        if(isset($_GET['print']))
        {
            $this->load->view('prints/purchases', $this->bodyData);
        }
        else if(isset($_GET['export']))
        {
            $this->load->view('exports/purchases', $this->bodyData);
        }
        else
        {
        $this->load->view('components/header', $headerData);
        $this->load->view('purchases/credit/show', $this->bodyData);
        $this->load->view('components/footer');
        }
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


    /**
     * Below functions are used t save or deleted
     * records in db if needed
     **/
    public function is_any_thing_needs_to_be_deleted()
    {

        /**
         * delete purchase invoice on request
         **/
        if(isset($_POST['delete_invoice'])){
            if($this->form_validation->run('delete_purchase_invoice') == true){
                if( $this->deleting_model->delete_purchase_invoice_item($_POST['invoice_number'], $_POST['item_id']) == true){
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
         * insert new purchase invoice on request
         **/
        if(isset($_POST['save_credit_purchase']))
        {
            if($this->form_validation->run('add_product_purchase') == true){
                $saved_invoice = $this->purchases_model->insert_credit_purchase();
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
         * Update purchase invoice on request
         **/
        if(isset($_POST['update_credit_purchase']))
        {
            $saved_invoice = $this->purchases_model->update_purchase_invoice($_POST['invoice_id']);
            if($saved_invoice != 0){
                $this->helper_model->redirect_with_success('Invoice Saved Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
            }
        }
    }

    public function set_search_keys_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "invoices":
                $from = '';
                $to ='';
                $suppliers = array();
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
                if(isset($_GET['supplier']))
                {
                    $suppliers = $_GET['supplier'];
                }

                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['products'] = $products;
                $this->search_keys['suppliers'] = $suppliers;

                break;
        }
    }

    public function set_sort_info_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "invoices":
                $sortable_columns = $this->purchases_model->sortable_columns();
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
