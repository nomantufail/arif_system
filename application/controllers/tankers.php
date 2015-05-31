<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Tankers extends ParentController {
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
            redirect(base_url()."tankers/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'all';
            }
            redirect(base_url()."tankers/all");
        }
    }
    
    public function all()
    {
        $headerData['title'] = 'tankers';
        $this->bodyData['someMessage'] = '';

        $this->bodyData['tankers'] = $this->tankers_model->get();
        $this->load->view('components/header', $headerData);
        $this->load->view('tankers/welcome', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function _check_unique_tanker()
    {
        $where = "name = '".$this->input->post('name')."'";
        $existing_tankers = $this->tankers_model->find_where($where);

        if(sizeof($existing_tankers) > 0)
        {
            $this->form_validation->set_message('_check_unique_tanker','tanker already exist. Please try again');
            return false;
        }
        return true;
    }


    public function _check_tanker_deletable($tanker)
    {
        if($this->tankers_model->have_usages($tanker) == true)
        {
            $this->form_validation->set_message('_check_tanker_deletable','Tanker Cannot be deleted! Its being used in the system.');
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
         * Removing a tanker
         **/
        if(isset($_POST['delete_tanker'])){
            if($this->form_validation->run('delete_tanker') == true){
                if( $this->deleting_model->delete_tanker($_POST['number']) == true){
                    $this->helper_model->redirect_with_success('Tanker Deleted Successfully!');
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
         * insert a tanker in system
         **/
        if(isset($_POST['addtanker'])){
            if($this->form_validation->run('add_tanker') == true){
                if( $this->tankers_model->insert() == true){
                    $this->helper_model->redirect_with_success('Tanker Saved Successfully!');
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
