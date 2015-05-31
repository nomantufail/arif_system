<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Customers extends ParentController {
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
            redirect(base_url()."customers/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'all';
            }
            redirect(base_url()."customers/all");
        }
    }
    
    public function all()
    {
        $headerData['title'] = 'Customers';
        $this->bodyData['someMessage'] = '';

        $this->bodyData['customers'] = $this->customers_model->get();
        $this->load->view('components/header', $headerData);
        $this->load->view('customers/welcome', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function _check_unique_customer()
    {
        $where = "name = '".$this->input->post('name')."'";
        $existing_customers = $this->customers_model->find_where($where);

        if(sizeof($existing_customers) > 0)
        {
            $this->form_validation->set_message('_check_unique_customer','Customer already exist. Please try again');
            return false;
        }
        return true;
    }
    public function _check_customer_deletable($customer)
    {

        if($this->customers_model->have_vouchers($customer) == true)
        {
            $this->form_validation->set_message('_check_customer_deletable','Customer Cannot be deleted! Its being used in vouchers.');
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
         * delete a customer
         **/
        if(isset($_POST['delete_customer'])){
            if($this->form_validation->run('delete_customer') == true){
                if( $this->deleting_model->force_delete_where('customers', array('name'=>$_POST['name'])) == true){
                    $this->helper_model->redirect_with_success('customer Removed Successfully!');
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
         * insert a new customer in system
         **/
        if(isset($_POST['addCustomer'])){
            if($this->form_validation->run('add_customer') == true){
                if( $this->customers_model->insert() == true){
                    $this->helper_model->redirect_with_success('customer Added Successfully!');
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
