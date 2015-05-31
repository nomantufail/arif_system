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

    public function history()
    {
        $headerData['title']='Payment New*';
        $this->bodyData['section'] = 'history';

        $this->bodyData['payment_history'] = $this->payments_model->payment_history();

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
    }

    public function set_search_keys_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {

        }
    }
}
