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
<div class="row page_heading_container">
    <div class="col-lg-12">
        <section class="col-md-6">
            <h3 class="">
                Withdraw History <small></small>
            </h3>
        </section>
    </div>
</div>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">

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
                                <td style="width: 20%;"><b>Bank a/c: </b><br>
                                    <select class="select_box bank_ac_select_box" style="width: 100%;" name="bank_ac[]" id="bank_ac" multiple>
                                        <?php foreach($bank_accounts as $account):?>
                                            <?php
                                            $selected = (in_array(formatted_bank_account($account), $search_keys['bank_acs']))?'selected':''
                                            ?>
                                            <option value="<?= formatted_bank_account($account) ?>" <?= $selected ?>><?= formatted_bank_account($account) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="width: 20%;"><b>Wtithdraw a/c: </b><br>
                                    <select class="select_box bank_ac_select_box" style="width: 100%;" name="withdraw_account[]" id="bank_ac" multiple>
                                        <?php foreach($withdraw_accounts as $account):?>
                                            <?php
                                            $selected = (in_array($account->title, $search_keys['withdraw_accounts']))?'selected':''
                                            ?>
                                            <option value="<?= $account->title ?>" <?= $selected ?>><?= $account->title ?></option>
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

                    <table class="my_table list_table table table-bordered">
                        <thead class="table_header">
                        <tr class="table_row table_header_row">
                            <?= sortable_header('voucher_id','numeric','Invoice#') ?>
                            <?= sortable_header('voucher_date','date','Date') ?>
                            <?= sortable_header('bank', 'string', 'Bank A/c') ?>
                            <?= sortable_header('withdraw_account', 'string', 'Withdraw A/c') ?>
                            <?= sortable_header('amount', 'numeric', 'Amount') ?>
                            <?= sortable_header('summary', 'string', 'Summary') ?>
                            <th class="column_heading"></th>
                        </tr>
                        </thead>
                        <tbody class="table_body">
                        <?php
                        $total_cost = 0;
                        ?>
                        <?php $parent_count = 0; ?>
                        <?php  foreach($withdraw_history as $record): ?>

                            <tr style="">

                                <td>
                                    <a href="<?= base_url()."withdrawls/edit_withdrawl/".$record->voucher_id ?>"><?= $record->voucher_id ?></a>
                                </td>
                                <td>
                                    <?php
                                    echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->bank_ac;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->withdraw_account;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $total_cost += $record->amount;
                                    echo rupee_format($record->amount);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->summary;
                                    ?>
                                </td>
                                <td>
                                    <?php deleting_btn('voucher_id', $record->voucher_id, 'delete_voucher') ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table_footer">
                        <tr class="table_footer_row">
                            <th colspan="4" style="text-align: right;">Totals</th>
                            <th class="total_amount"><?= rupee_format($total_cost) ?></th>
                            <th colspan="2"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>



    </div>

</div>