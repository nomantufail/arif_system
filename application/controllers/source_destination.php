<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Source_Destination extends ParentController {
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
            redirect(base_url()."source_destination/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'show';
            }
            redirect(base_url()."source_destination/show");
        }
    }

    public function show()
    {
        $headerData = array(
            'title' => 'Source / Destination',
        );
        $this->bodyData['someMessage'] = '';

        $this->bodyData['cities'] = $this->source_destination_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('source_destination/show', $this->bodyData);
        $this->load->view('components/footer');

    }


    /**
     * Below functions are used t save or deleted
     * records in db if needed
     **/
    public function is_any_thing_needs_to_be_deleted()
    {
        /**
         * delete a city
         **/
        if(isset($_POST['delete_city'])){
            if($this->form_validation->run('delete_city') == true){
                if( $this->source_destination_model->delete($_POST['id']) == true){
                    $this->helper_model->redirect_with_success('Freight Point Successfully deleted!');
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
         * insert a city
         **/
        if(isset($_POST['addCity'])){
            if($this->form_validation->run('add_city') == true){
                if( $this->source_destination_model->insert() == true){
                    $this->helper_model->redirect_with_success('Freight Point Successfully added!');
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
