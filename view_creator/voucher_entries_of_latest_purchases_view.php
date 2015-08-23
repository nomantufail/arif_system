<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/23/2015
 * Time: 9:47 AM
 */


function voucher_entries_of_latest_purchases_view()
{
    $query = "
                SELECT max(voucher_entry_id) as voucher_entry_id
                FROM stock_history_vie
                where in_out = 'in'
                group by product, tanker
                ";

    $result = $this->db->query($query)->result();
    var_dump($result);
}