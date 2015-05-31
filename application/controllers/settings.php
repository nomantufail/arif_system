<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Settings extends ParentController {
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
            redirect(base_url()."settings/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'accounts';
            }
            redirect(base_url()."settings/accounts");
        }
    }
    
    public function accounts()
    {

        $headerData = array(
            'title' => 'Settings ! Accounts',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['banks'] = $this->bank_ac_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('settings/accounts', $this->bodyData);
        $this->load->view('components/footer');
    }

    /**
    * This callback is used to validate new bank account
    **/
    public function _check_bank_title_unique()
    {
        $where = "title = '".$this->input->post('title')."' AND type = '".$this->input->post('type')."'";
        $existing_bank_accounts = $this->bank_ac_model->find_where($where);

        if(sizeof($existing_bank_accounts) > 0)
        {
            $this->form_validation->set_message('_check_bank_title_unique','Bank Account already exist. Please try again');
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

    }
    public function is_any_thing_needs_to_be_saved()
    {
        /**
         * insert a bank a/c
         **/
        if(isset($_POST['addBankAc'])){
            if($this->form_validation->run('add_bank_ac') == true){
                if( $this->bank_ac_model->insert() == true){
                    $this->helper_model->redirect_with_success('Bank A/c Added Successfully!');
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
