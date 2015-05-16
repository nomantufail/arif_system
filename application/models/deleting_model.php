<?php
class Deleting_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
    }

    public function force_delete_where($table, $where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }

}

?>