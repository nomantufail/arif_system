<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 7:18 AM
 */
?>
<style>
    .receipt_form_table th{
        text-align: right;
    }
    .receipt_form_table tr{
        border-top: 2px solid inherit;
    }
</style>
<script>

    /* making array of supplier balances at this point */
    var CustomerBalance = {};
    <?php foreach($customers as $customer): ?>
    <?php
        $key = $customer->name;
        $value = (isset($customers_balance[$key]))?$customers_balance[$key]:0;
    ?>
    CustomerBalance["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

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

    function customer_changed(e)
    {
        var id = (e == undefined)?'customer':e.params.data.element.parentElement.id;
        var customer_selected_index = document.getElementById("customer").selectedIndex;
        var customer = document.getElementById("customer").options[customer_selected_index].value;
        document.getElementById("customer_balance").innerHTML = to_rupees(CustomerBalance[customer]);
    }

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
        customer_changed();
        bank_ac_changed();
    });
</script>
<h3 style="color: #006dcc; text-align: center;">Receipt Vocuher</h3>

<?php if(isset($_POST['saveReceipt'])): ?>
    <?php echo $this->helper_model->display_flash_errors(); ?>
    <?php echo $this->helper_model->display_flash_success(); ?>
<?php endif; ?>

<form method="post" action="<?= $this->helper_model->controller_path()."make" ?>">
    <table class="receipt_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td><input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 100%;" type="date" name="voucher_date"></td>

            <th>Customer</th>
            <td>
                <select class="select_box customers_select_box" style="width: 100%;" name="customer" id="customer">
                    <?php foreach($customers as $customer):?>
                        <option value="<?= $customer->name ?>"><?= $customer->name ?></option>
                    <?php endforeach; ?>
                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="customer_balance"></span>
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <td><input type="number" step="any" name="amount" class="form-control"></td>
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
            <th>Summary</th>
            <td colspan="3">
                <textarea class="form-control" name="summary"></textarea>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <button name="saveReceipt" class="btn btn-success center-block" style="width: 150px;"><i class="fa fa-save"></i> Save</button>
            </td>
        </tr>
    </table>
</form>

<script>
    var $customerSelect = $(".customers_select_box");
    var $bank_ac_select = $(".bank_ac_select_box");
    $customerSelect.on("select2:select", function (e) {
        customer_changed(e);
    });
    $bank_ac_select.on("select2:select", function (e) {
        bank_ac_changed(e);
    });
</script>