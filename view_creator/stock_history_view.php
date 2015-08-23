<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 8/23/2015
 * Time: 7:17 AM
 */

function stock_history()
{
    $this->db->select('
            vouchers.id as voucher_id, voucher_entries.id as voucher_entry_id,
            vouchers.voucher_date, vouchers.inserted_at, voucher_entries.cost_per_item,
            (
                case
                    when vouchers.voucher_type = "purchase" then
                        "in"
                    else
                        "out"
                end
            ) as in_out,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        voucher_entries.quantity
                    else
                        0
                end
            ) as s_in,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        0
                    else
                        voucher_entries.quantity
                end
            ) as s_out,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        "supplier"
                    else
                        "customer"
                end
            ) as agent_type,

            (
                case
                    when vouchers.voucher_type = "purchase" then
                        voucher_entries.related_supplier
                    else
                        voucher_entries.related_customer
                end
            ) as agent,

            voucher_entries.ac_title as product, vouchers.tanker
        ');
    $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','inner');
    $where = "(voucher_entries.related_supplier != '' || voucher_entries.related_customer != '')";
    $this->db->where($where);
    $this->db->where_in('vouchers.voucher_type',[
        'product_sale',
        'product_sale_with_freight',
        'purchase'
    ]);
    $this->db->where('vouchers.deleted',0);
    $this->db->order_by('vouchers.voucher_date','asc');
    $this->db->order_by('vouchers.inserted_at','asc');
    $this->db->group_by('voucher_entries.voucher_id, voucher_entries.item_id');
    $result = $this->db->get('voucher')->result();
    var_dump($result);
}