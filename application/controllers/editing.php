<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Editing extends ParentController {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function delete_record($table, $id)
    {
        if($this->helper_model->delete_record($table, $id) == true){
            echo "ok";
        }else{
            echo "error";
        }
    }
    public function edit_global_record($table, $rules='')
    {
        $ci = CI_Controller::get_instance();

        $rules = str_replace('%7C','|',$rules);
        $this->form_validation->set_rules('value', 'given', $rules);
        if ($this->form_validation->run() == FALSE)
        {
            $this->output->set_content_type('application/json');
            echo strip_tags(validation_errors());
        }
        else
        {
            $pk = $this->input->post('pk');
            $name = $this->input->post('name');
            $value = $this->input->post('value');

            $result = false;
            $result = $this->editing_model->edit_global_record($table, $pk, $name, $value);
            if($result == false)
            {
                $this->output->set_content_type('application/json');
                echo strip_tags("Dear User! Some unknown database fault happened. This might be
                    temporary. Refresh this page and try once more. Otherwise contact your system provider. Thank You.
                ");
            }
        }
    }

    public function edit_record_in_multiple_tables($section, $rules='')
    {
        $ci = CI_Controller::get_instance();

        $rules = str_replace('%7C','|',$rules);
        $this->form_validation->set_rules('value', 'given', $rules);
        if ($this->form_validation->run() == FALSE)
        {
            $this->output->set_content_type('application/json');
            echo strip_tags(validation_errors());
        }
        else
        {
            $key = $this->input->post('pk');
            $name = $this->input->post('name');
            $value = $this->input->post('value');


            $result = false;

            switch($section)
            {
                case "product":
                    $result = $this->editing_model->edit_product($name, $value, $key);
                    break;
                case "customer":
                    $result = $this->editing_model->edit_customer($name, $value, $key);
                    break;
                case "supplier":
                    $result = $this->editing_model->edit_supplier($name, $value, $key);
                    break;
                case "tanker":
                    $result = $this->editing_model->edit_tanker($name, $value, $key);
                    break;
                case "bank_account":
                    $result = $this->editing_model->edit_bank_account($name, $value, $key);
                    break;
                case "expense_title":
                    $result = $this->editing_model->edit_expense_title($name, $value, $key);
                    break;
                case "withdraw_account_title":
                    $result = $this->editing_model->edit_withdraw_account_title($name, $value, $key);
                    break;
            }

            if($result != true)
            {
                $this->output->set_content_type('application/json');
                echo strip_tags("Dear User! Some unknown database fault happened. This might be
                    temporary. Refresh this page and try once more. Otherwise contact your system provider. Thank You.
                ");
            }
        }
    }

}
