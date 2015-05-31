<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Expenses extends ParentController {
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
            redirect(base_url()."expenses/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'add';
            }
            redirect(base_url()."expenses/add");
        }
    }

    public function add()
    {
        $headerData = array(
            'title' => 'Add New Expense',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['tankers'] = $this->tankers_model->get();
        $this->bodyData['titles'] = $this->expense_titles_model->get();
        $this->bodyData['few_expenses'] = $this->expenses_model->few_expenses();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/add', $this->bodyData);
        $this->load->view('components/footer');

    }

    public function add_payment()
    {
        $headerData = array(
            'title' => 'Expense Payment',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();

        $this->bodyData['few_payments'] = $this->expenses_model->few_payments();
        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/add_payment', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function payment_history()
    {
        $headerData['title']='Expense Payment History';

        $this->bodyData['section'] = 'history';
        $this->bodyData['payment_history'] = $this->expenses_model->payment_history();

        $this->load->view('components/header',$headerData);
        $this->load->view('expenses/payment_history', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function show()
    {
        $headerData = array(
            'title' => 'Expense History',
        );

        $this->bodyData['expense_history'] = $this->expenses_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/expense_history', $this->bodyData);
        $this->load->view('components/footer');
    }
    public function titles()
    {
        $headerData = array(
            'title' => 'Expense Titles',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['titles'] = $this->expense_titles_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/expense_titles', $this->bodyData);
        $this->load->view('components/footer');
    }


    /**
     * Below functions are used t save or deleted
     * records in db if needed
     **/
    public function is_any_thing_needs_to_be_deleted()
    {

        /**
         * delete expense invoice
         **/
        if(isset($_POST['delete_expense_invoice'])){
            if($this->form_validation->run('delete_expense_invoice') == true){
                if( $this->deleting_model->delete_expense_invoice($_POST['invoice_number']) == true){
                    $this->helper_model->redirect_with_success('Invoice Removed Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }
            else
            {
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }

        /**
         * delete expense payment voucher
         **/
        if(isset($_POST['delete_expense_payment_voucher'])){
            if($this->form_validation->run('delete_expense_invoice') == true){
                if( $this->deleting_model->delete_expense_payment_invoice($_POST['invoice_number']) == true){
                    $this->helper_model->redirect_with_success('Invoice Removed Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }
            else
            {
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }
    }
    public function is_any_thing_needs_to_be_saved()
    {

        /**
         * insert a new expense title
         **/
        if(isset($_POST['addTitle'])){
            if($this->form_validation->run('add_expense_title') == true){
                if( $this->expense_titles_model->insert() == true){
                    $this->helper_model->redirect_with_success('Title Added Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }
            else
            {
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }

        /**
         * insert Expense voucher
         **/
        if(isset($_POST['addExpense'])){
            if($this->form_validation->run('addExpense') == true){
                if( $this->expenses_model->insert() == true){
                    $this->helper_model->redirect_with_success('Expense Added Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }
            else
            {
                $this->helper_model->redirect_with_errors(validation_errors());
            }
        }

        /**
         * save an expense payment voucher
         **/
        if(isset($_POST['savePayment'])){
            if($this->form_validation->run('saveExpensePayment') == true){
                $saved_payment = $this->expenses_model->insert_payment();
                if($saved_payment != 0){
                    $this->helper_model->redirect_with_success('Payment Saved Successfully!');
                }else{
                    $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
                }
            }
            else
            {
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
