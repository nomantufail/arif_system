<?php
class Expense_Titles_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "expense_titles";
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
            'title'=>$this->input->post('title'),
        );

        $this->db->trans_start();

        $this->db->insert($this->table, $data);
        $title_id = $this->db->insert_id();
        return $this->db->trans_complete();
    }

    public function get_where($where)
    {
        $this->db->select('expense_titles.id, expense_titles.title');
        $result = $this->db->get_where($this->table,$where)->result();
        $title = ($result != null)?$result[0]:null;
        return $title;
    }

    public function have_usages($title)
    {
        $this->db->select("vouchers.id as voucher_id");
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active_vouchers();
        $this->db->where('voucher_entries.ac_title',$title);
        $vouchers = $this->db->get()->num_rows();

        if($vouchers != 0)
        {
            return true;
        }
        return false;
    }

}