<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 2:16 AM
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Account Titles</h3>
    </div>
    <div class="panel-body">
        <div class="list-group">

            <?php if(isset($_POST['addBankAc']) || isset($_GET['del_bank_ac'])): ?>
                <?php echo $this->helper_model->display_flash_errors(); ?>
                <?php echo $this->helper_model->display_flash_success(); ?>
            <?php endif; ?>

            <form method="post" action="<?= base_url()."settings/accounts"?>">
                <table class="search-table2" border="0" style=" width: 100%;">
                    <tr>
                        <td style=""><input style="width: 100%;" required="required" type="text" placeholder="new title here...." value="" name="title"></td>
                        <td style=""><input style="width: 100%;" required="required" type="text" placeholder="account#" value="" name="account_number"></td>
                        <td style=""><input style="width: 100%;" required="required" type="text" placeholder="bank" value="" name="bank"></td>
                        <td style="">
                            <select name="type" style="width: 100%; height: 25px;">
                                <option value="current">Current</option>
                                <option value="saving">Saving</option>
                                <option value="online">Online</option>
                            </select>
                        </td>
                        <td style="width: 10%;"><input type="submit" name="addBankAc" value="Add Title" class="btn btn-success" style="border-radius: 0px;"></td>
                    </tr>
                </table>
            </form>
            <table class="table table-bordered table-hover table-striped" style="font-size:12px;">

                <thead style="border-top: 3px solid lightgray">
                <tr>
                    <th style="width: 10%">ID</th>
                    <th>Title</th>
                    <th>Account#</th>
                    <th>Bank</th>
                    <th>Type</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                //Showing otherAgents Data
                foreach($banks as $title){
                    ?>
                    <tr>
                        <td><?= $title->id; ?></td>
                        <td class="table_td">
                            <?php
                            $properties = array(
                                'class'=>'x-editable',
                                'id'=>'title',
                                'data-type'=>'text',
                                'data-pk'=>$title->id,
                                'data-url'=> base_url().'editing/edit_record_in_multiple_tables/bank_account/required|is_unique[user_bank_accounts.title]|xss_clean',
                                'data-title'=>"Change Account Title",
                            );
                            echo anchor('#',$title->title, $properties);
                            ?>

                        </td>
                        <td class="table_td">
                            <?php
                            $properties = array(
                                'class'=>'x-editable',
                                'id'=>'account_number',
                                'data-type'=>'text',
                                'data-pk'=>$title->id,
                                'data-url'=> base_url().'editing/edit_record_in_multiple_tables/bank_account/required|is_unique[user_bank_accounts.account_number]|xss_clean|min_length[4]|max_length[20]',
                                'data-title'=>"Change Account Number",
                            );
                            echo anchor('#',$title->account_number, $properties);
                            ?>

                        </td>
                        <td><?= $title->bank; ?></td>

                        <td>
                            <?php if($this->helper_model->is_editable_title($title->title)): ?>
                                <a href="#" id="account_type_<?= $title->id ?>" data-name="type" data-type="select" data-pk="<?= $title->id ?>" data-url="<?= base_url()."helper_controller/edit_record/account_titles/required" ?>" data-title="Title"><?= ucwords($title->type) ?></a>
                            <?php else:?>
                                <?= ucwords($title->type) ?>
                            <?php endif; ?>
                        </td>
                        <td></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>