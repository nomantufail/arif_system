<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/8/2015
 * Time: 10:23 PM
 */

function payments_view()
{
    $this->db->select("
            vouchers.id as voucher_id, vouchers.voucher_date, vouchers.summary,
            (
                case
                    when vouchers.bank_ac = '' then
                        'cash'
                    else
                        vouchers.bank_ac
                end
            ) as account,

            (
                case
                    when voucher_entries.related_supplier = '' then
                        voucher_entries.related_customer
                    else
                        voucher_entries.related_supplier
                end
            ) as agent,

            (
                case
                    when voucher_entries.related_supplier = '' then
                        'customer'
                    else
                        'supplier'
                end
            ) as agent_type,
            voucher_entries.id as entry_id,voucher_entries.amount,
        ");

    $this->db->from('voucher');
    $this->db->join('voucher_entries', 'voucher_entries.voucher_id = vouchers.id','inner');
    $this->db->where('vouchers.voucher_type','payment');
    $this->db->where('voucher_entries.dr_cr','1');
    $this->db->where('vouchers.deleted',0);
    $result = $this->db->get()->result();

    var_dump($result); die();
}