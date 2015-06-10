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
<h3 style="text-align: center;">Expense Payments</h3>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Invoice#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Bank</th>
        <th class="column_heading">Amount</th>
        <th class="column_heading">Summary</th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_cost = 0;
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
                $bank = $record->bank_ac;
                echo $bank;
                ?>
            </td>
            <td>
                <?php
                $total_cost += $record->amount;
                echo rupee_format($record->amount);
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
        <th style="text-align: right;" colspan="3">Totals</th>
        <th class="total_amount"><?= rupee_format($total_cost) ?></th>
        <th colspan="1"></th>
    </tr>
    </tfoot>
</table>