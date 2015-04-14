<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");

class Admin extends ParentController {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect(base_url()."sales/");
        $headerData = array(
            'title' => 'Inventory | Home',
            'page' => 'home',
        );
        $this->load->view('components/header', $headerData);
        $this->load->view('admin/welcome', $headerData);
        $this->load->view('components/footer');
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



}
