<?php
/*
 * this variable shows that how many rows will will be displayed by default
 * */
$default_row_counter = 2;
?>
<style>
    .invoice_entries_container{
        border: 0px solid lightgray;
        min-height: 200px;
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

            document.getElementById("grand_total_cost_label").innerHTML = grand_total_cost();
        }
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

        document.getElementById("total_cost_label_"+row_num).innerHTML = total_cost(row_num);
        document.getElementById("grand_total_cost_label").innerHTML = grand_total_cost();

    }
    function product_changed(e)
    {
        var id = e.params.data.element.parentElement.id;
        id = id.split("_");
        id = id[1];
        display_row(parseInt(id)+1);
        document.getElementById("grand_total_cost_label").innerHTML = grand_total_cost();
    }

    function place_cross(row_num)
    {
        document.getElementById('cross_'+row_num).innerHTML='X';
    }
    function remove_cross(row_num)
    {
        document.getElementById('cross_'+row_num).innerHTML='';
    }

</script>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once(APPPATH."views/accounts/components/nav_bar.php");
            ?>
        </div>

        <!--Notifications Area-->
        <div class="row">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">

                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                            <strong>Error! </strong>', '</div>'); ?>
            <?php if(is_array(@$someMessage)){ ?>
                <div class="alert <?= $someMessage['type']; ?> alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?= $someMessage['message']; ?>
                </div>
            <?php } ?>

        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents" style="background-color: rgba(0,0,0,0.03); margin-top: 20px;">
            <form method="post">
                <div class="row">
                    <h1 style="margin: 150px;">Under Development..</h1>
                </div>

            </form>
        </div>



    </div>

</div>
