
<h4 style="color: #006dcc">Receipt History</h4>
<form action="" method="get">
    <table class="search-table" style="width:100%;">
        <tr>
            <td style="width: 15%;"><b>From: </b><input class="form-control" type="date" value="<?= $search_keys['from'] ?>" name="from"></td>
            <td style="width: 15%;"><b>To: </b><input class="form-control" type="date" value="<?= $search_keys['to'] ?>" name="to"></td>
            <td style="width: 20%;"><b>Supplier: </b><br>
                <select name="supplier[]" class="select_box" multiple style="width: 100%;">
                    <?php foreach($suppliers as $supplier):?>
                        <?php
                        $selected = (in_array($supplier->name, $search_keys['suppliers']))?'selected':''
                        ?>
                        <option value="<?= $supplier->name ?>" <?= $selected ?>><?= $supplier->name ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td style="width: 20%;"><b>Customer: </b><br>
                <select name="customer[]" class="select_box" multiple style="width: 100%;">
                    <?php foreach($customers as $customer):?>
                        <?php
                        $selected = (in_array($customer->name, $search_keys['customers']))?'selected':''
                        ?>
                        <option value="<?= $customer->name ?>" <?= $selected ?>><?= $customer->name ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td style="width: 20%;"><b>Account: </b><br>
                <select class="select_box bank_ac_select_box" style="width: 100%;" name="account[]" id="bank_ac" multiple>
                    <option value="cash" <?= (in_array('cash',$search_keys['accounts']))?'selected':'' ?>>Cash</option>
                    <?php foreach($bank_accounts as $account):?>
                        <?php
                        $selected = (in_array(formatted_bank_account($account), $search_keys['accounts']))?'selected':''
                        ?>
                        <option value="<?= formatted_bank_account($account) ?>" <?= $selected ?>><?= formatted_bank_account($account) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td style="width: 25%;"><br><button style="width: 100%; height: 30px;"><i class="fa fa-search"></i> Search</button></td>
        </tr>
    </table>
</form>

<!--      Print Form          -->
<?= print_form(); ?>
<!-- print form ends    -->

<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <?= sortable_header('invoice_number','numeric','Invoice#') ?>
        <?= sortable_header('invoice_date','date','Date') ?>
        <?= sortable_header('agent', 'string', 'Agent') ?>
        <?= sortable_header('account', 'string', 'Account') ?>
        <?= sortable_header('amount', 'numeric', 'Amount') ?>
        <?= sortable_header('summary', 'string', 'Summary') ?>
        <th class="column_heading"></th>
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
                <a href="<?= base_url()."receipts/edit/".$record->voucher_id ?>"><?= $record->voucher_id ?></a>
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

            <td style="vertical-align: middle;">
                <?php deleting_btn('invoice_number', $record->voucher_id, 'delete_invoice') ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">
        <th style="text-align: right;" colspan="4">Totals</th>
        <th class="total_amount"><?= rupee_format($grand_total_amount) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>