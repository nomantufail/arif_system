<style>
    .insert_table td input{
        width: 100%;
    }
    .insert_table td select{
        width: 100%;
        height: 25px;
    }
    .insert_table button
    {
        width: 100%;
    }
    .insert_table .lable{

    }
</style>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once(APPPATH."views/stock/components/nav_bar.php");
            ?>
        </div>
        <!--Notifications Area-->
        <div class="row">
            <?php echo $this->helper_model->display_flash_errors(); ?>
            <?php echo $this->helper_model->display_flash_success(); ?>
        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents">

            <div class="row">

                <div class="col-lg-12">
                    <form action="" method="get">
                        <table class="search-table" style="width:100%;">
                            <tr>
                                <td style="width: 15%;"><b>From: </b><input class="form-control" type="date" value="<?= $search_keys['from'] ?>" name="from"></td>
                                <td style="width: 15%;"><b>To: </b><input class="form-control" type="date" value="<?= $search_keys['to'] ?>" name="to"></td>
                                <td style="width: 20%;"><b>Product: </b>
                                    <select name="product" class="select_box" style="width: 100%;">
                                        <option value=""> -- All Products --</option>
                                        <?php foreach($products as $product):?>
                                            <?php
                                            $selected = (strtolower($product->name) == strtolower($search_keys['product']))?'selected':'';
                                            if($search_keys['product'] == ''){
                                                if(strtolower($product->name) == 'hsd')
                                                    $selected = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $product->name ?>" <?= $selected ?>><?= $product->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="width: 20%;"><b>Tanker: </b>
                                    <select name="tanker" class="select_box" style="width: 100%;">
                                        <option value=""> -- All Tankers --</option>
                                        <?php foreach($tankers as $tanker):?>
                                            <?php
                                            $selected = (strtolower($tanker->number) == strtolower($search_keys['tanker']))?'selected':'';
                                            if($search_keys['tanker'] == ''){
                                                if(strtolower($tanker->number) == '00000')
                                                    $selected = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $tanker->number ?>" <?= $selected ?>><?= $tanker->number ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="width: 25%;"><br><button style="width: 100%; height: 30px;"><i class="fa fa-search"></i> Search</button></td>
                            </tr>
                        </table>
                    </form>

                    <!--      Print Form          -->
                    <?= print_form(); ?>
                    <!-- print form ends    -->

                    <?php
                        $available_stock = $opening_stock;
                    ?>

                    <table class="my_table list_table table table-bordered">
                        <thead class="table_header">
                        <tr>
                            <td colspan="11" style="text-align: right;">Opening Stock: <?= $opening_stock ?></td>
                        </tr>
                        <tr class="table_row table_header_row">
                            <th>Date</th>
                            <th>Product</th>
                            <th>Tanker</th>
                            <th>Agent</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Available</th>
                        </tr>
                        </thead>
                        <tbody class="table_body">
                        <?php
                        $total_in = 0;
                        $total_out = 0;
                        ?>

                        <?php  foreach($history as $record): ?>
                            <tr>
                                <td>
                                    <?php
                                        echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->product;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->tanker;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->agent;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->s_in;
                                        $total_in += $record->s_in;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->s_out;
                                        $total_out += $record->s_out;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $available_stock = ($available_stock + ($record->s_in - $record->s_out));
                                    echo $available_stock;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table_footer">
                        <tr class="table_footer_row">
                            <th colspan="4">Totals</th>
                            <th class="total_amount"><?= $total_in ?></th>
                            <th class="total_amount"><?= $total_out ?></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
        </div>



    </div>

</div>