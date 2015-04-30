<?php
class Tankers_model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        $this->table = "tankers";
    }

    public function get($orderby = 'asc'){
        $this->db->order_by("name", $orderby);
        $this->active();
        $tankers = $this->db->get($this->table)->result();
        return $tankers;
    }
    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);
        
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    public function count() {
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function find($id){
        $this->db->where(array(
            'id'=>$id,
            'deleted'=>0,
        ));
        $result = $this->db->get($this->table)->result();
        if($result){
            $tanker = $result[0];
            return $tanker;
        }else{
            return null;
        }
    }

    public function find_where($where)
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->where('deleted',0);
        $result = $this->db->get($this->table)->result();
        return $result;
    }

    public function insert(){
       $data = array(
            'name'=>$this->input->post('name'),
            'capacity'=>$this->input->post('capacity'),
           'number'=>$this->input->post('number'),
           'chambers'=>$this->input->post('chambers'),
       );
        $result = $this->db->insert('tankers', $data);
        if($result == true){
            return true;
        }else{
            return false;
        }
    }

}