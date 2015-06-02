<?php

/*
 * --------------------------------------
 * Parent Model For Query Scopes
 * --------------------------------------
 * This model is used for query scopes
 * which scopes are global and can be
 * used in any model..
 * */

class Parent_Model extends CI_Model {

    //protected properties
    protected $table;
    public function __construct(){
        parent::__construct();

    }

    /**
     * Used to fetch only active records
     */
    public function active()
    {
        $this->db->where('deleted',0);
    }

    /**
     * Used to fetch only active voucher_entries
     */
    public function active_voucher_entries()
    {
        $this->db->where('voucher_entries.deleted',0);
    }

    /**
     * Used to fetch only active parent vouchers
     */
    public function active_parent_vouchers()
    {
        $this->db->where('vouchers.deleted',0);
    }

    /**
     * Used to fetch those vouchers which have
     * both entries and parent active.
     */
    public function active_vouchers()
    {
        $this->active_parent_vouchers();
        $this->active_voucher_entries();
    }

    /**
     * Used to fetch only deleted records
     */
    public function deleted()
    {
        $this->db->where('deleted',1);
    }

    /**
     * Used to fetch latest records first
     */
    public function latest($table = null)
    {

        if($table != null)
        {
            $this->db->order_by($table.".id",'desc');
        }else{
            $this->db->order_by('id','desc');
        }
    }

    /**
     * Used to fetch only debit entries
     */
    public function with_debit_entries_only()
    {
        $this->db->where('voucher_entries.dr_cr',1);
    }

    /**
     * Used to fetch only credit etnries
     */
    public function with_credit_entries_only()
    {
        $this->db->where('voucher_entries.dr_cr',0);
    }

    /**
     * Used to fetch only purchase vouchers
     */
    public function purchase_vouchers()
    {
        $this->db->where('vouchers.voucher_type','purchase');
    }

    /**
     * Used to fetch only product sale vouchers
     */
    public function product_sale_vouchers()
    {
        $this->db->where('vouchers.voucher_type','product_sale');
    }
    /**
     * Used to fetch only product_with_freight vouchers
     */
    public function product_with_freight_vouchers()
    {
        $this->db->where('vouchers.voucher_type','product_sale_with_freight');
    }
    /**
     * Used to fetch all types of sale vouchers
     */
    public function all_sale_vouchers()
    {
        $where = "(vouchers.voucher_type = 'product_sale' OR vouchers.voucher_type = 'product_sale_with_freight')";
        $this->db->where($where);
    }

    /**
     * Used to fetch only payment vouchers
     */
    public function payment_vouchers()
    {
        $this->db->where('vouchers.voucher_type','payment');
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function receipt_vouchers()
    {
        $this->db->where('vouchers.voucher_type','receipt');
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function expense_payable_vouchers()
    {
        $this->db->where('vouchers.voucher_type','expense_payable');
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function expense_payment_vouchers()
    {
        $this->db->where('vouchers.voucher_type','expense payment');
    }

    /**
     * Used to fetch only those vouchers which have
     * a bank account as ac_title in voucher_entry
     * Simply it fetch all bank accounts vouchers
     */
    public function bank_account_titles($titles)
    {
        $this->db->where_in('voucher_entries.ac_title',$titles);
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function withdraw_vouchers()
    {
        $this->db->where('vouchers.voucher_type','withdraw');
    }

    public function withdraw_titles($titles)
    {
        $this->db->where_in('voucher_entries.ac_title',$titles);
    }
    /**
     * Used to join vouchers table with voucher_entries table
     */
    public function join_vouchers()
    {
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','left');
    }
    /**
     * Used to join stock table with products table
     */
    public function join_stock_and_products()
    {
        $this->db->join('products','products.id = stock.product_id','left');
    }

    /**
     * Used to select all the sale contents which are needed
     */
    public function select_sale_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as invoice_date, vouchers.summary as invoice_summary,
            vouchers.tanker,
            voucher_entries.related_customer, voucher_entries.ac_title as product_name, voucher_entries.quantity,
            voucher_entries.cost_per_item, voucher_entries.amount,
            voucher_entries.id as entry_id, voucher_entries.item_id,

        ");
    }

    /**
     * Used to select all the sale with freight contents which are needed
     */
    public function select_sale_with_freight_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as invoice_date, vouchers.summary as invoice_summary,
            vouchers.tanker,
            voucher_entries.related_customer, voucher_entries.ac_title as product_name, voucher_entries.quantity,
            voucher_entries.cost_per_item, voucher_entries.amount,
            voucher_entries.id as entry_id,
            voucher_entries.freight as freight_amount,
        ");
    }

    /**
     * Used to select all the sale contents which are needed
     */
    public function select_profit_loss_content()
    {
        $this->db->select('SUM(voucher_entries.cost_per_item * voucher_entries.quantity) as total_sale_price,
                SUM(voucher_entries.purchase_price_per_item_for_sale * voucher_entries.quantity) as total_purchase_price,
        ');
    }

    /**
     * Used to select all the purchases contents which are needed
     */
    public function select_purchases_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as invoice_date, vouchers.summary as invoice_summary,
            vouchers.tanker,
            voucher_entries.related_supplier, voucher_entries.ac_title as product_name, voucher_entries.quantity,
            voucher_entries.cost_per_item, voucher_entries.amount,
            voucher_entries.id as entry_id, voucher_entries.item_id,

        ");
    }

    /**
     * Used to select all the payment(paid) contents which are needed
     */
    public function select_payment_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            vouchers.tanker,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
        ");
    }

    /**
     * Used to select all the receipt contents which are needed
     */
    public function select_receipt_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            vouchers.tanker,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
        ");
    }

    /**
     * Used to select all the expense contents which are needed
     */
    public function select_expense_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as expense_date, vouchers.summary as invoice_summary,
            voucher_entries.related_tanker as tanker, voucher_entries.ac_title as expense_title,
            voucher_entries.amount,
        ");
    }

    /**
     * Used to select all the withdraw accounts contents which are needed
     */
    public function select_withdraw_accounts_content()
    {
        $this->db->select('withdraw_accounts.title, withdraw_accounts.description, withdraw_accounts.id');
    }

    /**
     * Used to select all the expense payment contents which are needed
     */
    public function select_expense_payment_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.voucher_date as voucher_date, vouchers.summary as summary,
            voucher_entries.ac_title as bank_ac, voucher_entries.amount,
        ");
    }

    /**
     * Used to fetch only today vouchers
     */
    public function today_vouchers()
    {
        $this->db->where(array(
            'vouchers.voucher_date'=>date('Y-m-d'),
        ));
    }

    /**
    * used to select id column in vouchers table.
    **/
    public function select_voucher_ids()
    {
        $this->db->select("vouchers.id as voucher_id");
    }

    /**
     * used to select vouchers in which account type is payable
     **/
    public function payables()
    {
        $this->db->where('ac_type', 'payable');
    }
    /**
     * used to select vouchers in which account type is Receivable
     **/
    public function receivables()
    {
        $this->db->where('ac_type', 'receivable');
    }
    /**
     * used to select vouchers in which account type is asset
     **/
    public function assets()
    {
        $this->db->where('ac_type', 'asset');
    }
    /**
     * used to select vouchers in which account type is revenue
     **/
    public function revenue()
    {
        $this->db->where('ac_type', 'revenue');
    }
    /**
     * used to select vouchers in which account type is bank
     **/
    public function bank_entries()
    {
        $this->db->where('ac_type', 'bank');
    }

    public function get_customer_vouchers()
    {
        $this->db->where('voucher_entries.related_customer !=','');
    }
    public function get_supplier_vouchers()
    {
        $this->db->where('voucher_entries.related_supplier !=','');
    }
    public function get_tanker_vouchers()
    {
        $this->db->where('voucher_entries.related_tanker !=','');
    }
    public function where_customer($customerName)
    {
        $this->db->where('voucher_entries.related_customer',$customerName);
    }
    public function where_supplier($customerName)
    {
        $this->db->where('voucher_entries.related_supplier',$customerName);
    }
    public function where_tanker($tankerName)
    {
        $this->db->where('voucher_entries.related_tanker',$tankerName);
    }

    public function where_ac_title($title)
    {
        $this->db->where('voucher_entries.ac_title', $title);
    }
    public function where_ac_titles($titles)
    {
        $this->db->where_in('voucher_entries.ac_title', $titles);
    }

    public function where_ac_type($type)
    {
        $this->db->where('voucher_entries.ac_type', $type);
    }

    public function select_whole_voucher_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            vouchers.tanker,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id, voucher_entries.ac_type,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
            voucher_entries.related_tanker,
        ");
    }

    public function fetch_opening_balance($rows)
    {
        $total_debit = 0;
        $total_credit = 0;
        if($rows != null)
        {
            foreach($rows as $row)
            {
                if($row->dr_cr == 0)
                {
                    $total_credit += $row->total_amount;
                }
                if($row->dr_cr == 1)
                {
                    $total_debit += $row->total_amount;
                }
            }
        }
        return round($total_debit - $total_credit, 3);
    }

    public function voucher_duration($from, $to)
    {
        $this->db->where(array(
            'vouchers.voucher_date >='=>$from,
            'vouchers.voucher_date <='=>$to,
        ));
    }

    /**
     * Below functions are used to search by agents
     **/
    public function where_related_suppliers($suppliers)
    {
        $this->db->where_in('voucher_entries.related_supplier',$suppliers);
    }
    public function where_related_customers($customers)
    {
        $this->db->where_in('voucher_entries.related_customer',$customers);
    }
    public function where_related_tankers($tankers)
    {
        $this->db->where_in('voucher_entries.related_tanker',$tankers);
    }
    public function where_related_businesses($businesses)
    {
        $this->db->where_in('voucher_entries.related_business',$businesses);
    }
    public function where_related_other_agents($other_agents)
    {
        $this->db->where_in('voucher_entries.related_other_agent',$other_agents);
    }


    public function where_related_supplier($supplier)
    {
        $this->db->where('voucher_entries.related_supplier',$supplier);
    }
    public function where_related_customer($customer)
    {
        $this->db->where('voucher_entries.related_customer',$customer);
    }
    public function where_related_tanker($tanker)
    {
        $this->db->where('voucher_entries.related_tanker',$tanker);
    }
    public function where_related_business($business)
    {
        $this->db->where('voucher_entries.related_business',$business);
    }
    public function where_related_other_agent($other_agent)
    {
        $this->db->where('voucher_entries.related_other_agent',$other_agent);
    }
}

?>