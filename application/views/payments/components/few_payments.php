
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Voucher#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Agent</th>
        <th class="column_heading">Account</th>
        <th class="column_heading">Amount</th>
        <th class="column_heading">Summary</th>
        <th class="column_heading"></th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_product_quantity = 0;
    $total_cost = 0;
    ?>
    <?php $parent_count = 0; ?>
    <?php  foreach($payment_history as $record): ?>

        <tr style="">

            <td>
                <a href="<?= base_url()."payments/edit/".$record->voucher_id ?>"><?= $record->voucher_id ?></a>
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
                $amount = $record->amount;
                echo rupee_format($amount);
                ?>
            </td>
            <td>
                <?php
                echo $record->summary;
                ?>
            </td>

            <td style="vertical-align: middle;">
                <?php deleting_btn('invoice_number', $record->voucher_id, 'delete_invoice') ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">

    </tr>
    </tfoot>
</table>