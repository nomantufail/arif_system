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
     * Used to fetch only deleted records
     */
    public function deleted()
    {
        $this->db->where('deleted',1);
    }

}

?>