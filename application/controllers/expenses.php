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

    public function edit($id)
    {
        if($id == '')
        {
            redirect(base_url()."expenses/add");
        }
        if($this->accounts_model->voucher_active($id) == false)
        {
            redirect(base_url()."expenses/add");
        }
        $expense = $this->expenses_model->find($id);
        if($expense == null)
        {
            $this->helper_model->redirect_with_errors('Voucher not found.', base_url()."expenses/add");
        }

        $headerData['title']='Edit Expense';
        $this->bodyData['someMessage'] = '';
        $this->bodyData['tankers'] = $this->tankers_model->get();
        $this->bodyData['titles'] = $this->expense_titles_model->get();
        $this->bodyData['few_expenses'] = $this->expenses_model->few_expenses();
        $this->bodyData['expense'] = $expense;
        $this->bodyData['voucher_id'] = $id;

        $this->load->view('components/header',$headerData);
        $this->load->view('expenses/edit_expense', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function edit_payment($id)
    {
        if($id == '')
        {
            redirect(base_url()."expenses/add_payment");
        }
        if($this->accounts_model->voucher_active($id) == false)
        {
            redirect(base_url()."expenses/add_payment");
        }
        $payment_voucher = $this->expenses_model->find_payment($id);
        if($payment_voucher == null)
        {
            $this->helper_model->redirect_with_errors('Voucher not found.', base_url()."expenses/add_payment");
        }

        $headerData['title']='Edit Expense Payment';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();

        $this->bodyData['banks_balance'] = $this->accounts_model->banks_balance();
        $this->bodyData['few_payments'] = $this->expenses_model->few_payments();
        $this->bodyData['payment'] = $payment_voucher;

        $this->bodyData['voucher_id'] = $id;

        $this->load->view('components/header',$headerData);
        $this->load->view('expenses/edit_payment', $this->bodyData);
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
        $this->bodyData['payment_history'] = $this->expenses_model->search_expense_payment_history($this->search_keys, $this->sorting_info);

        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();

        $this->load->view('components/header',$headerData);
        $this->load->view('expenses/payment_history', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function show()
    {
        $headerData = array(
            'title' => 'Expense History',
        );

        $this->bodyData['expense_history'] = $this->expenses_model->search_expense_history($this->search_keys, $this->sorting_info);

        $this->bodyData['titles'] = $this->expense_titles_model->get();
        $this->bodyData['tankers'] = $this->tankers_model->get();

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

    public function _check_expense_title_deletable($title)
    {

        if($this->expense_titles_model->have_usages($title) == true)
        {
            $this->form_validation->set_message('_check_expense_title_deletable','Title Cannot be deleted! Its being used in vouchers.');
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

        /**
         * delete an expense title
         **/
        if(isset($_POST['delete_expense_title'])){
            if($this->form_validation->run('delete_expense_title') == true){
                if( $this->deleting_model->delete_expense_title($_POST['title']) == true){
                    $this->helper_model->redirect_with_success('Expense title Removed Successfully!');
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


        /**
         * update an expense
         **/
        if(isset($_POST['updateExpense']))
        {
            $saved_receipt = $this->expenses_model->update_expense($_POST['voucher_id']);
            if($saved_receipt != 0){
                $this->helper_model->redirect_with_success('Expense Saved Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
            }
        }

        /**
         * update an expense payment
         **/
        if(isset($_POST['updatePayment']))
        {
            $saved_receipt = $this->expenses_model->update_expense_payment($_POST['voucher_id']);
            if($saved_receipt != 0){
                $this->helper_model->redirect_with_success('Payment Saved Successfully!');
            }else{
                $this->helper_model->redirect_with_errors('Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You');
            }
        }
    }
    public function set_sort_info_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "show":
                $sortable_columns = $this->expenses_model->sortable_columns('expenses');
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

            case "payment_history":
                $sortable_columns = $this->expenses_model->sortable_columns('expense_payments');
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
    public function set_search_keys_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "show":
                $from = '';
                $to ='';
                $tankers = array();
                $titles = array();
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

                if(isset($_GET['tanker']))
                {
                    $tankers = $_GET['tanker'];
                }
                if(isset($_GET['title']))
                {
                    $titles = $_GET['title'];
                }

                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['titles'] = $titles;
                $this->search_keys['tankers'] = $tankers;

                break;

            case "payment_history":
                $from = '';
                $to ='';
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

                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['bank_acs'] = $bank_acs;

                break;
        }
    }
}
