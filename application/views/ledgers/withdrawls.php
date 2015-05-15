<style>
    .search-table{
        font-size: 12px;
    }
    .search-table input{
        width:100%;
        height: 30px;
    }
    .search-table select{
        width:100%;
        height: 30px;
    }
    table{
        font-size: 12px;
    }
</style>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once(APPPATH."views/ledgers/components/nav_bar.php");
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

            <!--SEARCH AREA FOR CUSTOMER LEDGERS-->
            <div class="col-lg-12">
                <form action="" method="get">
                    <table class="search-table" style="width:100%;">
                        <tr>
                            <td style="width: 45%;"><b>Withdrawl Accounts: </b><br>
                                <select name="ac_title" class="select_box">
                                    <option value="">--All--</option>
                                    <?php foreach($withdrawl_accounts as $account): ?>
                                        <?php
                                        $selected = ($account->title == $ac_title)?'selected':'';
                                        ?>
                                        <option value="<?= $account->title ?>" <?= $selected ?>><?= ucwords($account->title) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td style="width: 25%;"><b>From: </b><input type="date" value="<?= $from ?>" name="from"></td>
                            <td style="width: 20%;"><b>To: </b><input type="date" value="<?= $to ?>" name="to"></td>
                            <td style=""><br><input type="submit" value="Generate" style="width: 100%;"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <!--search area ends here-->

            <div class="col-lg-12">
                <form name="selection_form" id="selection_form" method="post" action="<?php
                if(strpos($this->helper_model->page_url(),'?') == false){
                    echo $this->helper_model->page_url()."?";
                }else{echo $this->helper_model->page_url()."&";}
                ?>print">


                    <table class="my_table list_table table table-bordered" style="font-size:12px;">
                        <?php
                        $starting_balance = $opening_balance;
                        $searched_balance = 0;
                        ?>
                        <thead class="table_header">
                        <tr>
                            <td colspan="8" style="text-align: right;">Opening Balance: <?= (($opening_balance < 0)?"(".(rupee_format($opening_balance*-1)).")":rupee_format($opening_balance)) ?></td>
                        </tr>

                        <tr class="table_row table_header_row">
                           <th style="">Voucher#</th>
                            <th style="width: 10%">Date</th>
                            <th>Ac / Title</th>
                            <th>Summary</th>
                            <th style="width: 11%;">Debit</th>
                            <th style="width: 11%;">Credit</th>
                            <th style="width: 11%;">Searched Balance</th>
                            <th style="width: 11%;">Actual Balance</th>
                        </tr>
                        </thead>
                        <tbody class="table_body">
                        <?php
                        $total_balance = 0;
                        $total_debit = 0;
                        $total_credit = 0;
                        ?>

                        <?php  foreach($ledger as $record): ?>
                            <?php $debit_amount = ($record->dr_cr == 1)?$record->amount:0; ?>
                            <?php $credit_amount = ($record->dr_cr == 0)?$record->amount:0; ?>
                            <?php $total_debit += $debit_amount; ?>
                            <?php $total_credit += $credit_amount; ?>
                            <tr style="">
                                <td><?= $record->voucher_id ?></td>
                                <td>
                                    <?= $this->carbon->createFromFormat('Y-m-d', $record->voucher_date)->toFormattedDateString(); ?>
                                </td>
                                <td>
                                    <?= ucfirst($record->ac_title) ?>
                                </td>
                                <td>
                                    <?= ucfirst($record->summary) ?>
                                </td>
                                <td><?= (($record->dr_cr == 0)?'':$this->helper_model->money(round($record->amount, 3))); ?></td>
                                <td><?= (($record->dr_cr == 1)?'':$this->helper_model->money(round($record->amount, 3))); ?></td>
                                <td>
                                    <?php
                                    $searched_balance = (($debit_amount - $credit_amount) + $searched_balance);
                                    $searched_balance = round($searched_balance, 3);
                                    ?>
                                    <?= (($searched_balance < 0)?"(".($this->helper_model->money($searched_balance*-1)).")":$this->helper_model->money($searched_balance)) ?>
                                </td>
                                <td>
                                    <?php
                                    $starting_balance = (($debit_amount - $credit_amount) + $starting_balance);
                                    $starting_balance = round($starting_balance, 3);
                                    ?>
                                    <?= (($starting_balance < 0)?"(".($this->helper_model->money($starting_balance*-1)).")":$this->helper_model->money($starting_balance)) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table_footer">
                        <tr class="table_footer_row table_footer_row_totals">
                            <th colspan="4" style="text-align: right;">Totals:</th>
                            <th><?= $this->helper_model->money(round($total_debit, 3)) ?></th>
                            <th colspan=""><?= $this->helper_model->money(round($total_credit, 3)) ?></th>
                            <th></th><th></th>
                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>



    </div>

</div>