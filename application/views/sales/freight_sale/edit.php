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

            <?php if(sizeof($tankers) == 0){ ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    Warning: No tankers available for now. <br>
                </div>
            <?php } ?>
        </div>
        <!--notifications area ends-->
        <div class="row actual_body_contents" style="margin-top: 20px;">
            <h3 style="text-align: left; color: #2a6496;">Edit Sale Invoice# <?= $invoice->invoice_id ?></h3>
            <form method="post">

                <!-- hidden fields -->
                <input type="hidden" value="<?= $invoice->invoice_id ?>" name="invoice_id" required="required">

                <div class="row">
                    <div class="col-sm-12">
                        <table style="width: 70%;" class="">
                            <tr>
                                <td>
                                    <span><b>Tanker:</b></span><br>
                                    <select class="select_box tanker_select_box" name="tanker" id="tanker" style="min-width: 70px;">
                                        <?php foreach($tankers as $tanker):?>
                                            <option <?= (($invoice->tanker == $tanker->number)?"selected":"") ?> value="<?= $tanker->number ?>"><?= $tanker->number ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td>
                                    <span><b>Invoice Date:</b></span><br>
                                    <input class="form-control" value="<?= $invoice->date ?>" style="width: 200px; " type="date" name="invoice_date">

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
                                    <th style="width: 10%;">Source</th>
                                    <th style="width: 12%;">Destination</th>
                                    <th>Freight</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <select class="select_box product_select_box" style="width: 200px;" name="source" id="product_<?= $row_counter ?>">
                                            <?php foreach($cities as $city):?>
                                                <option value="<?= $city->name ?>" <?= (($city->name == $invoice->source)?"selected":"") ?> ><?= $city->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="select_box product_select_box" style="width: 200px;" name="destination" id="product_<?= $row_counter ?>">
                                            <?php foreach($cities as $city):?>
                                                <option value="<?= $city->name ?>" <?= (($city->name == $invoice->destination)?"selected":"") ?>><?= $city->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="any" name="freight_amount" required="required" value="<?= $invoice->freight ?>">
                                    </td>
                                </tr>

                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="margin:0px;">
                            <label class="" style="font-size: 18px;">Other Information:</label>
                            <textarea class="form-control" name="extra_info"><?= $invoice->summary ?></textarea>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-4" style="margin: 0px; float: right;">
                            <button name="edit_freight_sale" class="btn btn-success" style="font-size: 20px;"><i class="fa fa-save" style="color: white;"></i> Save Invoice</button>
                        </div>
                    </div>
                </div>
            </form>
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