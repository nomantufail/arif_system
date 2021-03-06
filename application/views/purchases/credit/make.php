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

    /*----------------------------------------------------------*/

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

    function display_row(row_num){
        var pannel_count = document.getElementById("pannel_count");
        var row_id = "row_"+row_num;
        document.getElementById(row_id).style.display='';
        pannel_count_value = parseInt(pannel_count.value);
        if(pannel_count_value == row_num)
        {
            pannel_count.value = pannel_count_value+1;

            $("#product_"+row_num).select2('val','');
            place_cross(row_num);
            remove_cross(row_num-1);
        }

    }
    function hide_row(row_num){
        var pannel_count = document.getElementById("pannel_count");
        var decrease_count = parseInt(pannel_count.value)-1;
        var row_id = "row_"+decrease_count;
        if(pannel_count.value > <?= $default_row_counter+1 ?>){
            document.getElementById(row_id).style.display='none';
            pannel_count.value = parseInt(pannel_count.value)-1;
            remove_cross(row_num);
            place_cross(row_num-1);

            grand_total_or_paid_changed();
        }
    }
    function grand_total_or_paid_changed()
    {
        var grand_total_temp = grand_total_cost();
        document.getElementById("grand_total_cost_label").innerHTML = to_rupees(grand_total_temp);
        var paid = document.getElementById("paid").value;
        document.getElementById("remaining").innerHTML = limit_number(grand_total_temp - paid);

    }

    function total_cost(row_num)
    {
        var qty = document.getElementById("quantity_"+row_num).value;
        var costPerItem = document.getElementById("costPerItem_"+row_num).value;
        var total_cost = limit_number(parseFloat(qty)*parseFloat(costPerItem));
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

    function numbers_changed(row_num)
    {
        var total_cost_temp = total_cost(row_num);
        document.getElementById("total_cost_label_"+row_num).innerHTML = to_rupees(total_cost_temp);
        grand_total_or_paid_changed();
    }

    function supplier_changed(e)
    {
        var id = (e == undefined)?'supplier':e.params.data.element.parentElement.id;
        var supplier_selected_index = document.getElementById("supplier").selectedIndex;
        var supplier = document.getElementById("supplier").options[supplier_selected_index].value;
        document.getElementById("supplier_balance").innerHTML = to_rupees(SupplierBalance[supplier]);
    }

    function product_changed(e)
    {
        var id = e.params.data.element.parentElement.id;
        id = id.split("_");
        id = id[1];
        //display_row(parseInt(id)+1);
        grand_total_or_paid_changed();
    }

    function place_cross(row_num)
    {
        document.getElementById('cross_'+row_num).innerHTML='X';
    }
    function remove_cross(row_num)
    {
        document.getElementById('cross_'+row_num).innerHTML='';
    }

    function validate_purchase_invoice_form()
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
        supplier_changed();
    });
</script>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once(APPPATH."views/purchases/components/nav_bar.php");
            ?>
        </div>

        <!--Notifications Area-->
        <div class="row">
            <?php echo $this->helper_model->display_flash_errors(); ?>
            <?php echo $this->helper_model->display_flash_success(); ?>

<!--            --><?php //if(sizeof($tankers) == 0){ ?>
<!--                <div class="alert alert-warning alert-dismissible" role="alert">-->
<!--                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
<!--                    Warning: No tankers available for now. <br>-->
<!--                </div>-->
<!--            --><?php //} ?>
        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents" style="margin-top: 20px;">
            <form method="post" onsubmit="return validate_purchase_invoice_form()">
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
                                    <span><b>Supplier:</b></span><br>
                                    <select class="select_box suppliers_select_box" style="width: 200px;" name="supplier" id="supplier">
                                        <?php foreach($suppliers as $supplier):?>
                                            <option value="<?= $supplier->name ?>"><?= $supplier->name ?></option>
                                        <?php endforeach; ?>
                                    </select><br>
                                    <span style="color: #808080;">Balance: </span><span style="color: gray;" id="supplier_balance"></span>
                                </td>
                                <td>
                                    <span><b>Tanker:</b></span><br>
                                    <select class="select_box" name="tanker" style="min-width: 70px;">
                                        <?php foreach($free_tankers as $tanker):?>
                                            <option value="<?= $tanker->number ?>"><?= $tanker->number ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach($busy_tankers as $tanker):?>
                                            <option disabled value="<?= $tanker->number ?>"><?= $tanker->number ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td>
                                    <span><b>Invoice Date:</b></span><br>
                                    <input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 200px;" type="date" name="invoice_date">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">

                    <div class="row">

                        <div class="col-lg-12 invoice_entries_container">

                            <table class="table">
                                <thead>
                                <tr style="background-color: lightblue;">
                                    <th style="width: 25%;">Product</th>
                                    <th style="width: 12%;">Qty</th>
                                    <th style="width: 12%;">Cst/item</th>
                                    <th style="width: 12%;">Total/Cst</th>
                                    <th style="width: 10%;"></th>
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
                                            </select>
                                        </td>
                                        <td><input min="0" type="number" step="any" name="quantity_<?= $row_counter ?>" id="quantity_<?= $row_counter ?>" onchange="numbers_changed(<?= $row_counter ?>)" onkeyup="numbers_changed(<?= $row_counter ?>)"></td>
                                        <td><input min="0" type="number" step="any" name="costPerItem_<?= $row_counter ?>" id="costPerItem_<?= $row_counter ?>" onchange="numbers_changed(<?= $row_counter ?>)" onkeyup="numbers_changed(<?= $row_counter ?>)"></td>
                                        <td><span id="total_cost_label_<?= $row_counter ?>"></span></td>
                                        <td>
                                            <span onclick="hide_row(<?= $row_counter ?>)" style="margin-left: 10px; color: red; cursor: pointer; font-weight: bold;" id="cross_<?= $row_counter ?>"><?= (($row_counter == $default_row_counter)?'':'') ?></span>
                                            <span onclick="display_row(<?= $row_counter+1 ?>)" style="margin-left: 10px; color: green; cursor: pointer; font-weight: bold;" id="add_row_<?= $row_counter ?>"><i class="fa fa-plus-circle"></i></span>
                                        </td>
                                    </tr>
                                <?php endfor; ?>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <input value="<?= $default_row_counter+1 ?>" type="hidden" id="pannel_count" name="pannel_count">
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
                            <button name="save_credit_purchase" class="btn btn-success" style="font-size: 20px;"><i class="fa fa-save" style="color: white;"></i> Save Invoice</button>
                        </div>
                    </div>

                </div>
            </form>

            <div class="row" style="margin-top: 20px;">
                <?php
                include_once(APPPATH."views/purchases/components/few_purchases.php");
                ?>
            </div>
        </div>



    </div>

</div>
<script>
    var $productSelect = $(".product_select_box");
    var $supplierSelect = $(".suppliers_select_box");
    $productSelect.on("select2:select", function (e) {
        product_changed(e);
    });
    $supplierSelect.on("select2:select", function (e) {
        supplier_changed(e);
    });
</script>