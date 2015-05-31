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

    public function history()
    {
        $headerData['title']='Payment New*';
        $this->bodyData['section'] = 'history';

        $this->bodyData['receipt_history'] = $this->receipts_model->receipt_history();

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
    }

    public function set_search_keys_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {

        }
    }
}
