<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/16/15
 * Time: 11:43 PM
 */
?>
<style>
    table td{
        font-size: 11px;
    }
    .col-md-6{
        margin: 0px !important;
    }
</style>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
       <div class="row actual_body_contents">
           <div class="row" style="">
               <!-- Sales -->
               <div class="col-md-6">
                   <?php
                   include_once(APPPATH."views/daybook/components/today_sales.php");
                   ?>
               </div>

               <!-- Purchases -->
               <div class="col-md-6">
                   <?php
                   include_once(APPPATH."views/daybook/components/today_purchases.php");
                   ?>
               </div>
           </div>
           <div class="row" style="">

               <!-- Receipts -->
               <div class="col-md-6">
                  <?php
                   include_once(APPPATH."views/daybook/components/today_receipts.php");
                   ?>
               </div>

               <!-- Payments -->
               <div class="col-md-6">
                   <?php
                   include_once(APPPATH."views/daybook/components/today_paid.php");
                   ?>
               </div>
           </div>
        </div>

    </div>

</div>