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
            redirect(base_url()."stock/overview");
        }
    }
    public function overview()
    {
        $headerData = array(
            'title' => 'Stock',
        );
        $bodyData['stock'] = $this->stock_model->get();

        if(isset($_GET['print']))
        {
            $this->load->view('prints/stock', $this->bodyData);
        }
        else if(isset($_GET['export']))
        {
            $this->load->view('exports/stock', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('stock/overview', $bodyData);
            $this->load->view('components/footer');
        }
    }

    public function history()
    {
        $headerData = array(
            'title' => 'Stock History',
        );
        $this->bodyData['history'] = $this->stock_model->get_history($this->search_keys);
        $this->bodyData['products'] = $this->products_model->get();
        $this->bodyData['opening_stock'] = $this->stock_model->opening_stock($this->search_keys);
        $this->bodyData['tankers'] = $this->tankers_model->get();
        if(isset($_GET['print']))
        {
            $this->load->view('prints/stock_history', $this->bodyData);
        }
        else if(isset($_GET['export']))
        {
            $this->load->view('exports/stock', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('stock/history', $this->bodyData);
            $this->load->view('components/footer');
        }
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
            case "history":
                $from = '';
                $to ='';
                $tanker = "00000";
                $product = "hsd";
                if(isset($_GET['from']))
                {
                    $from = $_GET['from'];
                }
                else
                {
                    $date = Carbon::now()->toDateString();
                    $from = first_day_of_month($date);
                }
                if(isset($_GET['to']))
                {
                    $to = $_GET['to'];
                }
                else
                {
                    $date = Carbon::now()->toDateString();
                    $to = $date;
                }
                if(isset($_GET['product']))
                {
                    $product = $_GET['product'];
                }

                if(isset($_GET['tanker']))
                {
                    $tanker = $_GET['tanker'];
                }

                $this->search_keys['from'] = $from;
                $this->search_keys['to'] = $to;
                $this->search_keys['tanker'] = $tanker;
                $this->search_keys['product'] = $product;

                break;

        }
    }
}
