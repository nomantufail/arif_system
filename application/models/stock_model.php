<?php
class Stock_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "stock";
    }

    public function get(){
        $this->db->select("stock.id as stock_id, stock.product_id, products.name as product_name,
        stock.quantity,
        ");
        $this->db->from('stock');
        $this->db->join('products','products.id = stock.product_id','left');
        $records = $this->db->get()->result();
        //var_dump($records);die();
        return $records;
    }
    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);
        if($keys['agent_id'] != '')
        {
            $this->db->where('id',$keys['agent_id']);
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function count($keys = "") {
        if($keys != "")
        {
            if($keys['agent_id'] != '')
            {
                $this->db->where('id',$keys['agent_id']);
            }
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function find($id){
        $result = $this->db->get_where($this->table, array('id'=>$id))->result();
        if($result){
            $record = $result[0];
            return $record;
        }else{
            return null;
        }
    }
    public function increase($stock_entries)
    {
        $product_names = array();
        foreach($stock_entries as $entry)
        {
            array_push($product_names, $entry['product_name']);
        }

        if(sizeof($product_names) > 0)
        {
            $this->db->trans_start();

            $this->db->select('products.id as product_id, products.name as product_name, stock.quantity');
            $this->db->from($this->table);
            $this->db->join('products','products.id = stock.product_id', 'left');
            $this->db->where_in("products.name", $product_names);
            $result = $this->db->get()->result();
            $modified_stock_entries = array();
            foreach($result as $record)
            {
                foreach($stock_entries as $entry)
                {
                    if($entry['product_name'] == $record->product_name)
                    {
                        $modified_stock_entry = array(
                            'product_id' => $record->product_id,
                            'quantity' => $record->quantity + $entry['quantity'],
                            'updated_at' => date('Y-m-d h:i:s', time()),
                        );
                        array_push($modified_stock_entries, $modified_stock_entry);
                    }
                }
            }
            if(sizeof($modified_stock_entries) > 0)
            {
                $this->db->update_batch($this->table, $modified_stock_entries, 'product_id');
            }

            return $this->db->trans_complete();
        }
        return false;


    }
    public function decrease($stock_entries)
    {
        $product_names = array();
        foreach($stock_entries as $entry)
        {
            array_push($product_names, $entry['product_name']);
        }

        if(sizeof($product_names) > 0)
        {
            $this->db->trans_start();

            $this->db->select('products.id as product_id, products.name as product_name, stock.quantity');
            $this->db->from($this->table);
            $this->db->join('products','products.id = stock.product_id', 'left');
            $this->db->where_in("products.name", $product_names);
            $result = $this->db->get()->result();
            $modified_stock_entries = array();
            foreach($result as $record)
            {
                foreach($stock_entries as $entry)
                {

                    if($entry['product_name'] == $record->product_name)
                    {
                        $modified_stock_entry = array(
                            'product_id' => $record->product_id,
                            'quantity' => $record->quantity - $entry['quantity'],
                            'updated_at' => date('Y-m-d h:i:s', time()),
                        );
                        array_push($modified_stock_entries, $modified_stock_entry);
                    }
                }
            }
            if(sizeof($modified_stock_entries) > 0)
            {
                $this->db->update_batch($this->table, $modified_stock_entries, 'product_id');
            }

            return $this->db->trans_complete();
        }
        return false;
    }



    public function insert($product_id, $qty){
       $data = array(
           'product_id'=>$product_id,
           'quantity'=>$qty,
        );
        $result = $this->db->insert($this->table, $data);
        if($result == true){
            return true;
        }else{
            return false;
        }
    }

}