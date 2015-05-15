<!DOCTYPE html><html><head>    <meta charset="UTF-8">    <title><?= $title; ?></title>    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>    <!-- Bootstrap 3.3.2 -->    <?php    include_once("headerStuff.php");    ?>    <script>        function export_script()        {            var action = document.getElementById("selection_form").action;            var new_action = action.replace("print","&export");            var new_action = new_action.replace("?print","?export");            document.getElementById("selection_form").action = new_action;            document.getElementById("selection_form").submit();        }        function print_script()        {            var action = document.getElementById("selection_form").action;            var new_action = action.replace("&export","&print");            var new_action = new_action.replace("?export","?print");            document.getElementById("selection_form").action = new_action;            document.getElementById("selection_form").submit();        }    </script></head><body class="skin-blue"><div id="wrapper"><header class="main-header">    <a href="<?= base_url().""; ?>" class="logo">Inventory System</a>    <!-- Header Navbar: style can be found in header.less -->    <nav class="navbar navbar-static-top" role="navigation">        <!-- Sidebar toggle button-->        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">            <span class="sr-only">Toggle navigation</span>            <span class="icon-bar"></span>            <span class="icon-bar"></span>            <span class="icon-bar"></span>        </a>        <div class="navbar-custom-menu">            <ul class="nav navbar-nav">                <!-- Messages: style can be found in dropdown.less-->                <li class="dropdown">                    <a target="" onclick="print_script();" href="<?php                    /*if(strpos($this->helper_model->page_url(),'?') == false){                        echo $this->helper_model->page_url()."?";                    }else{echo $this->helper_model->page_url()."&";}*/                    ?>#" ><i class="fa fa-print"></i></a>                </li>                <li class="dropdown">                    <a target="" onclick="export_script();" href="<?php                    ?>#" ><i class="fa fa-file-excel-o"></i></a>                </li>                <li class="dropdown">                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> User <b class="caret"></b></a>                    <ul class="dropdown-menu">                        <li>                            <a href="<?= base_url()."settings/" ?>"><i class="fa fa-fw fa-gear"></i> Settings</a>                        </li>                        <li class="divider"></li>                        <li>                            <a href="<?= base_url()."logout.html"; ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>                        </li>                    </ul>                </li>            </ul>        </div>    </nav></header><!-- Left side column. contains the logo and sidebar --><aside class="main-sidebar">    <!-- sidebar: style can be found in sidebar.less -->    <section class="sidebar">        <!-- sidebar menu: : style can be found in sidebar.less -->        <ul class="sidebar-menu">            <li class="header">MAIN NAVIGATION</li>            <li class="<?php if($this->uri->segment(1) == 'admin' || $this->uri->segment(1) == ''){echo "active";} ?>">                <a href="<?= base_url().""; ?>"><i class="fa fa-fw fa-home"></i> Home</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'customers'){echo "active";} ?>">                <a href="<?= base_url()."customers/"; ?>"><i class="fa fa-fw fa-users"></i> Customers</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'suppliers'){echo "active";} ?>">                <a href="<?= base_url()."suppliers/"; ?>"><i class="fa fa-fw fa-users"></i> Suppliers</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'products'){echo "active";} ?>">                <a href="<?= base_url()."products"; ?>"><i class="fa fa-fw fa-cubes"></i> Products</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'tankers'){echo "active";} ?>">                <a href="<?= base_url()."tankers"; ?>"><i class="fa fa-fw fa-truck"></i> Tankers</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'purchases'){echo "active";} ?>">                <a href="<?= base_url()."purchases"; ?>"><i class="fa fa-fw fa-shopping-cart"></i> Purchases</a>            </li>            <li class="treeview <?php if($this->uri->segment(1) == 'sales'){echo "active";} ?>">                <a href="#">                    <i class="fa fa-rupee"></i> <span>Sales</span>                    <i class="fa fa-angle-left pull-right"></i>                </a>                <ul class="treeview-menu">                    <li class="<?php if($this->uri->segment(2) == 'add_product_sale' || $this->uri->segment(2) == 'product_sale_history'){echo "active";} ?>">                        <a style="<?php if($this->uri->segment(2) == 'add_product_sale'){echo "color:white;";} ?>" href="<?= base_url()."sales/add_product_sale"; ?>"><i class="fa fa-fw fa-arrow-right"> </i> Product Sale</a>                    </li>                    <li class="<?php if($this->uri->segment(2) == 'add_product_with_freight' || $this->uri->segment(2) == 'product_with_freight_history'){echo "active";} ?>">                       <a style="<?php if($this->uri->segment(2) == 'add_product_with_freight'){echo "color:white;";} ?>" href="<?= base_url()."sales/add_product_with_freight"; ?>"><i class="fa fa-fw fa-arrow-right"> </i> Product & Freight</a>                    </li>                    <li class="<?php if($this->uri->segment(2) == 'add_only_freight' || $this->uri->segment(2) == 'only_freight_history'){echo "active";} ?>">                        <a style="<?php if($this->uri->segment(2) == 'add_only_freight'){echo "color:white;";} ?>" href="#"><i class="fa fa-fw fa-arrow-right"> </i> Freight Sale</a>                    </li>                </ul>            </li>            <li class="<?php if($this->uri->segment(1) == 'source_destination'){echo "active";} ?>">                <a href="<?= base_url()."source_destination/"; ?>"><i class="fa fa-fw fa-circle-o"></i> Source / Destination</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'stock'){echo "active";} ?>">                <a href="<?= base_url()."stock"; ?>"><i class="fa fa-fw fa-cubes"></i> Stock</a>            </li>            <li class="treeview <?php if($this->uri->segment(1) == 'payments' || $this->uri->segment(1) == 'receipts'){echo "active";} ?>">                <a href="#">                    <i class="fa fa-file-o"></i> <span>Payments / Receipts</span>                    <i class="fa fa-angle-left pull-right"></i>                </a>                <ul class="treeview-menu">                    <li>                        <a style="font-size:; <?php if($this->uri->segment(1) == 'payments'){echo "color:white;";} ?>" " href="<?= base_url()."payments/"; ?>"><i class="fa fa-fw fa-file-o"></i> Payments</a>                    </li>                    <li class="">                        <a style="<?php if($this->uri->segment(1) == 'receipts'){echo "color:white;";} ?>" href="<?= base_url()."receipts/"; ?>"><i class="fa fa-fw fa-file-o"></i> Receipts</a>                    </li>                </ul>            </li>            <li class="treeview <?php if($this->uri->segment(1) == 'expenses'){echo "active";} ?>">                <a href="#">                    <i class="fa fa-file-o"></i> <span>Expenses</span>                    <i class="fa fa-angle-left pull-right"></i>                </a>                <ul class="treeview-menu">                    <li>                        <a  style="<?php if($this->uri->segment(2) == 'add'){echo "color:white;";} ?>" href="<?= base_url()."expenses/add"; ?>"><i class="fa fa-fw fa-plus-circle"> </i> Add</a>                    </li>                    <li>                        <a style="<?php if($this->uri->segment(2) == 'show'){echo "color:white;";} ?>" href="<?= base_url()."expenses/show"; ?>"><i class="fa fa-fw fa-eye"> </i> Show</a>                    </li>                    <li>                        <a style="<?php if($this->uri->segment(2) == 'add_payment'){echo "color:white;";} ?>" href="<?= base_url()."expenses/add_payment"; ?>"><i class="fa fa-fw fa-dollar"> </i> Payments</a>                    </li>                    <li>                        <a style="<?php if($this->uri->segment(2) == 'titles'){echo "color:white;";} ?>" href="<?= base_url()."expenses/titles"; ?>"><i class="fa fa-fw fa-file-o"> </i> Titles</a>                    </li>                </ul>            </li>            <li class="treeview <?php if($this->uri->segment(1) == 'withdrawls'){echo "active";} ?>">                <a href="#">                    <i class="fa fa-file-o"></i> <span>Withdrawls</span>                    <i class="fa fa-angle-left pull-right"></i>                </a>                <ul class="treeview-menu">                    <li>                        <a style="<?php if($this->uri->segment(2) == 'withdraw'){echo "color:white;";} ?>" href="<?= base_url()."withdrawls/withdraw"; ?>"><i class="fa fa-fw fa-plus-circle"> </i> Withdraw</a>                    </li>                    <li>                        <a style="<?php if($this->uri->segment(2) == 'history'){echo "color:white;";} ?>" href="<?= base_url()."withdrawls/history"; ?>"><i class="fa fa-fw fa-eye"> </i> History</a>                    </li>                    <li>                        <a style="<?php if($this->uri->segment(2) == 'accounts'){echo "color:white;";} ?>" href="<?= base_url()."withdrawls/accounts"; ?>"><i class="fa fa-fw fa-file-o"> </i> Accounts</a>                    </li>                </ul>            </li>            <li class="<?php if($this->uri->segment(1) == 'accounts'){echo "active";} ?>">                <a href="<?= base_url()."accounts/"; ?>"><i class="fa fa-fw fa-file-o"> </i> Accounts</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'ledgers'){echo "active";} ?>">                <a href="<?= base_url()."ledgers/"; ?>"><i class="fa fa-fw fa-file-o"> </i> Ledgers</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'reports'){echo "active";} ?>">                <a href="<?= base_url()."reports/"; ?>"><i class="fa fa-fw fa-file-text-o"></i> Reports</a>            </li>            <li class="<?php if($this->uri->segment(1) == 'daybook'){echo "active";} ?>">                <a href="<?= base_url()."daybook/"; ?>"><i class="fa fa-fw fa-book"></i> Day Book</a>            </li>        </ul>    </section>    <!-- /.sidebar --></aside><!-- Content Wrapper. Contains page content --><div class="content-wrapper">