<script>
    function add_row(row_num){
        var pannel_count = document.getElementById("pannel_count");
        var row_id = "row_"+row_num;

        pannel_count_value = parseInt(pannel_count.value);
        if(pannel_count_value == row_num)
        {

            /* here a row will be added dynamically */
            var newRowContent = "";
            newRowContent+='<tr id="row_'+row_num+'">';
            newRowContent+= '<td>';
            newRowContent+= '<select class="select_box product_select_box" style="width: 200px;" name="product_1" id="product_1">';
            newRowContent+= '<option value="">--Select--</option>';
            <?php
             $addable_products = '';
             foreach($products as $product){
             $addable_products.='<option value="<?= $product->name ?>"><?= $product->name ?></option>';
            }
            ?>
            newRowContent+='<?= $products ?>';
            newRowContent+='</select>';
            newRowContent+='</td>';

            newRowContent+='<td><input type="number" step="any" name="quantity_1" id="quantity_1" onchange="numbers_changed(1)" onkeyup="numbers_changed(1)"></td>';
            newRowContent+='<td><input type="number" step="any" name="costPerItem_1" id="costPerItem_1" onchange="numbers_changed(1)" onkeyup="numbers_changed(1)"></td>';
            newRowContent+='<td><span id="total_cost_label_1"></span></td>';
            newRowContent+='<td><span onclick="hide_row(1)" style="color: red; cursor: pointer; font-weight: bold;" id="cross_1"></span></td>';
            newRowContent+='</tr>';

            $(".products_table_body").append(newRowContent);
            /*----------------------------------------*/

            pannel_count.value = pannel_count_value+1;

            $("#product_"+row_num).select2('val','');
            place_cross(row_num);
            remove_cross(row_num-1);
        }

    }
</script>