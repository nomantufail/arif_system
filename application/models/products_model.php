<?php
class Products_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "products";
    }

    public function get(){
        $records = $this->db->get($this->table)->result();
        return $records;
    }
    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);
        
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function count($keys = "") {
        if($keys != "")
        {
            //search queries here
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

    public function insert(){
       $data = array(
            'name'=>$this->input->post('name'),
            'description'=>$this->input->post('description'),
        );

        $this->db->trans_start();

        $this->db->insert($this->table, $data);
        $product_id = $this->db->insert_id();
        $this->stock_model->insert_product($product_id, 0);

        return $this->db->trans_complete();
    }

    public function have_usages($product)
    {
        $this->db->select("vouchers.id as voucher_id");
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active();
        $this->db->where('voucher_entries.ac_title',$product);
        $vouchers = $this->db->get()->num_rows();

        $this->db->select("stock.id as stock_id");
        $this->db->from('stock');
        $this->join_stock_and_products();
        $this->db->where(array(
            'products.name'=>$product,
            'stock.quantity !='=>0,
        ));
        $stock = $this->db->get()->num_rows();

        if($stock != 0 || $vouchers != 0)
        {
            return true;
        }
        return false;
    }

}