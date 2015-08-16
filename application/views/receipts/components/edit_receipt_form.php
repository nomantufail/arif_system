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
    var CustomerBalance = {};
    <?php foreach($customers as $customer): ?>
    <?php
        $key = $customer->name;
        $value = (isset($customers_balance[$key]))?$customers_balance[$key]:0;
    ?>
    CustomerBalance["<?= $key ?>"] = "<?= $value ?>";
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

    /* making CashBalance Variable */
    var CashBalance = <?= $cash_balance ?>;
    /*----------------------------------------------------------*/


    /* making array of suppliers at this point */
    var Suppliers = [];
    <?php foreach($suppliers as $supplier): ?>
    <?php
        $value = $supplier->name;
        $text = ucwords($supplier->name);
        $selected = ($receipt->agent_type == 'supplier')?((strtolower($supplier->name) == strtolower($receipt->agent))?true:false):false;
    ?>
    Suppliers.push(
        {
            'value':"<?= $value ?>",
            'text':"<?= $text ?>",
            'selected':"<?= $selected ?>"
        }
    );
    <?php endforeach; ?>
    /*----------------------------------------------------------*/


    /* making array of Customers at this point */
    var Customers = [];
    <?php foreach($customers as $customer): ?>
    <?php
        $value = $customer->name;
        $text = ucwords($customer->name);
        $selected = ($receipt->agent_type == 'customer')?((strtolower($customer->name) == strtolower($receipt->agent))?true:false):false;
    ?>
    Customers.push(
        {
            'value':"<?= $value ?>",
            'text':"<?= $text ?>",
            'selected':"<?= $selected; ?>"
        }
    );
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

    function agent_changed(e)
    {
        var id = (e == undefined)?'supplier':e.params.data.element.parentElement.id;

        var agent_type_selected_index = document.getElementById("agent_type").selectedIndex;
        var agent_type = document.getElementById("agent_type").options[agent_type_selected_index].value;

        var agents_selected_index = document.getElementById("agents").selectedIndex;
        var agent = document.getElementById("agents").options[agents_selected_index].value;

        var balance = 0.0;
        if(agent_type == 'customer')
        {
            balance = to_rupees(CustomerBalance[agent]);
        }
        else if(agent_type == 'supplier')
        {
            balance = to_rupees(SupplierBalance[agent]);
        }

        document.getElementById("agent_balance").innerHTML = balance;

    }

    function agent_type_changed()
    {
        removeOptions(document.getElementById("agents"));
        $("#agents").val('');
        var agent_type_selected_index = document.getElementById("agent_type").selectedIndex;
        var agent_type = document.getElementById("agent_type").options[agent_type_selected_index].value;
        var agents = [];
        if(agent_type == "supplier")
        {
            agents = Suppliers;
        }else{
            agents = Customers;
        }

        var target_select = document.getElementById('agents');

        for (var i = 0; i< agents.length; i++){
            var opt = document.createElement('option');
            opt.value = agents[i].value;
            opt.selected = agents[i].selected;
            opt.innerHTML = agents[i].value;
            target_select.appendChild(opt);
        }
        $('#agents').trigger('change');

        agent_changed();
    }

    function account_changed(e)
    {
        var id = (e == undefined)?'account':e.params.data.element.parentElement.id;
        var bank_selected_index = document.getElementById("account").selectedIndex;
        var bank = document.getElementById("account").options[bank_selected_index].value;
        if(bank != 'cash'){
            parts_of_bank = bank.split('_&&_');
            bank = parts_of_bank[0];
            document.getElementById("account_balance").innerHTML = to_rupees(BankBalance[bank]);
        }else{
            document.getElementById("account_balance").innerHTML = to_rupees(CashBalance);
        }
    }

    $( document ).ready(function() {
        agent_type_changed();
        account_changed();
    });
</script>
<h3 style="color: #006dcc; text-align: center;">Edit Receipt Voucher# <?= $voucher_id ?> </h3>

<?php echo $this->helper_model->display_flash_errors(); ?>
<?php echo $this->helper_model->display_flash_success(); ?>

<form method="post">
    <input type="hidden" name="voucher_id" value="<?= $voucher_id ?>" required="required">
    <table class="receipt_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td><input class="form-control" value="<?= $receipt->voucher_date; ?>" style="width: 100%;" type="date" name="voucher_date"></td>

            <th>Agent</th>
            <td>
                <select id="agent_type" class="form-control" name="agent_type" onchange="agent_type_changed()">
                    <option value="supplier" <?= ($receipt->agent_type == 'supplier')?'selected':'' ?> >Supplier</option>
                    <option value="customer" <?= ($receipt->agent_type == 'customer')?'selected':'' ?>>Customer</option>
                </select>
                <select class="select_box suppliers_select_box" onchange="agent_changed()" style="width: 100%;" name="agent" id="agents">

                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="agent_balance"></span>
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <td><input value="<?= $receipt->amount ?>" type="number" step="any" required="required" min="0" name="amount" class="form-control"></td>
            <th>Account</th>
            <td>
                <select class="select_box account_select_box" style="width: 100%;" name="account" id="account">
                    <option value="cash" <?= ($receipt->account == 'cash')?'selected':'' ?> >Cash</option>
                    <?php foreach($bank_accounts as $account):?>
                        <option <?= (strtolower(formatted_bank_account($account)) == strtolower($receipt->account))?'selected':'' ?> value="<?= formatted_bank_account($account)."_&&_".$account->type ?>"><?= $account->title." (".$account->bank." ".bn_masking($account->account_number).")" ?></option>
                    <?php endforeach; ?>
                </select><br>
                <span style="color: #808080;">Balance: </span><span style="color: gray;" id="account_balance"></span>
            </td>
        </tr>
        <tr>
            <th>Summary</th>
            <td colspan="3">
                <textarea class="form-control" name="summary"><?= $receipt->summary ?></textarea>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <button name="updateReceipt" class="btn btn-success center-block" style="width: 150px;"><i class="fa fa-save"></i> Save</button>
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