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
            $current_customer = (sizeof($this->bodyData['customers']) > 0)?$this->bodyData['customers'][0]:null;
            $customer = (sizeof($this->bodyData['customers']) > 0)?$current_customer->name:null;
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
        $this->bodyData['ledger'] = $this->ledgers_model->customer_ledger($keys, $this->sorting_info);

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
            $current_supplier = (sizeof($this->bodyData['suppliers']))?$this->bodyData['suppliers'][0]:null;
            $supplier = (sizeof($this->bodyData['suppliers']))?$current_supplier->name:null;;
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
        $this->bodyData['ledger'] = $this->ledgers_model->supplier_ledger($keys, $this->sorting_info);
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
        $tankers = $this->tankers_model->get();

        $this->check_for_prerequisites(array('tankers'=>$tankers,),'tankers');

        $this->bodyData['tankers'] = $tankers;

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
            $current_tanker = (sizeof($this->bodyData['tankers']) > 0)?$this->bodyData['tankers'][0]:null;
            $tanker = (sizeof($this->bodyData['tankers']) > 0)?$current_tanker->number:null;;
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
        $this->bodyData['ledger'] = $this->ledgers_model->tanker_ledger($keys, $this->sorting_info);
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


    public function products()
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
            'ac_type'=>$ac_type,
            'ac_title'=>$ac_title,
        );

        $this->bodyData['from'] = $from;
        $this->bodyData['to'] = $to;
        $this->bodyData['ac_title'] = $ac_title;
        $this->bodyData['ac_type'] = $ac_type;
        $this->bodyData['products'] = $this->products_model->get();

        $headerData['title']="Ledgers: Products";
        $this->bodyData['account_titles'] = $this->accounts_model->account_titles("customers");
        $this->bodyData['account_types'] = $this->accounts_model->account_types();
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance("customers", $keys);
        $this->bodyData['ledger'] = $this->ledgers_model->products_ledger($keys, $this->sorting_info);

        if(isset($_GET['print']))
        {
            $this->load->view('ledgers/print/product', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('ledgers/product', $this->bodyData);
            $this->load->view('components/footer');
        }

    }

    public function bank_accounts()
    {
        $bank_accounts = $this->bank_ac_model->get_formatted();
        $this->check_for_prerequisites(array('bank_accounts'=>$bank_accounts,),'bank_accounts');
        $this->bodyData['bank_accounts'] = $bank_accounts;
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
            $current_title = (sizeof($this->bodyData['bank_accounts']) > 0)?$this->bodyData['bank_accounts'][0]:null;
            $ac_title = (sizeof($this->bodyData['bank_accounts']) > 0)?$current_title->formatted_title:null;
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
        $this->bodyData['ledger'] = $this->ledgers_model->bank_ac_ledger($keys, $this->sorting_info);
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
        $withdraw_accounts = $this->withdrawls_model->accounts();
        $this->check_for_prerequisites(array('withdraw_accounts'=>$withdraw_accounts), 'withdrawls');
        $this->bodyData['withdrawl_accounts'] = $withdraw_accounts;
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
            $current_title = (sizeof($this->bodyData['withdrawl_accounts']) > 0)?$this->bodyData['withdrawl_accounts'][0]:null;
            $ac_title = (sizeof($this->bodyData['withdrawl_accounts']) > 0)?$current_title->title:null;
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

        $headerData['title']="Ledgers: Withdrawls";
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance("", $keys);
        $this->bodyData['ledger'] = $this->ledgers_model->withdrawls_ledger($keys, $this->sorting_info);

        if(isset($_GET['print']))
        {
            $this->load->view('ledgers/print/withdrawls', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('ledgers/withdrawls', $this->bodyData);
            $this->load->view('components/footer');
        }
    }

    public function cash()
    {

        $from = '';
        $to ='';
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

        $keys = array(
            'from'=>$from,
            'to'=>$to,
        );

        $this->bodyData['from'] = $from;
        $this->bodyData['to'] = $to;

        $headerData['title']="Ledgers: Cash";
        $this->bodyData['opening_balance'] = $this->ledgers_model->opening_balance_for_cash_ledgers($keys['from']);
        $this->bodyData['ledger'] = $this->ledgers_model->cash_ledgers($keys, $this->sorting_info);

        if(isset($_GET['print']))
        {
            $this->load->view('ledgers/print/cash', $this->bodyData);
        }
        else
        {
            $this->load->view('components/header', $headerData);
            $this->load->view('ledgers/cash', $this->bodyData);
            $this->load->view('components/footer');
        }
    }

    public function check_for_prerequisites($data, $section = null)
    {
        $message = array();

        if($section == 'tankers')
        {

            $tankers = $data['tankers'];

            if(sizeof($tankers) == 0)
            {
                array_push($message, 'Atleast 1 Tanker needed. Click <a href="'.base_url()."tankers".'">Here</a> to add.');
            }

            $message = join('<br>',$message);

            if($message != '')
            {
                $this->helper_model->redirect_with_errors(
                    $message,
                    base_url()."error_reporting/missing_prerequisites/ledgers");
            }
        }

        if($section == "withdrawls")
        {
            $withdrawls_accounts = $data['withdraw_accounts'];
            if(sizeof($withdrawls_accounts) == 0)
            {
                array_push($message, 'Atleast 1 withdrawl account needed. Click <a href="'.base_url()."withdrawls/accounts".'">Here</a> to add.');
            }

            $message = join('<br>',$message);

            if($message != '')
            {
                $this->helper_model->redirect_with_errors(
                    $message,
                    base_url()."error_reporting/missing_prerequisites/ledgers");
            }
        }

        if($section == "bank_accounts")
        {
            $bank_accounts = $data['bank_accounts'];
            if(sizeof($bank_accounts) == 0)
            {
                array_push($message, 'Atleast 1 Bank account needed. Click <a href="'.base_url()."settings/accounts".'">Here</a> to add.');
            }

            $message = join('<br>',$message);

            if($message != '')
            {
                $this->helper_model->redirect_with_errors(
                    $message,
                    base_url()."error_reporting/missing_prerequisites/ledgers");
            }
        }

    }


    public function set_sort_info_for_required_section()
    {
        $area = $this->uri->segment(2);
        switch($area)
        {
            case "customers":
                $sortable_columns = $this->ledgers_model->sortable_columns('customers');
                $sort_by = 'vouchers.id';
                $order_by = 'desc';
                break;
            case "suppliers":
                $sortable_columns = $this->ledgers_model->sortable_columns('suppliers');
                $sort_by = 'vouchers.id';
                $order_by = 'desc';
                break;
            case "bank_accounts":
                $sortable_columns = $this->ledgers_model->sortable_columns('bank_accounts');
                $sort_by = 'vouchers.id';
                $order_by = 'desc';
                break;
            case "tankers":
                $sortable_columns = $this->ledgers_model->sortable_columns('tankers');
                $sort_by = 'vouchers.id';
                $order_by = 'desc';
                break;
            case "withdrawls":
                $sortable_columns = $this->ledgers_model->sortable_columns('withdrawls');
                $sort_by = 'vouchers.id';
                $order_by = 'desc';
                break;
            case "cash":
                $sortable_columns = $this->ledgers_model->sortable_columns('cash');
                $sort_by = 'voucher_id';
                $order_by = 'desc';
                break;
            default:
                $sort_by = 'voucher_id';
                $order_by = 'desc';
        }

        if(isset($_GET['sort_by']) && array_key_exists($_GET['sort_by'], $sortable_columns))
        {
            $sort_by = $sortable_columns[$_GET['sort_by']];
        }
        if(isset($_GET['order']) && $_GET['order'] == 'asc')
        {
            $order_by = 'asc';
        }

        $this->sorting_info['sort_by'] = $sort_by;
        $this->sorting_info['order_by'] = $order_by;
    }
}
