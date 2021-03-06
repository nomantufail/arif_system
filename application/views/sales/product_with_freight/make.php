<?php
/*
 * this variable shows that how many rows will will be displayed by default
 * */
$default_row_counter = 1;
?>
<style>
    .invoice_entries_container{
        border: 0px solid lightgray;
        min-height: 100px;
        margin: 0px;
    }
    .invoice_table{
        width: 50%;
    }
    .invoice_table td{
        margin: 10px;
    }
</style>
<script>

    /* making array of available stock at this point */
    var Stock = {};
    <?php foreach($available_stock as $group): ?>
    <?php foreach($group as $stock): ?>
    <?php
        $key = $stock->product_name.'_'.$stock->tanker;
        $value = $stock->quantity;
    ?>
    Stock["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

    /* making array of available stock at this point */
    var Purchase_Price = {};
    <?php foreach($available_stock as $group): ?>
    <?php foreach($group as $stock): ?>
    <?php
        $key = $stock->product_name.'_'.$stock->tanker;
        $value = $stock->price_per_unit;
    ?>
    Purchase_Price["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

    /* making array of Customer balances at this point */
    var CustomerBalance = {};
    <?php foreach($customers as $customer): ?>
    <?php
        $key = $customer->name;
        $value = (isset($customers_balance[$key]))?$customers_balance[$key]:0;
    ?>
    CustomerBalance["<?= $key ?>"] = "<?= $value ?>";
    <?php endforeach; ?>
    /*----------------------------------------------------------*/

    function display_row(){
        var pannel_count = document.getElementById("pannel_count");
        pannel_count_value = parseInt(pannel_count.value);
        var row_num = pannel_count_value;
        var row_id = "row_"+row_num;
        document.getElementById(row_id).style.display='';
        if(pannel_count_value == row_num)
        {
            pannel_count.value = pannel_count_value+1;

            $("#product_"+row_num).select2('val','');
            place_cross(row_num);
            remove_cross(row_num-1);
        }

    }
    function hide_row(){
        var pannel_count = document.getElementById("pannel_count");
        var decrease_count = parseInt(pannel_count.value)-1;
        var row_id = "row_"+decrease_count;
        if(pannel_count.value > <?= $default_row_counter+1 ?>){
            document.getElementById(row_id).style.display='none';
            pannel_count.value = parseInt(pannel_count.value)-1;
            grand_total_or_received_changed();
        }
    }
    function grand_total_or_received_changed()
    {
        var grand_total_temp = grand_total_cost();
        document.getElementById("grand_total_cost_label").innerHTML = to_rupees(grand_total_temp);
        var received = document.getElementById("received").value;
        document.getElementById("remaining").innerHTML = limit_number(grand_total_temp - received);

    }

    function total_cost(row_num)
    {
        var qty = document.getElementById("quantity_"+row_num).value;
        var salePricePerItem = document.getElementById("salePricePerItem_"+row_num).value;
        var total_cost = limit_number(parseFloat(qty)*parseFloat(salePricePerItem));
        if(isNaN(total_cost))
        {
            total_cost = 0;
        }
        return total_cost;
    }
    function grand_total_cost()
    {
        var pannel_count = document.getElementById("pannel_count").value;
        var grand_total_cost = 0;
        for(i = 1; i < pannel_count; i++)
        {
            var product_selected_index = document.getElementById("product_"+i).selectedIndex;
            var selected_product = document.getElementById("product_"+i).options[product_selected_index].value;
            if(selected_product != '' && document.getElementById('row_'+i).style.display == '')
            {
                grand_total_cost += total_cost(i);
            }
        }
        return grand_total_cost;
    }
    function check_for_stock_availability(row_number)
    {
        var tanker_selected_index = document.getElementById("tanker").selectedIndex;
        var tanker = document.getElementById("tanker").options[tanker_selected_index].value;

        var product_selected_index = document.getElementById("product_"+row_number).selectedIndex;
        var product = document.getElementById("product_"+row_number).options[product_selected_index].value;
        var key = product+"_"+tanker;
        var quantity = Stock[key];
        document.getElementById("quantity_"+row_number).max = quantity;
        document.getElementById("available_"+row_number).innerHTML = quantity;
    }

    function check_for_purchase_price(row_number)
    {
        var tanker_selected_index = document.getElementById("tanker").selectedIndex;
        var tanker = document.getElementById("tanker").options[tanker_selected_index].value;

        var product_selected_index = document.getElementById("product_"+row_number).selectedIndex;
        var product = document.getElementById("product_"+row_number).options[product_selected_index].value;
        var key = product+"_"+tanker;
        var purchase_price = Purchase_Price[key];
        document.getElementById("purchase_price_per_unit_"+row_number).innerHTML = to_rupees(purchase_price);
    }

    function numbers_changed(row_num)
    {

        var total_cost_temp = total_cost(row_num);
        document.getElementById("total_cost_label_"+row_num).innerHTML = to_rupees(total_cost_temp);
        grand_total_or_received_changed();
    }
    function product_changed(e)
    {
        var id = e.params.data.element.parentElement.id;
        id = id.split("_");
        id = id[1];
        check_for_stock_availability(id);
        check_for_purchase_price(id);
        //display_row(parseInt(id)+1);
        grand_total_or_received_changed();
    }
    function tanker_changed(e)
    {
        var pannel_count = document.getElementById("pannel_count");
        for(var i = 1; i < pannel_count.value; i++)
        {
            check_for_stock_availability(i);
            check_for_purchase_price(i);
        }
    }

    function customer_changed(e)
    {
        var id = (e == undefined)?'customer':e.params.data.element.parentElement.id;
        var customer_selected_index = document.getElementById("customer").selectedIndex;
        var customer = document.getElementById("customer").options[customer_selected_index].value;
        document.getElementById("customer_balance").innerHTML = to_rupees(CustomerBalance[customer]);
    }

    function place_cross(row_num)
    {
        document.getElementById('cross_'+row_num).innerHTML='X';
    }
    function remove_cross(row_num)
    {
        document.getElementById('cross_'+row_num).innerHTML='';
    }

    function validate_product_sale_invoice_form()
    {
        pannel_count_value = parseInt(pannel_count.value);
        num_rows = pannel_count_value-1;

        /* Checking if same product is used twice or not */
        for(var i =0; i<num_rows; i++)
        {
            var product_selected_index = document.getElementsByClassName("product_select_box")[i].selectedIndex;
            var product = document.getElementsByClassName("product_select_box")[i].options[product_selected_index].value;

            for(var c =0; c<num_rows; c++)
            {
                var product_selected_index2 = document.getElementsByClassName("product_select_box")[c].selectedIndex;
                var product2 = document.getElementsByClassName("product_select_box")[c].options[product_selected_index2].value;

                if(product == product2 && i != c)
                {
                    alert("Error! Same product cannot be used twice.");
                    return false;
                }
            }
        }
        /*----------------------------------------------------*/

        /* Checking if any product is selected or not */
        var is_any_product_selected = false;
        for(var i =0; i<num_rows; i++)
        {
            var product_selected_index = document.getElementsByClassName("product_select_box")[i].selectedIndex;
            var product = document.getElementsByClassName("product_select_box")[i].options[product_selected_index].value;
            if(product != '')
            {
                is_any_product_selected = true;
            }
        }

        if(is_any_product_selected == false)
        {
            alert("Error! Please Select atleast one product to make this invoice");
            return false;
        }
        /*----------------------------------------------------*/

        return true;
    }

    $( document ).ready(function() {
        customer_changed();
    });
</script>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once(APPPATH."views/sales/product_with_freight/components/nav_bar.php");
            ?>
        </div>

        <!--Notifications Area-->
        <div class="row">
            <?php echo $this->helper_model->display_flash_errors(); ?>
            <?php echo $this->helper_model->display_flash_success(); ?>

        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents" style=" margin-top: 20px;">
            <form method="post" onsubmit="return validate_product_sale_invoice_form()">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="">
                            <tr>
                                <th><h4>Invoice# <?= $invoice_number ?></h4></th>
                            </tr>
                        </table>
                        <table style="width: 100%;" class="">
                            <tr>
                                <td>
                                    <span><b>Customer:</b></span><br>
                                    <select class="select_box customers_select_box" style="width: 200px;" name="customer" id="customer">
                                        <?php foreach($customers as $customer):?>
                                            <option value="<?= $customer->name ?>"><?= $customer->name ?></option>
                                        <?php endforeach; ?>
                                    </select><br>
                                    <span style="color: #808080;">Balance: </span><span style="color: gray;" id="customer_balance"></span>
                                </td>
                                <td>
                                    <span><b>Tanker:</b></span><br>
                                    <select class="select_box tanker_select_box" name="tanker" id="tanker" style="min-width: 70px;">
                                        <?php foreach($busy_tankers as $tanker):?>
                                            <option value="<?= $tanker->number ?>"><?= $tanker->number ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach($free_tankers as $tanker):?>
                                            <option disabled value="<?= $tanker->number ?>"><?= $tanker->number ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td>
                                    <span><b>Invoice Date:</b></span><br>
                                    <input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 200px; " type="date" name="invoice_date">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top: 10px;">

                    <div class="row">

                        <div class="col-lg-12 invoice_entries_container" style="overflow-x: auto;">

                            <table class="table">
                                <thead>
                                <tr style="background-color: lightblue;">
                                    <th style="">Product</th>
                                    <th style="width: 10%;">Qty</th>
                                    <th style="width: 10%;">Sale Price / Item</th>
                                    <th style="width: 12%;">Total Price</th>
                                    <th>Freight</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for($row_counter = 1; $row_counter<10; $row_counter++):?>

                                    <tr id="row_<?= $row_counter ?>" style="display: <?= ($row_counter > $default_row_counter)?"none":""; ?>; background-color: <?= (($row_counter % 2 == 0)?'rgba(0,0,0,0.06)':'') ?>;">
                                        <td>
                                            <select class="select_box product_select_box" style="width: 200px;" name="product_<?= $row_counter ?>" id="product_<?= $row_counter ?>">
                                                <option value="">--Select--</option>
                                                <?php foreach($products as $product):?>
                                                    <option value="<?= $product->name ?>"><?= $product->name ?></option>
                                                <?php endforeach; ?>
                                            </select><br>
                                            <span style="color: #808080;">Available: </span><span style="color: gray;" id="available_<?= $row_counter ?>"></span>
                                        </td>
                                        <td><input style="width: ;" type="number" step="any" name="quantity_<?= $row_counter ?>" id="quantity_<?= $row_counter ?>" onchange="numbers_changed(<?= $row_counter ?>)" onkeyup="numbers_changed(<?= $row_counter ?>)"></td>
                                        <td>
                                            <input style="width: ;" type="number" step="any" name="salePricePerItem_<?= $row_counter ?>" id="salePricePerItem_<?= $row_counter ?>" onchange="numbers_changed(<?= $row_counter ?>)" onkeyup="numbers_changed(<?= $row_counter ?>)">
                                            <br>
                                            <span style="color: #808080;">Purchase Price: </span><span style="color: gray;" id="purchase_price_per_unit_<?= $row_counter ?>"></span>
                                        </td>
                                        <td><span id="total_cost_label_<?= $row_counter ?>"></span></td>
                                        <td>
                                            <input type="number" step="any" name="freight_amount_<?= $row_counter ?>" style="width: ;">
                                        </td>
                                    </tr>
                                <?php endfor; ?>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <input value="<?= $default_row_counter+1 ?>" type="hidden" id="pannel_count" name="pannel_count">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <a href="#" onclick="display_row()" class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"> </i> Add Row</a>
                                        <a href="#" onclick="hide_row()" class="btn btn-xs btn-danger"><i class="fa fa-minus-circle"> </i> Delete Row</a>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="margin:0px;">
                            <label class="" style="font-size: 18px;">Other Information:</label>
                            <textarea class="form-control" name="extra_info"></textarea>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-4" style="margin: 0px; float: right;">
                            <section style="font-size: 20px; font-weight: normal; color: red;">Total Cost: <span id="grand_total_cost_label">0</span> Rs.</section>
                        </div>
                        <div class="col-md-4" style="margin: 0px; float: right;">
                            <button name="add_product_with_freight" class="btn btn-success" style="font-size: 20px;"><i class="fa fa-save" style="color: white;"></i> Save Invoice</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row" style="margin-top: 20px;">
                <?php
                include_once(APPPATH."views/sales/product_with_freight/components/few_sales.php");
                ?>
            </div>
        </div>



    </div>

</div>
<script>
    var $productSelect = $(".product_select_box");
    var $tankerSelect = $(".tanker_select_box");
    var $customerSelect = $(".customers_select_box");
    $productSelect.on("select2:select", function (e) {
        product_changed(e);
    });
    $tankerSelect.on("select2:select", function (e) {
        tanker_changed(e);
    });
    $customerSelect.on("select2:select", function (e) {
        customer_changed(e);
    });
</script>