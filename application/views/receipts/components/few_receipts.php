
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Vcouher#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Customer</th>
        <th class="column_heading">Bank</th>
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
    <?php  foreach($receipt_history as $record): ?>

        <tr style="">

            <td>
                <a href="<?= base_url()."receipts/edit/".$record->voucher_id ?>"><?= $record->voucher_id ?></a>
            </td>

            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                $customer = $record->related_customer;
                echo $customer;
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