<?php
class Accounts_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();

        $this->table = 'vouchers';
    }

    public function customers_balance()
    {
        $this->db->select('voucher_entries.related_customer as customerName,
                    SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr,
        ');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->get_customer_vouchers();
        $this->db->group_by('voucher_entries.related_customer, voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $grouped = Arrays::groupBy($result, Functions::extractField('customerName'));
        $balances = array();
        foreach($grouped as $group)
        {
            $total_debit = 0;
            $total_credit = 0;
            $customer_name = '';
            foreach($group as $record)
            {
                $customer_name = $record->customerName;
                if($record->dr_cr == 1)
                {
                    $total_debit += $record->total_amount;
                }else if($record->dr_cr == 0){
                    $total_credit += $record->total_amount;
                }
            }
            $balance = round($total_debit - $total_credit, 3);

            $balances[$customer_name] = $balance;
        }
        return $balances;

    }

    public function suppliers_balance()
    {
        $this->db->select('voucher_entries.related_supplier as supplierName,
                    SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr,
        ');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->get_supplier_vouchers();
        $this->db->group_by('voucher_entries.related_supplier, voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $grouped = Arrays::groupBy($result, Functions::extractField('supplierName'));
        $balances = array();
        foreach($grouped as $group)
        {
            $total_debit = 0;
            $total_credit = 0;
            $supplier_name = '';
            foreach($group as $record)
            {
                $supplier_name = $record->supplierName;
                if($record->dr_cr == 1)
                {
                    $total_debit += $record->total_amount;
                }else if($record->dr_cr == 0){
                    $total_credit += $record->total_amount;
                }
            }
            $balance = round($total_debit - $total_credit, 3);

            $balances[$supplier_name] = $balance;
        }
        return $balances;

    }


    public function banks_balance()
    {
        $this->db->select('voucher_entries.ac_title as bank_title,
                    SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr,
        ');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->bank_entries();
        $this->db->group_by('voucher_entries.ac_title, voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $grouped = Arrays::groupBy($result, Functions::extractField('bank_title'));
        $balances = array();
        foreach($grouped as $group)
        {
            $total_debit = 0;
            $total_credit = 0;
            $bank_name = '';
            foreach($group as $record)
            {
                $bank_name = $record->bank_title;
                if($record->dr_cr == 1)
                {
                    $total_debit += $record->total_amount;
                }else if($record->dr_cr == 0){
                    $total_credit += $record->total_amount;
                }
            }
            $balance = round($total_debit - $total_credit, 3);

            $balances[$bank_name] = $balance;
        }
        return $balances;

    }
    public function withdraw_accounts_balance()
    {
        $this->db->select('voucher_entries.ac_title as withdraw_account,
                    SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr,
        ');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->withdraw_vouchers();
        $this->with_debit_entries_only();
        $this->db->group_by('voucher_entries.ac_title, voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $grouped = Arrays::groupBy($result, Functions::extractField('withdraw_account'));
        $balances = array();
        foreach($grouped as $group)
        {
            $total_debit = 0;
            $total_credit = 0;
            $withdraw_account = '';
            foreach($group as $record)
            {
                $withdraw_account = $record->withdraw_account;
                if($record->dr_cr == 1)
                {
                    $total_debit += $record->total_amount;
                }else if($record->dr_cr == 0){
                    $total_credit += $record->total_amount;
                }
            }
            $balance = round($total_debit - $total_credit, 3);

            $balances[$withdraw_account] = $balance;
        }
        return $balances;

    }

    /**
    * Ledgers Area
    **/
    public function opening_balance_for_customer_ledger($keys)
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.voucher_date <',$keys['from']);
        $this->get_customer_vouchers();
        $this->where_customer($keys['customer']);
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $opening_balance = $this->fetch_opening_balance($result);
        return $opening_balance;
        return $result;
    }
    public function customer_ledger($keys)
    {
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($keys['from'], $keys['to']);
        $this->get_customer_vouchers();
        $this->where_customer($keys['customer']);
        $result = $this->db->get()->result();
        return $result;
    }

    public function opening_balance_for_supplier_ledger($keys)
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('vouchers.voucher_date <',$keys['from']);
        $this->get_supplier_vouchers();
        $this->where_supplier($keys['supplier']);
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $opening_balance = $this->fetch_opening_balance($result);
        return $opening_balance;
        return $result;
    }
    public function supplier_ledger($keys)
    {
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($keys['from'], $keys['to']);
        $this->get_supplier_vouchers();
        $this->where_supplier($keys['supplier']);
        $result = $this->db->get()->result();
        return $result;
    }
    /*********************************/
    public function bank_accounts_status()
    {
        $this->db->select("voucher_entries.ac_title, voucher_entries.ac_sub_title,
                  voucher_entries.dr_cr, SUM(voucher_entries.amount) as total_amount,
                  ");
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->bank_entries();
        $this->db->group_by('voucher_entries.ac_title, voucher_entries.ac_sub_title,
                voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $bank_accounts_status_temp = array();

        if(sizeof($result) > 0)
        {
            foreach($result as $record)
            {
                $found = 0;

                if(sizeof($bank_accounts_status_temp) >0)
                {
                    foreach($bank_accounts_status_temp as $account)
                    {

                        if($account['title'] == $record->ac_title && $account['sub_title'] == $record->ac_sub_title){

                            $found = 1;
                            /*if($record->dr_cr == 1)
                            {
                                $account['debit'] = $record->total_amount;

                            }
                            else if($record->dr_cr == 0)
                            {
                                $account['credit'] = $record->total_amount;
                            }
                            array_push($bank_accounts_status, $account);*/
                        }

                    }
                }

                if($found == 0)
                {
                    $bank_account = array(
                        'title'=>$record->ac_title,
                        'sub_title'=>$record->ac_sub_title,
                        'debit'=>0,
                        'credit'=>0,
                    );
                    array_push($bank_accounts_status_temp, $bank_account);
                }

            }
            foreach($result as $record)
            {
                foreach($bank_accounts_status_temp as &$bank_account)
                {
                    if($bank_account['title'] == $record->ac_title && $bank_account['sub_title'] == $record->ac_sub_title){
                        if($record->dr_cr == 1)
                        {
                            $bank_account['debit'] = $record->total_amount;
                        }
                        if($record->dr_cr == 0)
                        {
                            $bank_account['credit'] = $record->total_amount;
                        }
                    }
                }
            }


        }

         return $bank_accounts_status_temp;
    }
    public function insert_voucher($voucher)
    {
        $this->db->trans_begin();

        $voucher_data = array(
            'voucher_date'=>$voucher->voucher_date,
            'summary'=>$voucher->summary,
            'tanker'=>$voucher->tanker,
            'product_sale_id'=>$voucher->product_sale_id,
            'product_for_freight_voucher'=>$voucher->product_for_freight_voucher,
            'product_number_for_freight_voucher'=>$voucher->product_number_for_freight_voucher,
            'bank_ac' => $voucher->bank_ac,
            'voucher_type'=>$voucher->voucher_type,
        );
        $this->db->insert('vouchers',$voucher_data);
        $voucher_id = $this->db->insert_id();

        $voucher_entries = array();
        foreach($voucher->entries as $entry)
        {
            $voucher_entry = array(
                'voucher_id'=>$voucher_id,
                'item_id'=>$entry->item_id,
                'ac_title'=>$entry->ac_title,
                'ac_sub_title'=>$entry->ac_sub_title,
                'ac_type'=>$entry->ac_type,
                'related_customer'=>$entry->related_customer,
                'related_business'=>$entry->related_business,
                'related_other_agent'=>$entry->related_other_agent,
                'related_supplier'=>$entry->related_supplier,
                'related_tanker'=>$entry->related_tanker,
                'quantity'=>$entry->quantity,
                'cost_per_item'=>$entry->cost_per_item,
                'purchase_price_per_item_for_sale'=>$entry->purchase_price_per_item_for_sale,
                'amount'=>$entry->amount,
                'freight'=>$entry->freight,
                'source'=>$entry->source,
                'destination'=>$entry->destination,
                'dr_cr'=>$entry->dr_cr,
                'description'=>$entry->description,
            );
            array_push($voucher_entries, $voucher_entry);
        }

        /**
         * Checking voucher entries are validated or not!
         **/
        if($this->db->trans_status() == false
            || sizeof($voucher_entries)%2 != 0
            || sizeof($voucher_entries) == 0
            || $voucher->balance() != 0)
        {
            $this->db->trans_rollback();
            return false;
        }
        /*----------Check Complete--------------*/

        /*--------Inserting The Voucher Entries-----------*/
        $this->db->insert_batch('voucher_entries',$voucher_entries);
        /*------------------------------------------------*/

        if($this->db->trans_status() == false)
        {
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $voucher_id;
        }

        return false;
    }

    public function insert_voucher_entries($voucher_entries)
    {
        $insertable_entries = array();
        foreach($voucher_entries as $entry)
        {
            $voucher_entry = array(
                'voucher_id'=>$entry->voucher_id,
                'item_id'=>$entry->item_id,
                'ac_title'=>$entry->ac_title,
                'ac_sub_title'=>$entry->ac_sub_title,
                'ac_type'=>$entry->ac_type,
                'related_customer'=>$entry->related_customer,
                'related_business'=>$entry->related_business,
                'related_other_agent'=>$entry->related_other_agent,
                'related_supplier'=>$entry->related_supplier,
                'related_tanker'=>$entry->related_tanker,
                'quantity'=>$entry->quantity,
                'cost_per_item'=>$entry->cost_per_item,
                'purchase_price_per_item_for_sale'=>$entry->purchase_price_per_item_for_sale,
                'amount'=>$entry->amount,
                'freight'=>$entry->freight,
                'dr_cr'=>$entry->dr_cr,
                'description'=>$entry->description,
            );
            array_push($insertable_entries, $voucher_entry);
        }

        $this->db->insert_batch('voucher_entries',$insertable_entries);
    }
    public function update_voucher($voucher)
    {
        $this->db->trans_begin();

        $voucher_data = array(
            'voucher_date'=>$voucher->voucher_date,
            'summary'=>$voucher->summary,
            'tanker'=>$voucher->tanker,
            'product_sale_id'=>$voucher->product_sale_id,
            'product_for_freight_voucher'=>$voucher->product_for_freight_voucher,
            'voucher_type'=>$voucher->voucher_type,
        );
        $this->db->where('vouchers.id',$voucher->id);
        $this->db->update('vouchers',$voucher_data);
        $voucher_id = $voucher->id;

        $voucher_entries = array();
        foreach($voucher->entries as $entry)
        {
            $voucher_entry = array(
                'voucher_id'=>$voucher_id,
                'ac_title'=>$entry->ac_title,
                'ac_sub_title'=>$entry->ac_sub_title,
                'ac_type'=>$entry->ac_type,
                'related_customer'=>$entry->related_customer,
                'related_business'=>$entry->related_business,
                'related_other_agent'=>$entry->related_other_agent,
                'related_supplier'=>$entry->related_supplier,
                'related_tanker'=>$entry->related_tanker,
                'quantity'=>$entry->quantity,
                'cost_per_item'=>$entry->cost_per_item,
                'purchase_price_per_item_for_sale'=>$entry->purchase_price_per_item_for_sale,
                'amount'=>$entry->amount,
                'freight'=>$entry->freight,
                'dr_cr'=>$entry->dr_cr,
                'description'=>$entry->description,
            );
            array_push($voucher_entries, $voucher_entry);
        }

        /**
         * Checking voucher entries are validated or not!
         **/
        if($this->db->trans_status() == false
            || sizeof($voucher_entries)%2 != 0
            || sizeof($voucher_entries) == 0
            || $voucher->balance() != 0)
        {
            $this->db->trans_rollback();
            return false;
        }
        /*----------Check Complete--------------*/

        /*--------Updating The Voucher Entries-----------*/
        $this->db->update_batch('voucher_entries',$voucher_entries,'id');
        /*------------------------------------------------*/

        if($this->db->trans_status() == false)
        {
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $voucher_id;
        }

        return false;
    }

    public function make_vouchers_from_raw($raw_entries)
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");
        include_once(APPPATH."models/helperClasses/Supplier.php");

        $final_voucher_array = array();

        $previous_voucher_id = -1;
        $previous_entry_id = -1;

        $temp_voucher = new App_Voucher();
        $temp_voucher_entry = new App_voucher_Entry($temp_voucher);

        $count = 0;
        foreach($raw_entries as $record){
            $count++;

            //setting the parent details
            if($record->voucher_id != $previous_voucher_id)
            {
                $previous_voucher_id = $record->voucher_id;

                $temp_voucher = new App_voucher();

                //setting data in the parent object
                $temp_voucher->id = $record->voucher_id;
                $temp_voucher->voucher_date = $record->voucher_date;
                $temp_voucher->summary = $record->summary;

            }/////////////////////////////////////////////////

            /////////////////////////////////////////////////
            if($record->entry_id != $previous_entry_id)
            {
                $previous_entry_id = $record->entry_id;

                $temp_voucher_entry = new App_voucher_Entry($temp_voucher);

                //setting data in the Trip_Product_Data object
                $temp_voucher_entry->id = $record->entry_id;
                $temp_voucher_entry->ac_title = $record->ac_title;
                $temp_voucher_entry->ac_sub_title = $record->ac_sub_title;
                $temp_voucher_entry->related_supplier = $record->related_supplier;
                $temp_voucher_entry->related_customer = $record->related_customer;
                $temp_voucher_entry->related_business = $record->related_business;
                $temp_voucher_entry->related_other_agent = $record->related_other_agent;
                $temp_voucher_entry->amount = $record->amount;
                $temp_voucher_entry->dr_cr = $record->dr_cr;
            }/////////////////////////////////////////////////

            //pushing particals
            if($count != sizeof($raw_entries)){
                if($raw_entries[$count]->entry_id != $record->entry_id){
                    array_push($temp_voucher->entries, $temp_voucher_entry);
                }
                if($raw_entries[$count]->voucher_id != $record->voucher_id){
                    array_push($final_voucher_array, $temp_voucher);
                }
            }else{
                array_push($temp_voucher->entries, $temp_voucher_entry);
                array_push($final_voucher_array, $temp_voucher);
            }
        }
        return $final_voucher_array;
    }

    public function account_titles($for = '')
    {
        $this->db->select('voucher_entries.ac_title');
        $this->join_vouchers();
        $this->active_vouchers();
        switch($for)
        {
            case "customers":
                $this->get_customer_vouchers();
                break;
            case "suppliers":
                $this->get_supplier_vouchers();
                break;
            case "tankers":
                $this->get_tanker_vouchers();
                break;
        }
        $this->db->distinct();
        $result = $this->db->get($this->table)->result();
        return $result;
    }

    public function account_types()
    {
        $this->db->select('voucher_entries.ac_type');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->distinct();
        $result = $this->db->get($this->table)->result();
        return $result;
    }

    public function profit_loss($from, $to)
    {
        $profit_loss_data = array(
            'total_sale_price'=>0,
            'total_purchase_price'=>0,
            'total_expense'=>0,
        );

        /**
         * Fetching total sale price and purchase price
         */
        $this->select_profit_loss_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active_vouchers();
        $this->voucher_duration($from, $to);
        $this->all_sale_vouchers();
        $this->with_debit_entries_only();
        $this->with_debit_entries_only();
        $result = $this->db->get()->result();
        if(sizeof($result) > 0)
        {
            $result = $result[0];
        }else{
            $result = null;
        }

        if($result != null)
        {
            $profit_loss_data['total_sale_price'] = ($result->total_sale_price == null)?0: round(doubleval($result->total_sale_price), 3);
            $profit_loss_data['total_purchase_price'] = ($result->total_purchase_price == null)?0: round(doubleval($result->total_purchase_price), 3);
        }

        /**
         * Fetching total expenses
         */
        $total_expense = $this->expenses_model->total_expense($from, $to);
        $profit_loss_data['total_expense'] = $total_expense;

        return $profit_loss_data;
    }

    public function next_item_id($voucher_id)
    {
        $this->db->select('(MAX(voucher_entries.item_id)+1)as next_item_id');
        $this->db->where('voucher_entries.voucher_id',$voucher_id);
        $result = $this->db->get('voucher_entries')->result();
        $next_item_id = 1;
        if(sizeof($result) > 0)
        {
            $next_item_id = $result[0]->next_item_id;
        }
        return $next_item_id;
    }

    public function item_ids($id)
    {
        $this->db->select('voucher_entries.item_id');
        $this->db->distinct();
        $this->db->where('voucher_entries.voucher_id',$id);
        $result = $this->db->get('voucher_entries')->result();
        return property_to_array('item_id',$result);
    }

    public function voucher_active($id)
    {
        $this->db->select('COUNT(vouchers.id) as num_of_vouchers');
        $this->active_parent_vouchers();
        $this->db->where('vouchers.id',$id);
        $result = $this->db->get('vouchers')->result();

        if($result[0]->num_of_vouchers > 0)
        {
            return true;
        }
        return false;
    }

    public function voucher_id($where)
    {
        $this->db->select('vouchers.id');
        $this->db->distinct();
        $this->join_vouchers();
        $this->db->where($where);
        $result = $this->db->get('vouchers')->result();
        if(sizeof($result)> 0)
        {
            $record = $result[0];
            return $record->id;
        }
        return 0;
    }

    public function cash_balance()
    {
        $this->db->select('SUM(amount) as amount, dr_cr');
        $this->db->from('vouchers');
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','inner');
        $this->db->where('ac_title','cash');

        $this->db->where('vouchers.deleted',0);
        $this->db->group_by('dr_cr');
        $result = $this->db->get()->result();

        $total_debit = 0;
        $total_credit = 0;
        if(sizeof($result) > 0)
        {
            foreach($result as $record)
            {
                if($record->dr_cr == '0')
                    $total_credit = $record->amount;
                else if($record->dr_cr == '1')
                    $total_debit = $record->amount;
            }
        }

        return round($total_debit - $total_credit, 2);
    }

}


?>