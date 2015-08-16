<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/15/2015
 * Time: 9:52 PM
 */
function expense_payments_view()
{
    $this->db->select("
            vouchers.id as voucher_id, vouchers.voucher_date, vouchers.summary as summary,
            voucher_entries.ac_title as account, voucher_entries.amount,
        ");
    $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','inner');
    $this->db->where('vouchers.deleted',0);
    $this->db->where('voucher_entries.deleted',0);
    $this->db->where('vouchers.voucher_type','expense payment');
    $this->db->where('voucher_entries.dr_cr','0');
    $result = $this->db->get('voucher')->result();
    var_dump($result);
}
