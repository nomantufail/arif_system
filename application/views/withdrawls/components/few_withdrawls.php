
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Invoice#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Bank A/C</th>
        <th class="column_heading">Withdraw A/C</th>
        <th class="column_heading">Amount</th>
        <th class="column_heading">Summary</th>
        <th class="column_heading"></th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_cost = 0;
    ?>
    <?php $parent_count = 0; ?>
    <?php  foreach($few_withdrawls as $record): ?>

        <tr style="">
            <td>
                <a href="<?= base_url()."withdrawls/edit_withdrawl/".$record->voucher_id ?>"><?= $record->voucher_id ?></a>
            </td>
            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                echo $record->bank_ac;
                ?>
            </td>
            <td>
                <?php
                echo $record->withdraw_account;
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
            <td>
                <?php deleting_btn('voucher_id', $record->voucher_id, 'delete_voucher') ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">

    </tr>
    </tfoot>
</table>