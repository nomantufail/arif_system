<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Error_Reporting extends ParentController {
    //public variables...

    public function __construct()
    {
        parent::__construct();

        /**
         * if there is nothing to to report
         * than relocate to home
         **/
        $errors = $this->helper_model->get_flash_errors();
        if($errors == '')
        {
            redirect(base_url()."admin/home");
        }
    }

    public function index()
    {

    }

    public function missing_prerequisites($section = null)
    {
        $headerData = array(
            'title' => 'Missing Prerequisites',
        );

        $this->load->view('components/header', $headerData);

        switch($section)
        {
            case "ledgers":
                $this->load->view('ledgers/components/missing_prerequisites', $this->bodyData);
                break;
            default:
                $this->load->view('error_reporting/missing_prerequisites', $this->bodyData);
        }

        $this->load->view('components/footer');

    }

}
