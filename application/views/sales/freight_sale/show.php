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
            include_once(APPPATH."views/sales/freight_sale/components/nav_bar.php");
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
                                <td style="width: 10%;"><b>From: </b><input class="form-control" type="date" value="<?= $search_keys['from'] ?>" name="from"></td>
                                <td style="width: 10%;"><b>To: </b><input class="form-control" type="date" value="<?= $search_keys['to'] ?>" name="to"></td>
                                <td style="width: 15%;"><b>Source: </b>
                                    <select name="sources[]" class="select_box" multiple>
                                        <option value=""> -- All Sources --</option>
                                        <?php foreach($cities as $city):?>
                                            <?php
                                            $selected = (in_array($city->name, $search_keys['sources']))?'selected':''
                                            ?>
                                            <option value="<?= $city->name ?>" <?= $selected ?>><?= $city->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="width: 15%;"><b>Destination: </b>
                                    <select name="destinations[]" class="select_box" multiple>
                                        <option value=""> -- All Destination --</option>
                                        <?php foreach($cities as $city):?>
                                            <?php
                                            $selected = (in_array($city->name, $search_keys['destinations']))?'selected':''
                                            ?>
                                            <option value="<?= $city->name ?>" <?= $selected ?>><?= $city->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td style="width: 10%;"><br><button style="width: 100%; height: 30px;"><i class="fa fa-search"></i> Search</button></td>
                            </tr>
                        </table>
                    </form>

                    <!--      Print Form          -->
                    <?= print_form(); ?>
                    <!-- print form ends    -->

                    <table class="my_table list_table table table-bordered">
                        <thead class="table_header">
                        <tr class="table_row table_header_row">
                            <?= sortable_header('invoice_id','numeric','Invoice#') ?>
                            <?= sortable_header('date','date','Date') ?>
                            <?= sortable_header('tanker', 'string', 'Tanker') ?>
                            <?= sortable_header('source', 'string', 'Source') ?>
                            <?= sortable_header('destination', 'string', 'destination') ?>
                            <?= sortable_header('freight', 'numeric', 'Freight') ?>
                            <?= sortable_header('extra_info', 'string', 'Extra Info') ?>
                            <th class="column_heading"></th>
                        </tr>
                        </thead>
                        <tbody class="table_body">
                        <?php
                        $total_product_quantity = 0;
                        $grand_total_cost = 0;
                        $total_freight = 0;
                        ?>
                        <?php
                            $parent_count = 0;
                            $count = 0;
                        ?>
                        <?php foreach($sales as $entry): ?>
                            <?php
                            $count++;
                            $parent_count++;
                            ?>

                            <tr style="border-top: <?= ($count == 1)?'3':'0'; ?>px solid lightblue;">
                                <td><a target=_blank href='<?= base_url()."sales/edit_freight_sale/".$entry->invoice_id."" ?>'><?= $entry->invoice_id ?></a></td>
                                <td><?= Carbon::createFromFormat('Y-m-d',$entry->date)->toFormattedDateString() ?></td>

                                <td><?= $entry->tanker ?></td>
                                <td>
                                    <?php
                                    echo $entry->source;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $entry->destination;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $total_freight += $entry->freight;
                                    echo rupee_format($entry->freight);
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo $entry->summary;
                                    ?>
                                </td>
                                <td style="vertical-align: middle;">
                                    <?php deleting_btn_test(array(
                                        'invoice_number'=>$entry->invoice_id,
                                        'item_id'=>$entry->entry_id,
                                    ), 'delete_route_sale_invoice') ?>
                                </td>

                            </tr>
                        <?php endforeach ?>
                        </tbody>
                        <tfoot class="table_footer">
                        <tr class="table_footer_row">
                            <th style="text-align: right;" colspan="5">Totals</th>
                            <th class="total_amount"><?= $total_freight ?></th>
                            <th colspan="2"></th>
                        </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
        </div>



    </div>

</div>