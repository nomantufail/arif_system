
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Voucher#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Account</th>
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
    <?php  foreach($few_payments as $record): ?>

        <tr style="">

            <td>
                <a href="<?= base_url()."expenses/edit_payment/".$record->voucher_id ?>"><?= $record->voucher_id ?></a>
            </td>
            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                $bank = $record->account;
                echo $bank;
                ?>
            </td>
            <td>
                <?php
                $amount = rupee_format($record->amount);
                echo $amount;
                ?>
            </td>
            <td>
                <?php
                echo $record->summary;
                ?>
            </td>

            <td style="vertical-align: middle;">
                <?php deleting_btn('invoice_number', $record->voucher_id, 'delete_expense_payment_voucher') ?>
            </td>


        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">

    </tr>
    </tfoot>
</table>