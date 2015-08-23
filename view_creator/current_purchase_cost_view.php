<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/23/2015
 * Time: 10:40 AM
 */

function current_purchase_cost_view()
{
    $this->db->select('product, tanker, cost_per_item, voucher_id, stock_history_view.voucher_entry_id');
    $this->db->join('voucher_entries_of_latest_purchases_view','voucher_entries_of_latest_purchases_view.voucher_entry_id = stock_history_view.voucher_entry_id','inner');
    $this->db->where('stock_history_view.in_out','in');
    $result = $this->db->get('stock_history_vie')->result();
    var_dump($result);
}