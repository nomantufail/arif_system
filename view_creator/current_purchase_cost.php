<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/23/2015
 * Time: 8:31 AM
 */

function current_purchase_cost_view()
{
    $query = "SELECT product, tanker, cost_per_item as current_purchase_cost
                FROM stock_history_view
                where in_out = 'in'
                ORDER BY inserted_at desc, voucher_id desc";

    $result = $this->db->query($query)->result();
    var_dump($result);
    die();
    $query =
        "
                SELECT *
                FROM(
                SELECT product, tanker, cost_per_item as current_purchase_cost
                FROM stock_history_vie
                where in_out = 'in'
                ORDER BY inserted_at desc, voucher_id desc
                ) as inv
                GROUP BY product,
                tanker
            ";
    $result = $this->db->query($query)->result();
    var_dump($result);
}