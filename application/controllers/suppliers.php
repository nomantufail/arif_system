<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Suppliers extends ParentController {
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
            redirect(base_url()."suppliers/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'all';
            }
            redirect(base_url()."suppliers/all");
        }
    }
    
    public function all()
    {
        $headerData['title'] = 'suppliers';
        $this->bodyData['someMessage'] = '';
        $this->bodyData['suppliers'] = $this->suppliers_model->get();

        if(isset($_GET['print']))
        {
            $this->load->view('prints/suppliers', $this->bodyData);
        }
        else if(isset($_GET['export']))
        {
            $this->load->view('exports/suppliers', $this->bodyData);
        }
        else
        {
        $this->load->view('components/header', $headerData);
        $this->load->view('suppliers/welcome', $this->bodyData);
        $this->load->view('components/footer');
        }
    }

    public function _check_unique_supplier()
    {
        $where = "name = '".$this->input->post('name')."'";
        $existing_suppliers = $this->suppliers_model->find_where($where);

        if(sizeof($existing_suppliers) > 0)
        {
            $this->form_validation->set_message('_check_unique_supplier','supplier already exist. Please try again');
            return false;
        }
        return true;
    }


    public function _check_supplier_deletable($supplier)
    {
        if($this->suppliers_model->have_vouchers($supplier) == true)
        {
            $this->form_validation->set_message('_check_supplier_deletable','Supplier Cannot be deleted! Its being used in vouchers.');
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
         * Delete a supplier
         **/
        if(isset($_POST['delete_supplier'])){
            if($this->form_validation->run('delete_supplier') == true){
                if( $this->deleting_model->force_delete_where('suppliers', array('name'=>$_POST['name'])) == true){
                    $this->helper_model->redirect_with_success('Supplier Removed Successfully!');
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
         * insert a new supplier
         **/
        if(isset($_POST['addSupplier'])){
            if($this->form_validation->run('add_supplier') == true){
                if( $this->suppliers_model->insert() == true){
                    $this->helper_model->redirect_with_success('Supplier Saved Successfully!');
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
