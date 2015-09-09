<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 9/9/2015
 * Time: 6:07 AM
 */

function cash_ledgers()
{
    $this->db->select('
                ve.voucher_id as voucher_id, v.voucher_date as voucher_date, v.summary as summary,
                (
                    case
                        when ve.dr_cr = 0 then
                            ve.amount
                        else
                            0
                    end
                ) as credit_amount,
                (
                    case
                        when ve.dr_cr = 1 then
                            ve.amount
                        else
                            0
                    end
                ) as debit_amount,
            ');
    $this->db->join('vouchers as v','ve.voucher_id = v.id','inner');
    $this->db->where('ve.ac_title','cash');
    $this->db->where('v.deleted',0);
    $this->db->where('ve.deleted',0);
    $result = $this->db->get('voucher_entrie as ve')->result();
}