<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Products extends ParentController {
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
            redirect(base_url()."products/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'show';
            }
            redirect(base_url()."products/show");
        }
    }

    public function show()
    {
        $headerData = array(
            'title' => 'Products',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['columns'] = array();
        $this->bodyData['products'] = $this->products_model->get();

        if(isset($_GET['print']))
        {
            $this->load->view('prints/products', $this->bodyData);
        }
        else if(isset($_GET['export']))
        {
            $this->load->view('exports/products', $this->bodyData);
        }
        else
        {
        $this->load->view('components/header', $headerData);
        $this->load->view('products/welcome', $this->bodyData);
        $this->load->view('components/footer');
        }
    }

    public function _check_product_deletable($product)
    {

        if($this->products_model->have_usages($product) == true)
        {
            $this->form_validation->set_message('_check_product_deletable','product Cannot be deleted! Its being used in vouchers.');
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
         * delete a product
         **/
        if(isset($_POST['delete_product'])){
            if($this->form_validation->run('delete_product') == true){
                if( $this->deleting_model->delete_product($_POST['name']) == true){
                    $this->helper_model->redirect_with_success('Product Removed Successfully!');
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
         * insert a product
         **/
        if(isset($_POST['addProduct'])){
            if($this->form_validation->run('add_product') == true){
                if( $this->products_model->insert() == true){
                    $this->helper_model->redirect_with_success('Product Added Successfully!');
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
