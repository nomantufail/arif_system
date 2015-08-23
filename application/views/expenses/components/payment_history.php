
<h4 style="color: #006dcc">Expense Payment History</h4>
<form action="" method="get">
    <table class="search-table" style="width:100%;">
        <tr>
            <td style="width: 15%;"><b>From: </b><input class="form-control" type="date" value="<?= $search_keys['from'] ?>" name="from"></td>
            <td style="width: 15%;"><b>To: </b><input class="form-control" type="date" value="<?= $search_keys['to'] ?>" name="to"></td>
            <td style="width: 35%;"><b>Account: </b>
                <select class="select_box account_select_box" style="width: 100%;" name="account[]" id="account" multiple>
                    <option value="cash" <?= (in_array("cash", $search_keys['accounts']))?'selected':'' ?>>Cash</option>
                    <?php foreach($bank_accounts as $account):?>
                        <?php
                        $selected = (in_array(formatted_bank_account($account), $search_keys['accounts']))?'selected':'';
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
        <?= sortable_header('voucher_id','numeric','Invoice#') ?>
        <?= sortable_header('voucher_date','date','Date') ?>
        <?= sortable_header('account', 'string', 'Account') ?>
        <?= sortable_header('amount', 'numeric', 'Amount') ?>
        <?= sortable_header('summary', 'string', 'Summary') ?>
        <th class="column_heading"></th>
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
                $total_cost += $record->amount;
                echo rupee_format($record->amount);
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
        <th style="text-align: right;" colspan="3">Totals</th>
        <th class="total_amount"><?= rupee_format($total_cost) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>