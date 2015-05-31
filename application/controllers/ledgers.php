<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class ledgers extends ParentController {
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
            redirect(base_url()."ledgers/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'customers';
            }
            redirect(base_url()."ledgers/customers");
        }
    }

    public function customers()
    {
        $this->bodyData['customers'] = $this->customers_model->get();

        $from = '';
        $to ='';
        $customer = '';
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

        if(isset($_GET['customer']))
        {
            $customer = $_GET['customer'];
        }
        else
        {
            $current_customer = $this->bodyData['customers'][0];
            $customer = $current_customer->name;
        }

        $ac_title = '';
        if(isset($_GET['ac_title']))
        {
            $ac_title = $_GET['ac_title'];
        }

        $ac_type = '';
        if(isset($_GET['ac_type']))
        {
            $ac_type = $_GET['ac_type'];
        }

        $keys = array(
            'from'=>$from,
            'to'=>$to,
            'customer'=>$customer,
            'ac_type'=>$ac_type,
            'ac_title'=>$ac_title,
        );

        $this->bodyData['from'] = $from;
        $this->bodyData['selected_customer'] = $customer;
        $this->bodyData['to'] = $to;
        $this->bodyData['ac_title'] = $ac_title;
        $this->bodyData['ac_type'] = $ac_type;

        $headerData['title']="Ledgers: Customer";
        $this->bodyData['account_titles'] = $this->accounts_model->account_titles("customers");
        $this->bodyData['account_types'] = $this->accounts_model->account_types();
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance("customers", $keys);
        $this->bodyData['ledger'] = $this->ledgers_model->customer_ledger($keys);

        if(isset($_GET['print']))
        {
            $this->load->view('ledgers/print/customer', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('ledgers/customer', $this->bodyData);
            $this->load->view('components/footer');
        }

    }

    public function suppliers()
    {
        $this->bodyData['suppliers'] = $this->suppliers_model->get();
        $from = '';
        $to ='';
        $supplier = '';
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

        if(isset($_GET['supplier']))
        {
            $supplier = $_GET['supplier'];
        }
        else
        {
            $current_supplier = $this->bodyData['suppliers'][0];
            $supplier = $current_supplier->name;
        }

        $ac_title = '';
        if(isset($_GET['ac_title']))
        {
            $ac_title = $_GET['ac_title'];
        }

        $ac_type = '';
        if(isset($_GET['ac_type']))
        {
            $ac_type = $_GET['ac_type'];
        }

        $keys = array(
            'from'=>$from,
            'to'=>$to,
            'supplier'=>$supplier,
            'ac_type'=>$ac_type,
            'ac_title'=>$ac_title,
        );

        $this->bodyData['from'] = $from;
        $this->bodyData['selected_supplier'] = $supplier;
        $this->bodyData['to'] = $to;
        $this->bodyData['ac_title'] = $ac_title;
        $this->bodyData['ac_type'] = $ac_type;

        $headerData['title']="Ledgers: Supplier";
        $this->bodyData['account_titles'] = $this->accounts_model->account_titles("suppliers");
        $this->bodyData['account_types'] = $this->accounts_model->account_types();
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance("suppliers", $keys);
        $this->bodyData['ledger'] = $this->ledgers_model->supplier_ledger($keys);
        if(isset($_GET['print']))
        {
            $this->load->view('ledgers/print/supplier', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('ledgers/supplier', $this->bodyData);
            $this->load->view('components/footer');
        }
    }


    public function tankers()
    {
        $this->bodyData['tankers'] = $this->tankers_model->get();
        $from = '';
        $to ='';
        $tanker = '';
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

        if(isset($_GET['tanker']))
        {
            $tanker = $_GET['tanker'];
        }
        else
        {
            $current_tanker = $this->bodyData['tankers'][0];
            $tanker = $current_tanker->number;
        }

        $ac_title = '';
        if(isset($_GET['ac_title']))
        {
            $ac_title = $_GET['ac_title'];
        }

        $ac_type = '';
        if(isset($_GET['ac_type']))
        {
            $ac_type = $_GET['ac_type'];
        }

        $keys = array(
            'from'=>$from,
            'to'=>$to,
            'tanker'=>$tanker,
            'ac_type'=>$ac_type,
            'ac_title'=>$ac_title,
        );

        $this->bodyData['from'] = $from;
        $this->bodyData['selected_tanker'] = $tanker;
        $this->bodyData['to'] = $to;
        $this->bodyData['ac_title'] = $ac_title;
        $this->bodyData['ac_type'] = $ac_type;

        $headerData['title']="Ledgers: tanker";
        $this->bodyData['account_titles'] = $this->accounts_model->account_titles("tankers");
        $this->bodyData['account_types'] = $this->accounts_model->account_types();
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance("tankers", $keys);
        $this->bodyData['ledger'] = $this->ledgers_model->tanker_ledger($keys);
        if(isset($_GET['print']))
        {
            $this->load->view('ledgers/print/tanker', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('ledgers/tanker', $this->bodyData);
            $this->load->view('components/footer');
        }
    }
    public function bank_accounts()
    {
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get_formatted();
        $from = '';
        $to ='';
        $tanker = '';
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

        if(isset($_GET['ac_title']))
        {
            $ac_title = $_GET['ac_title'];
        }
        else
        {
            $current_title = $this->bodyData['bank_accounts'][0];
            $ac_title = $current_title->formatted_title;
        }

        $ac_type = '';
        if(isset($_GET['ac_type']))
        {
            $ac_type = $_GET['ac_type'];
        }

        $keys = array(
            'from'=>$from,
            'to'=>$to,
            'ac_type'=>$ac_type,
            'ac_title'=>$ac_title,
        );

        $this->bodyData['from'] = $from;
        $this->bodyData['to'] = $to;
        $this->bodyData['ac_title'] = $ac_title;
        $this->bodyData['ac_type'] = $ac_type;

        $headerData['title']="Ledgers: tanker";
        $this->bodyData['account_types'] = $this->accounts_model->account_types();
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance_of_bank_accounts($keys);
        $this->bodyData['ledger'] = $this->ledgers_model->bank_ac_ledger($keys);
        if(isset($_GET['print']))
        {
            $this->load->view('ledgers/print/bank_accounts', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('ledgers/bank_accounts', $this->bodyData);
            $this->load->view('components/footer');
        }
    }


    public function withdrawls()
    {
        $this->bodyData['withdrawl_accounts'] = $this->withdrawls_model->accounts();
        $from = '';
        $to ='';
        $tanker = '';
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

        if(isset($_GET['ac_title']))
        {
            $ac_title = $_GET['ac_title'];
        }
        else
        {
            $current_title = $this->bodyData['withdrawl_accounts'][0];
            $ac_title = $current_title->title;
        }

        $ac_type = '';

        $keys = array(
            'from'=>$from,
            'to'=>$to,
            'ac_type'=>$ac_type,
            'ac_title'=>$ac_title,
        );

        $this->bodyData['from'] = $from;
        $this->bodyData['to'] = $to;
        $this->bodyData['ac_title'] = $ac_title;
        $this->bodyData['ac_type'] = $ac_type;

        $headerData['title']="Ledgers: tanker";
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance("", $keys);
        $this->bodyData['ledger'] = $this->ledgers_model->withdrawls_ledger($keys);
        $this->load->view('components/header', $headerData);
        $this->load->view('ledgers/withdrawls', $this->bodyData);
        $this->load->view('components/footer');
    }
}
