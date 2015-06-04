<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 7:18 AM
 */
?>
<style>
    .payment_form_table th{
        text-align: right;
    }
    .payment_form_table tr{
        border-top: 2px solid inherit;
    }
</style>
<script>
    function add_new_title_box()
    {
        document.getElementById("new_title").type = 'text';
    }
</script>
<h3 style="color: #006dcc; text-align: center;">Edit Expense Voucher# <?= $voucher_id ?></h3>

<?php if(isset($_POST['addExpense'])): ?>

    <!--Notifications Area-->
    <div class="row">
        <?php echo $this->helper_model->display_flash_errors(); ?>
        <?php echo $this->helper_model->display_flash_success(); ?>
    </div>
    <!--notifications area ends-->
<?php endif; ?>

<form method="post">
    <input name="voucher_id" value="<?= $voucher_id ?>" required="required" type="hidden">
    <table class="payment_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td style="width: 40%;"><input class="form-control" value="<?= $expense->expense_date ?>" style="width: 100%;" type="date" name="expense_date"></td>

            <th>Tanker</th>
            <td>
                <select class="select_box tankers_select_box" style="width: 100%;" name="tanker" id="tanker">
                    <?php foreach($tankers as $tanker):?>
                        <?php
                        $selected = ($tanker->number == $expense->tanker)?'selected':'';
                        ?>
                        <option value="<?= $tanker->number ?>" <?= $selected ?>><?= $tanker->number ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Title</th>
            <td style="">
                <select class="select_box bank_ac_select_box" style="width: 100%;" name="expense_title" id="expense_title">
                    <?php foreach($titles as $title):?>
                        <?php
                        $selected = ($title->title == $expense->expense_title)?'selected':'';
                        ?>
                        <option value="<?= $title->title ?>" <?= $selected ?>><?= ucwords($title->title) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <th>Amount</th>
            <td><input value="<?= $expense->amount ?>" type="number" step="any" name="amount" class="form-control"></td>
        </tr>
        <tr>
            <th>Summary</th>
            <td colspan="3">
                <textarea class="form-control" name="summary"><?= $expense->invoice_summary ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <button name="updateExpense" class="btn btn-success center-block" style="width: 100px;"><i class="fa fa-save"></i> Save</button>
            </td>
        </tr>
    </table>
</form>