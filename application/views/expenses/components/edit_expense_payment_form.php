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

    /* making array of supplier balances at this point */
    var BankBalance = {};
    <?php foreach($bank_accounts as $account): ?>
    <?php
        $key = $account->title." (".$account->bank." ".bn_masking($account->account_number).")";
        $value = (isset($banks_balance[$key]))?$banks_balance[$key]:0;
    ?>
    BankBalance["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    /*----------------------------------------------------------*/
    function bank_ac_changed(e)
    {
        var id = (e == undefined)?'bank_ac':e.params.data.element.parentElement.id;
        var bank_selected_index = document.getElementById("bank_ac").selectedIndex;
        var bank = document.getElementById("bank_ac").options[bank_selected_index].value;
        parts_of_bank = bank.split('_&&_');
        bank = parts_of_bank[0];
        document.getElementById("bank_balance").innerHTML = to_rupees(BankBalance[bank]);
    }

    $( document ).ready(function() {
        bank_ac_changed();
    });
</script>
<h3 style="color: #006dcc; text-align: center;">Edit Expense Payment Voucher# <?= $voucher_id ?></h3>

<!--Notifications Area-->
<div class="row">
    <?php echo $this->helper_model->display_flash_errors(); ?>
    <?php echo $this->helper_model->display_flash_success(); ?>
</div>
<!--notifications area ends-->

<form method="post">
    <input type="hidden" value="<?= $voucher_id ?>" name="voucher_id">
    <table class="payment_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td><input class="form-control" value="<?= $payment->voucher_date ?>" style="width: 100%;" type="date" name="voucher_date"></td>

            <th>Bank A/C</th>
            <td>
                <select class="select_box bank_ac_select_box" style="width: 100%;" name="bank_ac" id="bank_ac">
                    <?php foreach($bank_accounts as $account):?>
                        <?php
                        $selected = (formatted_bank_account($account) == $payment->bank_ac)?'selected':'';
                        ?>
                        <option value="<?= formatted_bank_account($account)."_&&_".$account->type ?>" <?= $selected ?>><?= formatted_bank_account($account) ?></option>
                    <?php endforeach; ?>
                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="bank_balance"></span>
            </td>
        </tr>

        <tr>
            <th>Amount</th>
            <td><input value="<?= $payment->amount ?>" type="number" step="any" name="amount" class="form-control"></td>
            <th>Summary</th>
            <td>
                <textarea class="form-control" name="summary"><?= $payment->summary ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <button name="updatePayment" class="btn btn-success center-block" style="width: 100px;"><i class="fa fa-save"></i> Save</button>
            </td>
        </tr>
    </table>
</form>

<script>
    var $bank_ac_select = $(".bank_ac_select_box");
    $bank_ac_select.on("select2:select", function (e) {
        bank_ac_changed(e);
    });
</script>