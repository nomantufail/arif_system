<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 7:18 AM
 */
?>
<style>
    table td{
        font-size: 11px;
    }
</style>
<script>
    $( document ).ready(function() {
        document.getElementById("body_content").style.display = 'block';
        document.getElementById("loading").style.display = 'none';
    });
</script>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">

            <?php
            include_once(APPPATH."views/receipts/components/nav_bar.php");
            ?>

        </div>
        <div class="row actual_body_contents">
                    <span class="loading" id="loading">
                        <h1>Loading...<br> Please wait</h1>
                    </span>
            <div class="row" style="background-color: ; margin-top: 10px;">
                <!-- Receipt Voucher -->
                <div class="col-md-12" id="body_content" style="border-left: 0px solid lightgray; display: none;">

                    <?php
                    include_once(APPPATH."views/receipts/components/receipt_history.php");
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>