<h3 style="color: #2a6496;">Expense History</h3>
<form action="" method="get">
    <table class="search-table" style="width:100%;">
        <tr>

            <td style="width: 15%;"><b>From: </b><input class="form-control" type="date" value="<?= $search_keys['from'] ?>" name="from"></td>
            <td style="width: 15%;"><b>To: </b><input class="form-control" type="date" value="<?= $search_keys['to'] ?>" name="to"></td>
            <td style="width: 20%;"><b>Tanker: </b><br>
                <select name="tanker[]" class="select_box" multiple style="width: 100%;">
                    <?php foreach($tankers as $tanker):?>
                        <?php
                        $selected = (in_array($tanker->number, $search_keys['tankers']))?'selected':''
                        ?>
                        <option value="<?= $tanker->number ?>" <?= $selected ?>><?= $tanker->number ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td style="width: 20%;"><b>Title </b>
                <select class="select_box title_select_box" style="width: 100%;" name="title[]" id="title" multiple>
                    <?php foreach($titles as $title):?>
                        <?php
                        $selected = (in_array($title->title, $search_keys['titles']))?'selected':''
                        ?>
                        <option value="<?= $title->title ?>" <?= $selected ?>><?= $title->title ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td style="width: 25%;"><br><button style="width: 100%; height: 30px;"><i class="fa fa-search"></i> Search</button></td>
        </tr>
    </table>
</form>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <?= sortable_header('invoice_number','numeric','Invoice#') ?>
        <?= sortable_header('invoice_date','date','Date') ?>
        <?= sortable_header('tanker', 'string', 'Tanker') ?>
        <?= sortable_header('title', 'string', 'Title') ?>
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
    <?php  foreach($expense_history as $record): ?>

        <tr style="">

            <td>
                <a href="<?= base_url()."expenses/edit/".$record->invoice_id ?>"><?= $record->invoice_id ?></a>
            </td>
            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->expense_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                echo $record->tanker;
                ?>
            </td>
            <td>
                <?php
                echo $record->expense_title;
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
                echo $record->invoice_summary;
                ?>
            </td>

            <td style="vertical-align: middle;">
                <?php deleting_btn('invoice_number', $record->invoice_id, 'delete_expense_invoice') ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">
        <th colspan="4" style="text-align: right;">Totals</th>
        <th class="total_amount"><?= rupee_format($total_cost) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>