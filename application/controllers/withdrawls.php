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

    public function edit_withdrawl($id)
    {
        if($id == '')
        {
            redirect(base_url()."withdrawls/withdraw");
        }
        if($this->accounts_model->voucher_active($id) == false)
        {
            redirect(base_url()."withdrawls/withdraw");
        }
        $withdraw_voucher = $this->withdrawls_model->find($id);
        if($withdraw_voucher == null)
        {
            $this->helper_model->redirect_with_errors('Voucher not found.', base_url()."withdrawls/withdraw");
        }

        $headerData = array(
            'title' => 'Withdraw Amount',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['withdraw_accounts'] = $this->withdrawls_model->accounts();

        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();
        $this->bodyData['withdraw_accounts_balance'] = $this->accounts_model->withdraw_accounts_balance();
        $this->bodyData['few_withdrawls'] = $this->withdrawls_model->few_withdrawls();

        $this->bodyData['withdraw'] = $withdraw_voucher;
        $this->bodyData['voucher_id'] = $id;

        $this->load->view('components/header', $headerData);
        $this->load->view('withdrawls/edit_withdraw', $this->bodyData);
        $this->load->view('components/footer');

    }

    public function history()
    {
        $headerData['title']='Withdrawls History';
        $this->bodyData['section'] = 'history';
        $this->bodyData['withdraw_history'] = $this->withdrawls_model->search_withdrawls_history($this->search_keys, $this->sorting_info);
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['withdraw_accounts'] = $this->withdrawls_model->accounts();

        if(isset($_GET['print']))
        {
            $this->load->view('prints/withdrawls', $this->bodyData);
        }
        else if(isset($_GET['export']))
        {
            $this->load->view('exports/withdrawls', $this->bodyData);
        }
        else
        {
        $this->load->view('components/header',$headerData);
        $this->load->view('withdrawls/history', $this->bodyData);
        $this->load->view('components/footer');
        }
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

        /**
         * delete withdraw vouchers
         **/
        if(isset($_POST['delete_voucher'])){
            if( $this->deleting_model->delete_withdraw_voucher($_POST['voucher_id']) == true){
                $this->helper_model->redirect_with_success('Voucher deleted Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
            }
        }
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
         * edit withdraw voucher
         **/
        if(isset($_POST['updateWithdraw'])){
            if( $this->withdrawls_model->update_withdraw($_POST['voucher_id']) == true){
                $this->helper_model->redirect_with_success('Voucher Saved Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
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
            case "history":
                $from = '';
                $to ='';
                $withdraw_accounts = array();
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
                if(isset($_GET['withdraw_account']))
                {
                    $withdraw_accounts = $_GET['withdraw_account'];
                }

                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['bank_acs'] = $bank_acs;
                $this->search_keys['withdraw_accounts'] = $withdraw_accounts;

                break;
        }

    }

    public function set_sort_info_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "history":
                $sortable_columns = $this->withdrawls_model->sortable_columns();
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
