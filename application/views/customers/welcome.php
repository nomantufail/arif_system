<style>    .insert_table td input{        width: 100%;    }    .insert_table td select{        width: 100%;        height: 25px;    }    .insert_table button    {        width: 100%;    }    .insert_table .lable{    }</style><div class="row page_heading_container">    <div class="col-lg-12">        <section class="col-md-6">            <h3 class="">                Customers <small><?= '' ?></small>            </h3>        </section>    </div></div><div id="page-wrapper" class="whole_page_container">    <div class="container-fluid">        <!---------Nav_Bar-------->        <div class="row">            <?php            //include_once(APPPATH."views/customers/components/types_nav.php");            ?>        </div>        <!------------------->        <!--Notifications Area-->        <div class="row">            <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                            <strong>Error! </strong>', '</div>'); ?>        </div>        <!--notifications area ends-->        <div class="row actual_body_contents">            <div class="row" style="background-color: ;">                <div class="col-lg-12">                    <form method="post">                        <table style="width: 100%;" class="insert_table">                            <td>                                <label>Name:</label><br>                                <input type="text" maxlength="30" name="name">                            </td>                            <td>                                <label>Phone:</label><br>                                <input type="text" maxlength="30" name="phone">                            </td>                            <td>                                <label>Address:</label><br>                                <input type="text" maxlength="100" name="address">                            </td>                            <td style="width: 10%;">                                <label></label>                                <button name="addCustomer" style="margin-top: 5px;"><i class="fa fa-plus-circle"> </i> Add</button>                            </td>                        </table>                    </form>                </div>            </div>            <div class="row">                <div class="col-lg-12">                    <table class="my_table list_table table table-bordered">                        <thead class="table_header">                        <tr class="table_row table_header_row">                            <th class="column_heading">ID</th>                            <th class="column_heading">Name</th>                            <th class="column_heading">Phone</th>                            <th class="column_heading">Address</th>                            <th></th>                        </tr>                        </thead>                        <tbody class="table_body">                        <?php foreach($customers as $customer):?>                            <tr class="table_row table_body_row">                                <td class="table_td"><?= ucwords($customer->id)?></td>                                <td class="table_td">                                    <?php                                    $properties = array(                                        'class'=>'x-editable',                                        'id'=>'name',                                        'data-type'=>'text',                                        'data-pk'=>$customer->name,                                        'data-url'=> base_url().'editing/edit_record_in_multiple_tables/customer/required|xss_clean|is_unique[customers.name]',                                        'data-title'=>"Change Customer Name",                                    );                                    echo anchor('#',ucwords($customer->name), $properties);                                    ?>                                </td>                                <td class="table_td">                                    <?php                                    $properties = array(                                        'class'=>'x-editable',                                        'id'=>'phone',                                        'data-type'=>'text',                                        'data-pk'=>$customer->id,                                        'data-url'=> base_url().'editing/edit_global_record/customers/required|xss_clean',                                        'data-title'=>"Change Customer Phone",                                    );                                    echo anchor('#',ucwords($customer->phone), $properties);                                    ?>                                </td>                                <td class="table_td">                                    <?php                                    $properties = array(                                        'class'=>'x-editable',                                        'id'=>'address',                                        'data-type'=>'text',                                        'data-pk'=>$customer->id,                                        'data-url'=> base_url().'editing/edit_global_record/customers/required|xss_clean',                                        'data-title'=>"Change Customer Address",                                    );                                    echo anchor('#',$customer->address, $properties);                                    ?>                                </td>                                <td>                                    <?php                                        deleting_btn('name',$customer->name, 'delete_customer');                                    ?>                                </td>                            </tr>                        <?php endforeach; ?>                        </tbody>                        <tfoot class="table_footer">                        <tr class="table_footer_row">                        </tr>                        </tfoot>                    </table>                </div>            </div>        </div>    </div></div>