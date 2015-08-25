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

        if($target_function != 'index' && $target_function != 'login')
        {
            //setting section
            $this->bodyData['section'] = $target_function;
            //and there we go...
            redirect(base_url()."admin/".$target_function);
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'home';
            }
            redirect(base_url()."admin/home");
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
        $date = Carbon::now()->toDateString();
        $from = first_day_of_month($date);
        $to = $date;

        $this->bodyData['from'] = $from;
        $this->bodyData['to'] = $to;

        $headerData['title']='Home';
        $this->bodyData['section'] = 'home';

        $this->bodyData['total_sales'] = $this->sales_model->total_sales($from, $to);
        $this->bodyData['total_purchases'] = $this->purchases_model->total_purchases($from, $to);
        $this->bodyData['total_payables'] = $this->payments_model->total_payables($from, $to);
        $this->bodyData['total_receivables'] = $this->receipts_model->total_receivables($from, $to);

        $this->bodyData['bank_accounts'] = $this->accounts_model->bank_accounts_status();

        $this->bodyData['profit_loss'] = $this->accounts_model->profit_loss($from, $to);

        $this->bodyData['business_performance'] = $this->business_performance_model->month_by_month_expense_sales_purchase_sheet();

        $this->load->view('components/header',$headerData);
        $this->load->view('admin/home', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function update_bank_entries()
    {
        $this->db->select('id');
        $this->db->where('ac_type','bank');
        $result = $this->db->get('voucher_entries')->result();
        $entry_ids = array();
        foreach($result as $record)
        {
            array_push($entry_ids, $record->id);
        }

        $bank_1 = "Yasir Ali (Al-Falah 12****789)";
        $bank_2 = "Mukhtar Shah (Standard Charted 98****321)";
        $this->db->where_in('id',$entry_ids);
        $this->db->where('id >',39);
        $data = array(
            'ac_title'=>$bank_1,
        );
        $this->db->update('voucher_entries',$data);

        $this->db->where_in('id',$entry_ids);
        $this->db->where('id <=',39);
        $data = array(
            'ac_title'=>$bank_2,
        );
        $this->db->update('voucher_entries',$data);
    }





    ////// Rough Work


    public function route_sale_view()
    {
        $this->admin_model->route_sale_view();
    }

    function payments_view()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.voucher_date, vouchers.summary,
            (
                case
                    when vouchers.bank_ac = '' then
                        'cash'
                    else
                        vouchers.bank_ac
                end
            ) as account,

            (
                case
                    when voucher_entries.related_supplier = '' then
                        voucher_entries.related_customer
                    else
                        voucher_entries.related_supplier
                end
            ) as agent,

            (
                case
                    when voucher_entries.related_supplier = '' then
                        'customer'
                    else
                        'supplier'
                end
            ) as agent_type,
            voucher_entries.id as entry_id,voucher_entries.amount,
        ");

        $this->db->from('voucher');
        $this->db->join('voucher_entries', 'voucher_entries.voucher_id = vouchers.id','inner');
        $this->db->where('vouchers.voucher_type','payment');
        $this->db->where('voucher_entries.dr_cr','1');
        $this->db->where('vouchers.deleted',0);
        $result = $this->db->get()->result();

        var_dump($result); die();
    }

    public function change_receipt_title()
    {
        $this->db->select('voucher_entries.id');
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','inner');
        $this->db->where('vouchers.voucher_type','receipt');
        $this->db->where('voucher_entries.ac_title','cash');
        $result = $this->db->get('vouchers')->result();

        $ids = property_to_array('id',$result);
        $this->db->where_in('voucher_entries.id',$ids);
        $this->db->update('voucher_entries',array(
            'ac_title'=>'receipt',
        ));
    }


    function stock_history()
    {
        $this->db->select('
            vouchers.id as voucher_id, voucher_entries.id as voucher_entry_id,
            vouchers.voucher_date, vouchers.inserted_at, voucher_entries.cost_per_item,
            (
                case
                    when vouchers.voucher_type = "purchase" then
                        "in"
                    else
                        "out"
                end
            ) as in_out,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        voucher_entries.quantity
                    else
                        0
                end
            ) as s_in,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        0
                    else
                        voucher_entries.quantity
                end
            ) as s_out,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        "supplier"
                    else
                        "customer"
                end
            ) as agent_type,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        voucher_entries.related_supplier
                    else
                        voucher_entries.related_customer
                end
            ) as agent,

            voucher_entries.ac_title as product, vouchers.tanker
        ');
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','inner');
        $where = "(voucher_entries.related_supplier != '' || voucher_entries.related_customer != '')";
        $this->db->where($where);
        $this->db->where_in('vouchers.voucher_type',[
            'product_sale',
            'product_sale_with_freight',
            'purchase'
        ]);
        $this->db->where('vouchers.deleted',0);
        $this->db->where('voucher_entries.deleted',0);
        $this->db->order_by('vouchers.voucher_date','asc');
        $this->db->order_by('vouchers.inserted_at','asc');
        $this->db->group_by('voucher_entries.voucher_id, voucher_entries.item_id');
        $result = $this->db->get('voucher')->result();
        var_dump($result);
    }

    public function stock_view()
    {
        $this->db->select('cpcv.product, cpcv.tanker,
            (SUM(s_in) - SUM(s_out)) as quantity,
            cpcv.cost_per_item as price_per_unit, cpcv.voucher_id as purchase_id,
            products.id as product_id, stock_history_view.voucher_entry_id as id,
        ');
        $this->db->join('current_purchase_cost_view as cpcv','cpcv.product = stock_history_view.product and cpcv.tanker = stock_history_view.tanker','left');
        $this->db->join('products','products.name = cpcv.product','left');
        $this->db->group_by('stock_history_view.product, stock_history_view.tanker');
        $result = $this->db->get('stock_history_vie')->result();
        var_dump($result);
    }



    public function save_opening_balance()
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");


        $opening_balances = array(
            array(
                'type'=>'customer',
                'agent' => 'H.M.Hussain',
                'amount' => '1362928',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'M.Aslam.Agency',
                'amount' => '2187146',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Zafar Patwari',
                'amount' => '710400',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Haider f/s',
                'amount' => '666504',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Safdar Lahore',
                'amount' => '823680',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Rana Asif',
                'amount' => '2000000',
                'balance'=>'c',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Saith Riaz',
                'amount' => '1072000',
                'balance'=>'c',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Rehmat f/s',
                'amount' => '1000000',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Sajid Zafarwal',
                'amount' => '2023250',
                'balance'=>'c',
            ),
            array(
                'type'=>'customer',
                'agent' => 'M.Aslam Admore',
                'amount' => '1619000',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Roy M.Aslam Kaleki',
                'amount' => '76500',
                'balance'=>'d',
            ),
            array(
                'type'=>'customer',
                'agent' => 'Qaisar Panwan',
                'amount' => '61000',
                'balance'=>'d',
            ),

            //supplier balances
            array(
                'type'=>'supplier',
                'agent' => 'Irfan Virik SB',
                'amount' => '2078776',
                'balance'=>'c',
            ),
            array(
                'type'=>'supplier',
                'agent' => 'Ch.Mukhtar Patoki',
                'amount' => '440379',
                'balance'=>'d',
            ),


        );

        $this->db->trans_start();
        foreach($opening_balances as $record)
        {
            if($record['type'] == 'customer')
            {
                $this->db->insert('customers', array('name'=>$record['agent']));
            }
            if($record['type'] == 'supplier')
            {
                $this->db->insert('suppliers', array('name'=>$record['agent']));
            }
        }

        foreach($opening_balances as $record)
        {
            if($record['type'] == 'customer')
            {
                $voucher = new App_Voucher();
                $voucher->voucher_date = date("Y-m-d");
                $voucher->summary = "opening balance ".$record['agent'];
                $voucher->voucher_type = 'opening_balance';
                $voucher_entries = array();
                /*---------First ENTRY--------*/
                $voucher_entry_1 = new App_voucher_Entry();
                $voucher_entry_1->ac_title = $record['agent'];
                $voucher_entry_1->ac_sub_title = "opening balance";
                $voucher_entry_1->ac_type = "receivable";
                $voucher_entry_1->related_customer = $record['agent'];
                $voucher_entry_1->related_business = "";
                $voucher_entry_1->amount = $record['amount'];
                $voucher_entry_1->description = "opening balance ".$record['agent'];
                $voucher_entry_1->dr_cr = (($record['balance'] == 'd')?'1':'0');
                array_push($voucher_entries, $voucher_entry_1);
                /*----------------------------------*/
                /*---------Second ENTRY--------*/
                $voucher_entry_2 = new App_voucher_Entry();
                $voucher_entry_2->ac_title = "capital account";
                $voucher_entry_2->ac_sub_title = "opening balance";
                $voucher_entry_2->ac_type = "capital";
                $voucher_entry_2->related_business = $this->admin_model->business_name();
                $voucher_entry_2->related_customer = "";
                $voucher_entry_2->amount = $record['amount'];
                $voucher_entry_2->description = "opening balance ".$record['agent'];
                $voucher_entry_2->dr_cr = (($record['balance'] == 'd')?'0':'1');
                array_push($voucher_entries, $voucher_entry_2);
                /*----------------------------------*/
                $voucher->entries = $voucher_entries;

                $this->accounts_model->insert_voucher($voucher);
            }
            if($record['type'] == 'supplier')
            {
                $voucher = new App_Voucher();
                $voucher->voucher_date = date("Y-m-d");
                $voucher->summary = "opening balance ".$record['agent'];
                $voucher->voucher_type = 'opening_balance';
                $voucher_entries = array();
                /*---------First ENTRY--------*/
                $voucher_entry_1 = new App_voucher_Entry();
                $voucher_entry_1->ac_title = $record['agent'];
                $voucher_entry_1->ac_sub_title = "opening balance";
                $voucher_entry_1->ac_type = "payable";
                $voucher_entry_1->related_supplier = $record['agent'];
                $voucher_entry_1->related_business = "";
                $voucher_entry_1->amount = $record['amount'];
                $voucher_entry_1->description = "opening balance ".$record['agent'];
                $voucher_entry_1->dr_cr = (($record['balance'] == 'd')?'1':'0');
                array_push($voucher_entries, $voucher_entry_1);
                /*----------------------------------*/
                /*---------Second ENTRY--------*/
                $voucher_entry_2 = new App_voucher_Entry();
                $voucher_entry_2->ac_title = "capital account";
                $voucher_entry_2->ac_sub_title = "opening balance";
                $voucher_entry_2->ac_type = "capital";
                $voucher_entry_2->related_business = $this->admin_model->business_name();
                $voucher_entry_2->related_supplier = "";
                $voucher_entry_2->amount = $record['amount'];
                $voucher_entry_2->description = "opening balance ".$record['agent'];
                $voucher_entry_2->dr_cr = (($record['balance'] == 'd')?'0':'1');
                array_push($voucher_entries, $voucher_entry_2);
                /*----------------------------------*/
                $voucher->entries = $voucher_entries;

                $this->accounts_model->insert_voucher($voucher);
            }
        }

        var_dump($this->db->trans_complete());

    }

    public function expense_payments_view()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.voucher_date, vouchers.summary as summary,
            voucher_entries.ac_title as account, voucher_entries.amount,
        ");
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','inner');
        $this->db->where('vouchers.deleted',0);
        $this->db->where('voucher_entries.deleted',0);
        $this->db->where('vouchers.voucher_type','expense payment');
        $this->db->where('voucher_entries.dr_cr','0');
        $result = $this->db->get('voucher')->result();
        var_dump($result);
    }

    public function add_assets()
    {
        echo 'hello';
    }

}
