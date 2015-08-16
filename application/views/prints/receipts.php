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

<h3 style="text-align: center;">Receipts</h3>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th>Invoice#</th>
        <th>Date</th>
        <th>Agent</th>
        <th>Account</th>
        <th>Amount</th>
        <th>Summary</th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_product_quantity = 0;
    $grand_total_amount = 0;
    ?>
    <?php $parent_count = 0; ?>
    <?php  foreach($receipt_history as $record): ?>

        <tr style="">

            <td>
                <?= $record->voucher_id?>
            </td>

            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                echo $record->agent_type.": ".$record->agent;
                ?>
            </td>
            <td>
                <?= $record->account; ?>
            </td>
            <td>
                <?php
                $grand_total_amount += $record->amount;
                $amount = rupee_format($record->amount);
                echo $amount;
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
        <th class="total_amount"><?= rupee_format($grand_total_amount) ?></th>
        <th></th>
    </tr>
    </tfoot>
</table>