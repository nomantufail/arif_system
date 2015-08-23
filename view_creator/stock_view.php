<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/23/2015
 * Time: 10:59 AM
 */

function stock_view()
{
    $this->db->select('cpcv.product, cpcv.tanker,
            (SUM(s_in) - SUM(s_out)) as quantity,
            cpcv.cost_per_item as price_per_unit, cpcv.voucher_id as purchase_id,
            products.id as product_id, stock_history_view.voucher_entry_id as id,
        ');
    $this->db->join('current_purchase_cost_view as cpcv','cpcv.voucher_entry_id = stock_history_view.voucher_entry_id','left');
    $this->db->join('products','products.name = cpcv.product','left');
    $this->db->group_by('stock_history_view.product, stock_history_view.tanker');
    $result = $this->db->get('stock_history_vie')->result();
    var_dump($result);
}