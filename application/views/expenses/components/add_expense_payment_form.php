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

    /* making CashBalance Variable */
    var CashBalance = <?= $cash_balance ?>;
    /*----------------------------------------------------------*/


    function account_changed(e)
    {
        var id = (e == undefined)?'account':e.params.data.element.parentElement.id;
        var bank_selected_index = document.getElementById("account").selectedIndex;
        var bank = document.getElementById("account").options[bank_selected_index].value;
        if(bank != 'cash'){
            var parts_of_bank = bank.split('_&&_');
            bank = parts_of_bank[0];
            document.getElementById("account_balance").innerHTML = to_rupees(BankBalance[bank]);
        }else{
            document.getElementById("account_balance").innerHTML = to_rupees(CashBalance);
        }
    }

    $( document ).ready(function() {
        account_changed();
    });
</script>
<h3 style="color: #006dcc; text-align: center;">Expense Payment Voucher</h3>

<!--Notifications Area-->
<div class="row">
    <?php echo $this->helper_model->display_flash_errors(); ?>
    <?php echo $this->helper_model->display_flash_success(); ?>
</div>
<!--notifications area ends-->

<form method="post" action="<?= $this->helper_model->controller_path()."add_payment" ?>">
    <table class="payment_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td><input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 100%;" type="date" name="voucher_date"></td>

            <th>Bank A/C</th>
            <td>
                <select class="select_box account_select_box" style="width: 100%;" name="account" id="account">
                    <option value="cash">Cash</option>
                    <?php foreach($bank_accounts as $account):?>
                        <option value="<?= $account->title." (".$account->bank." ".bn_masking($account->account_number).")"."_&&_".$account->type ?>"><?= $account->title." (".$account->bank." ".bn_masking($account->account_number).")" ?></option>
                    <?php endforeach; ?>
                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="account_balance"></span>
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <td><input type="number" step="any" name="amount" class="form-control"></td>
            <th>Summary</th>
            <td>
                <textarea class="form-control" name="summary"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <button name="savePayment" class="btn btn-success center-block" style="width: 100px;"><i class="fa fa-save"></i> Save</button>
            </td>
        </tr>
    </table>
</form>

<script>

    var $account_select = $(".account_select_box");
    $account_select.on("select2:select", function (e) {
        account_changed(e);
    });
</script>