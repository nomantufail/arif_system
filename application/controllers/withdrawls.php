<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Withdrawls extends ParentController {
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
            redirect(base_url()."withdrawls/".$target_function);
        }
        else
        {
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'withdraw';
            }
            redirect(base_url()."withdrawls/withdraw");
        }
    }

    public function withdraw()
    {
        $headerData = array(
            'title' => 'Withdraw Amount',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['withdraw_accounts'] = $this->withdrawls_model->accounts();

        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();
        $this->bodyData['withdraw_accounts_balance'] = $this->accounts_model->withdraw_accounts_balance();
        $this->bodyData['few_withdrawls'] = $this->withdrawls_model->few_withdrawls();

        $this->load->view('components/header', $headerData);
        $this->load->view('withdrawls/withdraw', $this->bodyData);
        $this->load->view('components/footer');

    }

    public function history()
    {
        $headerData['title']='Withdrawls History';
        $this->bodyData['section'] = 'history';
        $this->bodyData['withdraw_history'] = $this->withdrawls_model->withdraw_history();

        $this->load->view('components/header',$headerData);
        $this->load->view('withdrawls/history', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function accounts()
    {
        $headerData = array(
            'title' => 'Withdraw Accounts',
        );

        $this->bodyData['someMessage'] = '';
        $this->bodyData['accounts'] = $this->withdrawls_model->accounts();

        $this->load->view('components/header', $headerData);
        $this->load->view('withdrawls/accounts', $this->bodyData);
        $this->load->view('components/footer');
    }


    /**
     * Below functions are used t save or deleted
     * records in db if needed
     **/
    public function is_any_thing_needs_to_be_deleted()
    {

    }
    public function is_any_thing_needs_to_be_saved()
    {

        /**
         * Withdraw amount from bank accounts
         **/
        if(isset($_POST['withdraw'])){
            if($this->form_validation->run('withdraw') == true){
                if( $this->withdrawls_model->withdraw() == true){
                    $this->helper_model->redirect_with_success('Voucher Saved Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }else{
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }

        /**
         * Inserting a new account for withdraw
         **/
        if(isset($_POST['addAccount'])){
            if($this->form_validation->run('addWithdrawAccount') == true){
                if( $this->withdrawls_model->add_account() == true){
                    $this->helper_model->redirect_with_success('Account Added Successfully!');
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

        }
    }
}
