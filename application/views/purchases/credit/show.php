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
            include_once(APPPATH."views/purchases/components/nav_bar.php");
            ?>
        </div>
        <!--Notifications Area-->
        <div class="row">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">

                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                            <strong>Error! </strong>', '</div>'); ?>


        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents">

            <div class="row">

                <div class="col-lg-12">
                    <form action="" method="get">
                        <table class="search-table" style="width:100%;">
                            <tr>
                                <td style="width: 25%;"><b>From: </b><input class="form-control" type="date" value="<?= $from ?>" name="from"></td>
                                <td style="width: 25%;"><b>To: </b><input class="form-control" type="date" value="<?= $to ?>" name="to"></td>
                                <td style="width: 25%;"><b>Supplier: </b>
                                    <select name="supplier" class="select_box">
                                        <?php foreach($suppliers as $supplier):?>
                                            <option value="<?= $supplier->name ?>"><?= $supplier->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="width: 25%;"><br><button style="width: 100%; height: 30px;"><i class="fa fa-search"></i> Search</button></td>
                            </tr>
                        </table>
                    </form>

                    <table class="my_table list_table table table-bordered">
                        <thead class="table_header">
                        <tr class="table_row table_header_row">
                            <th class="column_heading">Invoice#</th>
                            <th class="column_heading">Date</th>
                            <th class="column_heading">Supplier</th>
                            <th class="column_heading">Tanker</th>
                            <th class="column_heading">Product</th>
                            <th class="column_heading">Qty</th>
                            <th class="column_heading">Cst / Item</th>
                            <th class="column_heading">Total Cst</th>
                            <th class="column_heading">Extra Info</th>
                            <th class="column_heading"></th>
                        </tr>
                        </thead>
                        <tbody class="table_body">
                        <?php
                        $total_product_quantity = 0;
                        $total_cost = 0;
                        $grand_total_cost = 0;
                        ?>
                        <?php $parent_count = 0; ?>
                        <?php  foreach($purchases as $record): ?>
                            <?php
                            $count = 0;
                            $num_invoice_items = sizeof($record->entries);
                            ?>
                            <?php foreach($record->entries as $entry): ?>
                                <?php
                                $count++;
                                $parent_count++;
                                ?>

                                <tr style="border-top: <?= ($count == 1)?'3':'0'; ?>px solid lightblue;">
                                    <?php if($count == 1){echo "<td rowspan=".($num_invoice_items)." style=''><a target=_blank href='#".$record->id."'>".$record->id."</a></td>";} ?>
                                    <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".Carbon::createFromFormat('Y-m-d',$record->date)->toFormattedDateString()."</td>";} ?>

                                    <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->supplier->name."</td>";} ?>
                                    <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->tanker."</td>";} ?>

                                    <td>
                                        <?php
                                        echo $entry->product->name;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $total_product_quantity += $entry->quantity;
                                        echo $entry->quantity;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo rupee_format($entry->costPerItem);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $total_cost = $entry->total_cost();
                                        $grand_total_cost += $total_cost;
                                        echo rupee_format($total_cost);
                                        ?>
                                    </td>

                                    <?php if($count == 1):?>
                                        <td rowspan="<?=($num_invoice_items)?>">
                                            <?php
                                            echo $record->summary_simplified();
                                            ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if($count == 1):?>
                                        <td rowspan="<?=($num_invoice_items)?>" style="vertical-align: middle;">

                                        </td>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach ?>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table_footer">
                        <tr class="table_footer_row">
                            <th style="text-align: right;" colspan="7">Totals</th>
                            <th class="total_amount"><?= $grand_total_cost ?></th>
                            <th colspan="2"></th>
                        </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
        </div>



    </div>

</div>