<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");

class Admin extends ParentController {

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
            $this->$target_function();
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'home';
            }
            $this->home();
        }
    }

    public function under_development($for="")
    {
        $headerData = array(
            'title' => 'Inventory | Home',
        );
        $this->load->view('components/header', $headerData);
        $this->load->view('admin/under_development');
        $this->load->view('components/footer');
    }

    public function home()
    {
        $headerData['title']='Home';
        $this->bodyData['section'] = 'home';
        $this->load->view('components/header',$headerData);
        $this->load->view('admin/home', $this->bodyData);
        $this->load->view('components/footer');
    }


}
