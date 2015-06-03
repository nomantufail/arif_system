<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Receipts extends ParentController {
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
            redirect(base_url()."receipts/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'make';
            }
            redirect(base_url()."receipts/make");
        }
    }

    public function make()
    {
        $headerData['title']='Payment New*';
        $this->bodyData['section'] = 'make';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['customers'] = $this->customers_model->get();

        $this->bodyData['customers_balance'] = $this->accounts_model->customers_balance();
        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();
        $this->bodyData['receipt_history'] = $this->receipts_model->few_receipts();
        $this->load->view('components/header',$headerData);
        $this->load->view('receipts/make', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function edit($id)
    {
        if($id == '')
        {
            redirect(base_url()."receipts/make");
        }
        if($this->accounts_model->voucher_active($id) == false)
        {
            redirect(base_url()."receipts/make");
        }
        $receipt_voucher = $this->receipts_model->find($id);
        if($receipt_voucher == null)
        {
            $this->helper_model->redirect_with_errors('Voucher not found.', base_url()."receipts/make");
        }

        $headerData['title']='Edit Payment';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['customers'] = $this->customers_model->get();

        $this->bodyData['customers_balance'] = $this->accounts_model->customers_balance();
        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();
        $this->bodyData['receipt_history'] = $this->receipts_model->few_receipts();
        $this->bodyData['receipt'] = $receipt_voucher;

        $this->bodyData['voucher_id'] = $id;

        $this->load->view('components/header',$headerData);
        $this->load->view('receipts/edit', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function history()
    {
        $headerData['title']='Payment History';
        $this->bodyData['section'] = 'history';

        $this->bodyData['customers'] = $this->customers_model->get();
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();

        $this->bodyData['receipt_history'] = $this->receipts_model->search_receipt_history($this->search_keys, $this->sorting_info);

        $this->load->view('components/header',$headerData);
        $this->load->view('Receipts/history', $this->bodyData);
        $this->load->view('components/footer');
    }


    /**
     * Below functions are used t save or deleted
     * records in db if needed
     **/
    public function is_any_thing_needs_to_be_deleted()
    {
        /**
         * delete a receipt voucher
         **/
        if(isset($_POST['delete_invoice'])){
            if($this->form_validation->run('delete_receipt_invoice') == true){
                if( $this->deleting_model->delete_receipt_invoice($_POST['invoice_number']) == true){
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
         * insert a receipt voucher
         **/
        if(isset($_POST['saveReceipt']))
        {
            $saved_receipt = $this->receipts_model->insert_receipt();
            if($saved_receipt != 0){
                $this->helper_model->redirect_with_success('Receipt Saved Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
            }
        }


        /**
         * update a payment voucher
         **/
        if(isset($_POST['updateReceipt']))
        {
            $saved_receipt = $this->receipts_model->update_receipt($_POST['voucher_id']);
            if($saved_receipt != 0){
                $this->helper_model->redirect_with_success('Receipt Saved Successfully!');
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
            case "history":
                $from = '';
                $to ='';
                $customer = array();
                $bank_acs = array();
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

                if(isset($_GET['bank_ac']))
                {
                    $bank_acs = $_GET['bank_ac'];
                }
                if(isset($_GET['customer']))
                {
                    $customer = $_GET['customer'];
                }

                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['bank_acs'] = $bank_acs;
                $this->search_keys['customers'] = $customer;

                break;
        }
    }

    public function set_sort_info_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "history":
                $sortable_columns = $this->receipts_model->sortable_columns();
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
