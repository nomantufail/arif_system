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

    /* making array of bank balances at this point */
    var BankBalance = {};
    <?php foreach($bank_accounts as $account): ?>
    <?php
        $key = $account->title." (".$account->bank." ".bn_masking($account->account_number).")";
        $value = (isset($banks_balance[$key]))?$banks_balance[$key]:0;
    ?>
    BankBalance["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

    /* making array of Withdraw accounts balances at this point */
    var WithdrawAccountBalance = {};
    <?php foreach($withdraw_accounts as $account): ?>
    <?php
        $key = $account->title;
        $value = (isset($withdraw_accounts_balance[$key]))?$withdraw_accounts_balance[$key]:0;
    ?>
    WithdrawAccountBalance["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

    function add_new_title_box()
    {
        document.getElementById("new_title").type = 'text';
    }

    function bank_ac_changed(e)
    {
        var id = (e == undefined)?'bank_ac':e.params.data.element.parentElement.id;
        var bank_selected_index = document.getElementById("bank_ac").selectedIndex;
        var bank = document.getElementById("bank_ac").options[bank_selected_index].value;
        parts_of_bank = bank.split('_&&_');
        bank = parts_of_bank[0];
        document.getElementById("bank_balance").innerHTML = to_dr_cr_string(BankBalance[bank]);
    }
    function withdraw_ac_changed(e)
    {
        var id = (e == undefined)?'withdraw_account':e.params.data.element.parentElement.id;
        var withdraw_ac_selected_index = document.getElementById("withdraw_account").selectedIndex;
        var withdraw_account = document.getElementById("withdraw_account").options[withdraw_ac_selected_index].value;

        document.getElementById("withdraw_account_balance").innerHTML = to_dr_cr_string(WithdrawAccountBalance[withdraw_account]);
    }

    $( document ).ready(function() {
        withdraw_ac_changed();
        bank_ac_changed();
    });
</script>
<h3 style="color: #006dcc; text-align: center;">Withdraw Voucher</h3>

<?php if(isset($_POST['addExpense'])): ?>
    <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">

                                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                                <strong>Error! </strong>', '</div>'); ?>
    <?php if(is_array(@$someMessage)){ ?>
        <div class="alert <?= $someMessage['type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?= $someMessage['message']; ?>
        </div>
    <?php } ?>
<?php endif; ?>

<form method="post" action="<?= $this->helper_model->controller_path()."withdraw" ?>">
    <table class="payment_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td style="width: 40%;"><input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 100%;" type="date" name="voucher_date"></td>

            <th>Bank A/C</th>
            <td>
                <select class="select_box bank_ac_select_box" style="width: 100%;" name="bank_ac" id="bank_ac">
                    <?php foreach($bank_accounts as $account):?>
                        <option value="<?= $account->title." (".$account->bank." ".bn_masking($account->account_number).")"."_&&_".$account->type ?>"><?= $account->title." (".$account->bank." ".bn_masking($account->account_number).")" ?></option>
                    <?php endforeach; ?>
                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="bank_balance"></span>
            </td>
        </tr>
        <tr>
            <th>Withdraw A/C</th>
            <td style="">
                <select class="select_box withdraw_ac_select_box" style="width: 100%;" name="withdraw_account" id="withdraw_account">
                    <?php foreach($withdraw_accounts as $title):?>
                        <option value="<?= $title->title ?>"><?= ucwords($title->title) ?></option>
                    <?php endforeach; ?>
                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="withdraw_account_balance"></span>
            </td>
            <th>Amount</th>
            <td><input type="number" step="any" name="amount" class="form-control"></td>
        </tr>
        <tr>
            <th>Summary</th>
            <td colspan="3">
                <textarea class="form-control" name="summary"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <button name="withdraw" class="btn btn-success center-block" style="width: 100px;"><i class="fa fa-save"></i> Withdraw</button>
            </td>
        </tr>
    </table>
</form>

<script>
    var $bank_ac_select = $(".bank_ac_select_box");
    var $withdraw_ac_select = $(".withdraw_ac_select_box");
    $bank_ac_select.on("select2:select", function (e) {
        bank_ac_changed(e);
    });
    $withdraw_ac_select.on("select2:select", function (e) {
        bank_ac_changed(e);
    });
</script>