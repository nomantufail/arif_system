<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 6/8/15
 * Time: 9:16 AM
 */
?>
<?php
 include_once(APPPATH."views/prints/components/libs.php");
?>

<h3 style="text-align: center;">Payments</h3>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th>Invoice#</th>
        <th>Date</th>
        <th>Supplier</th>
        <th>Bank</th>
        <th>Amount</th>
        <th>Summary</th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_product_quantity = 0;
    $grand_total_cost = 0;
    ?>
    <?php $parent_count = 0; ?>
    <?php  foreach($payment_history as $record): ?>

        <tr style="">

            <td>
                <?= $record->voucher_id ?>
            </td>

            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                $supplier = $record->related_supplier;
                echo $supplier;
                ?>
            </td>
            <td>
                <?php
                $bank = $record->bank_ac;
                echo $bank;
                ?>
            </td>
            <td>
                <?php
                $amount = $record->amount;
                $grand_total_cost += $amount;
                echo rupee_format($amount);
                ?>
            </td>
            <td>
                <?php
                echo $record->summary;
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">
        <th style="text-align: right;" colspan="4">Totals</th>
        <th class="total_amount"><?= rupee_format($grand_total_cost) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>