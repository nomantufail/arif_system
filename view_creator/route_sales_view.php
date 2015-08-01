<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/1/2015
 * Time: 10:40 AM
 */

function route_sale_view()
{
    $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as date,
            vouchers.summary, vouchers.tanker,voucher_entries.id as entry_id,
            voucher_entries.amount as freight, voucher_entries.source,
            voucher_entries.destination,
        ");
    $this->db->from('voucher');
    $this->join_vouchers();
    $this->with_credit_entries_only();
    $this->db->where('vouchers.voucher_type','route_sale');
    $this->active_vouchers();
    $result = $this->db->get()->result();
    var_dump($result);
}