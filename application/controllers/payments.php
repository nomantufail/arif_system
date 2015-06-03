<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Payments extends ParentController {
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
            redirect(base_url()."payments/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'make';
            }
            redirect(base_url()."payments/make");
        }
    }

    public function make()
    {
        $headerData['title']='Payment New*';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['suppliers'] = $this->suppliers_model->get();

        $this->bodyData['suppliers_balance'] = $this->accounts_model->suppliers_balance();
        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();
        $this->bodyData['payment_history'] = $this->payments_model->few_payments();
        $this->load->view('components/header',$headerData);
        $this->load->view('payments/make', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function edit($id)
    {
        if($id == '')
        {
            redirect(base_url()."payments/make");
        }
        if($this->accounts_model->voucher_active($id) == false)
        {
            redirect(base_url()."payments/make");
        }
        $payment_voucher = $this->payments_model->find($id);
        if($payment_voucher == null)
        {
            $this->helper_model->redirect_with_errors('Voucher not found.');
        }

        $headerData['title']='Edit Payment';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['suppliers'] = $this->suppliers_model->get();

        $this->bodyData['suppliers_balance'] = $this->accounts_model->suppliers_balance();
        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();
        $this->bodyData['payment_history'] = $this->payments_model->few_payments();
        $this->bodyData['payment'] = $payment_voucher;

        $this->bodyData['voucher_id'] = $id;

        $this->load->view('components/header',$headerData);
        $this->load->view('payments/edit', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function history()
    {
        $headerData['title']='Payment History';
        $this->bodyData['section'] = 'history';

        $this->bodyData['suppliers'] = $this->suppliers_model->get();
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();

        $this->bodyData['payment_history'] = $this->payments_model->search_payment_history($this->search_keys, $this->sorting_info);

        $this->load->view('components/header',$headerData);
        $this->load->view('payments/history', $this->bodyData);
        $this->load->view('components/footer');
    }


    /**
     * Below functions are used t save or deleted
     * records in db if needed
     **/
    public function is_any_thing_needs_to_be_deleted()
    {

        /**
         * delete a payment voucher
         **/
        if(isset($_POST['delete_invoice'])){
            if($this->form_validation->run('delete_payment_invoice') == true){
                if( $this->deleting_model->delete_payment_invoice($_POST['invoice_number']) == true){
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
         * Insert a payment voucher
         **/
        if(isset($_POST['savePayment']))
        {
            $saved_payment = $this->payments_model->insert_payment();
            if($saved_payment != 0){
                $this->helper_model->redirect_with_success('Payment Saved Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
            }
        }

        /**
         * update a payment voucher
         **/
        if(isset($_POST['updatePayment']))
        {
            $saved_payment = $this->payments_model->update_payment($_POST['voucher_id']);
            if($saved_payment != 0){
                $this->helper_model->redirect_with_success('Payment Saved Successfully!');
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
                $suppliers = array();
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
                if(isset($_GET['supplier']))
                {
                    $suppliers = $_GET['supplier'];
                }

                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['bank_acs'] = $bank_acs;
                $this->search_keys['suppliers'] = $suppliers;

                break;
        }
    }

    public function set_sort_info_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "history":
                $sortable_columns = $this->payments_model->sortable_columns();
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
