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
    var SupplierBalance = {};
    <?php foreach($suppliers as $supplier): ?>
    <?php
        $key = $supplier->name;
        $value = (isset($suppliers_balance[$key]))?$suppliers_balance[$key]:0;
    ?>
    SupplierBalance["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

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

    function supplier_changed(e)
    {
        var id = (e == undefined)?'supplier':e.params.data.element.parentElement.id;
        var supplier_selected_index = document.getElementById("supplier").selectedIndex;
        var supplier = document.getElementById("supplier").options[supplier_selected_index].value;
        document.getElementById("supplier_balance").innerHTML = to_rupees(SupplierBalance[supplier]);
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
        supplier_changed();
        bank_ac_changed();
    });
</script>
<h3 style="color: #006dcc; text-align: center;">Payment Voucher</h3>

<?php if(isset($_POST['savePayment'])): ?>
    <!--Notifications Area-->
    <div class="row">
        <?php echo $this->helper_model->display_flash_errors(); ?>
        <?php echo $this->helper_model->display_flash_success(); ?>
    </div>
    <!--notifications area ends-->
<?php endif; ?>

<form method="post" action="<?= $this->helper_model->controller_path()."make" ?>">
    <table class="payment_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td><input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 100%;" type="date" name="voucher_date"></td>

            <th>Supplier</th>
            <td>
                <select class="select_box suppliers_select_box" style="width: 100%;" name="supplier" id="supplier">
                    <?php foreach($suppliers as $supplier):?>
                        <option value="<?= $supplier->name ?>"><?= $supplier->name ?></option>
                    <?php endforeach; ?>
                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="supplier_balance"></span>
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
                <button name="savePayment" class="btn btn-success center-block" style="width: 100px;"><i class="fa fa-save"></i> Save</button>
            </td>
        </tr>
    </table>
</form>

<script>
    var $supplierSelect = $(".suppliers_select_box");
    var $bank_ac_select = $(".bank_ac_select_box");
    $supplierSelect.on("select2:select", function (e) {
        supplier_changed(e);
    });
    $bank_ac_select.on("select2:select", function (e) {
        bank_ac_changed(e);
    });
</script>