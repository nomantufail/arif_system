<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 5/5/15
 * Time: 4:20 PM
 */
?>


<div id="page-wrapper" class="whole_page_container">
    <div class="container-fluid">
        <div class="row">

            <?php
            include_once(APPPATH."views/expenses/components/payment_nav_bar.php");
            ?>

        </div>
        <div class="row actual_body_contents">

            <div class="row" style="background-color: ; margin-top: 10px;">
                <!-- expense Voucher -->
                <div class="col-md-10" style="">
                    <?php
                    include_once(APPPATH."views/expenses/components/edit_expense_payment_form.php");
                    ?>
                </div>
            </div>

            <div class="row" style="background-color: ; margin-top: 10px;">
                <!-- Receipt Voucher -->
                <div class="col-md-10 " style="">
                    <?php
                    include_once(APPPATH."views/expenses/components/few_payments.php");
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>