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
    .ledger_area .row{
        margin-top: 10px;
    }
</style>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">

        <!--Notifications Area-->
        <div class="row">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">

                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                            <strong>Error! </strong>', '</div>'); ?>



        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents">
            <div class="col-md-6 ledger_area" style="min-height: 500px;">
                <h3 style="color: #204d74; text-align: center">Ledgers</h3>
                <hr>
                <div class="row">
                    <div class="col-md-3" style="font-weight: bold;">From: </div>
                    <div class="col-md-8"><input type="date" class="form-control"> </div>
                </div>
                <div class="row">
                    <div class="col-md-3" style="font-weight: bold;">To: </div>
                    <div class="col-md-8"><input type="date" class="form-control"> </div>
                </div>
                <div class="row">
                    <div class="col-md-3" style="font-weight: bold;">Agent: </div>
                    <div class="col-md-8">
                        <select class="select_box"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" style="font-weight: bold;">Account Title: </div>
                    <div class="col-md-8">
                        <select class="select_box"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" style="font-weight: bold;">Account Type: </div>
                    <div class="col-md-8">
                        <select class="select_box"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" style="font-weight: bold;"></div>
                    <div class="col-md-8">
                        <button class="btn btn-primary">Show Ledgers</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="background-color: rgba(0,0,0,0.02); min-height: 500px;">
                <h3 style="color: #204d74; text-align: center;">Custom Accounts</h3>
            </div>
        </div>



    </div>

</div>