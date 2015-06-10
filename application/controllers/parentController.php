<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ParentController extends CI_Controller {

    //public variables...
    public $login;
    public $bodyData;

    //protected members
    protected $search_keys;
    protected $sorting_info;

    public function __construct()
    {
        parent::__construct();


        /*
         * --------------------------------------
         * Prevent Cashing
         * --------------------------------------
         *
         * */
            header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        /*--------------------------------------------------------------*/

        include_once("libraries/php/helper.php");

        $this->load->helper(array('form', 'url', 'captcha'));
        $this->load->library(array('form_validation','email','Carbon','Helper','pagination', 'session'));
        $this->load->model(array(
            'parent_model',
            'admin_model',
            'helper_model',
            'privilege_model',
            'customers_model',
            'suppliers_model',
            'products_model',
            'tankers_model',
            'purchases_model',
            'sales_model',
            'stock_model',
            'bank_ac_model',
            'accounts_model',
            'ledgers_model',
            'payments_model',
            'receipts_model',
            'expenses_model',
            'expense_titles_model',
            'withdrawls_model',
            'source_destination_model',
            'intelligent_router_model',
            'editing_model',
            'deleting_model',
            'business_performance_model',
        ));

        //saving the latest route
        $this->intelligent_router_model->save_latest_route();

        //checking the login state below...
        $this->login = $this->helper_model->is_login();

        $this->set_bodyData();

        //check if user wants to delete some record
        if(method_exists($this,'is_any_thing_needs_to_be_deleted'))
            $this->is_any_thing_needs_to_be_deleted();

        //check if user wants to save something.
        if(method_exists($this,'is_any_thing_needs_to_be_saved'))
            $this->is_any_thing_needs_to_be_saved();

        //setting search keys.
        $this->set_search_keys();

        //setting sorting info.
        $this->set_sorting_info();

    }

    function _remap($method){
        if($this->login == false){
            $this->login();
        }
        else if($this->privilege_model->is_authenticated() == false)
        {
            $this->privilege_model->check_privileges();
        }
        else
        {
            $this->_call_with_args($method);
        }
    }


    public function login($msg = "")
    {

        if($this->login == true){
            $this->index();
        }else{
            $headerData = array(

            );
            $captcha = $this->helper_model->_create_captcha();
            $bodyData = array(
                'captcha' =>$captcha["image"],
                'captcha_word' =>$captcha['word'],

            );

            if ($this->form_validation->run('login') == true)
            {
                //logging in...
                $this->_LOGIN();
                if($this->login == false){
                    $data['message'] = "Login Failed!";
                    $data['type']="alert-danger";
                    $this->load->view('admin/login', $data);
                }else{
                    $this->index();
                }
            }
            else
            {
                $this->load->view('admin/login', $bodyData);
            }
        }
    }
    function _LOGIN(){
        $this->helper_model->login($this->input->post('username'));
        $this->login = $this->helper_model->is_login();
    }
    function logout(){
        $this->helper_model->logout();
        $this->login = $this->helper_model->is_login();
        $this->index();
    }

    private function set_bodyData()
    {
        $this->bodyData['section'] = $this->router->fetch_method();
    }

    /**
     * Below function first check if
     * any function for setting search keys
     * in the child controller is available
     * or not.
     * than call that function to set search
     * keys.
     **/
    public function set_search_keys()
    {
        //check if user wants to save something.
        if(method_exists($this,'set_search_keys_for_required_section'))
            $this->set_search_keys_for_required_section();

        //setting search keys to bodyData array
        $this->bodyData['search_keys'] = $this->search_keys;
    }

    /**
     * Below function first check if
     * any function for setting sorting info
     * in the child controller is available
     * or not.
     * than call that function to set
     * sorting info
     **/
    public function set_sorting_info()
    {
        $this->sorting_info = array();
        //check if user wants to save something.
        if(method_exists($this,'set_sort_info_for_required_section'))
            $this->set_sort_info_for_required_section();

        //setting search keys to bodyData array
        $this->bodyData['sorting_info'] = $this->sorting_info;
    }


    private function _loggedIn(){
        /*if($this->admin_model->loggedIn() == 1){
            return true;
        }else{
            return false;
        }*/
    }

    function _create_captcha(){
        /*$words = array( '2', '3', '4', '5', '6','7', '8', '9','0', 'a', 'b','z', 'n', 'b','x', 'y', 'v');
        $count = 1;
        $word = "";
        while($count < 3){
            $word = $word.$words[mt_rand(0, 16)];
            $count++;
        }
        $vals = array(
            'word'      => strtolower($word),
            'img_path'	=> './captcha/',
            'img_url'	=> base_url().'captcha/',
            'font_path'	=> 'fonts/DENMARK.ttf',
            'img_width'	=> '210',
            'img_height' => 40,
            'expiration' => 20
        );
        $cap = create_captcha($vals);
        return $cap;*/
    }

    private function _call_with_args($method, $args=""){
        if($args == ""){
            $args = array_slice($this->uri->rsegments,2);
        }
        if(method_exists($this,$method)){
            return call_user_func_array(array(&$this,$method),$args);
        }
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */