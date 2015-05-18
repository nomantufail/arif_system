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

    public function delete_product($name)
    {
        $product = $this->products_model->get_where(array('name'=>$name));
        $this->db->trans_start();
        if($product != null)
        {
            $this->deleting_model->force_delete_where('products', array('id'=>$product->id));
            $this->deleting_model->force_delete_where('stock',array('product_id'=>$product->id));
        }
        return $this->db->trans_complete();

    }
    public function delete_tanker($number)
    {
        $this->db->trans_start();
        $this->deleting_model->force_delete_where('tankers', array('number'=>$number));
        $this->deleting_model->force_delete_where('stock',array('tanker'=>$number));
        return $this->db->trans_complete();

    }
}

?>