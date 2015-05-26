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
            include_once(APPPATH."views/expenses/components/nav_bar.php");
            ?>

        </div>
        <div class="row actual_body_contents">


            <div class="row" style="background-color: ; margin-top: 10px;">

                <!-- Payment Voucher -->
                <div class="col-md-10" style="">
                    <?php
                    include_once(APPPATH."views/expenses/components/expense_history.php");
                    ?>
                </div>

            </div>
        </div>
    </div>

</div>