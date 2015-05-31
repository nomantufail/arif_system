<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Stock extends ParentController {
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
            redirect(base_url()."stock/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'show';
            }
            redirect(base_url()."stock/show");
        }
    }
    public function show()
    {
        $headerData = array(
            'title' => 'Stock',
        );

        $bodyData['stock'] = $this->stock_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('stock/show', $bodyData);
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

    }

    public function set_search_keys_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {

        }
    }
}
