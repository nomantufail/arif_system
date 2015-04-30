    <!DOCTYPE html>    <html lang="en">    <head>        <meta charset="utf-8">        <meta http-equiv="X-UA-Compatible" content="IE=edge">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta name="description" content="">        <meta name="author" content="">                <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>        <meta http-equiv="pragma" content="no-cache" />        <title><?= $title; ?></title>        <?php        include("headerStuff.php");        ?>        <script>            function export_script()            {                var action = document.getElementById("selection_form").action;                var new_action = action.replace("print","&export");                var new_action = new_action.replace("?print","?export");                document.getElementById("selection_form").action = new_action;                document.getElementById("selection_form").submit();            }            function print_script()            {                var action = document.getElementById("selection_form").action;                var new_action = action.replace("&export","&print");                var new_action = new_action.replace("?export","?print");                document.getElementById("selection_form").action = new_action;                document.getElementById("selection_form").submit();            }        </script>    </head>    <body>    <div id="wrapper">        <!-- Navigation -->        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">            <!-- Brand and toggle get grouped for better mobile display -->            <div class="navbar-header">                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">                    <span class="sr-only">Toggle navigation</span>                    <span class="icon-bar"></span>                    <span class="icon-bar"></span>                    <span class="icon-bar"></span>                </button>                <a class="navbar-brand" href="<?= base_url().""; ?>">Inventory System</a>            </div>            <!-- Top Menu Items -->            <ul class="nav navbar-right top-nav">                <li class="dropdown">                    <a target="" onclick="print_script();" href="<?php                    /*if(strpos($this->helper_model->page_url(),'?') == false){                        echo $this->helper_model->page_url()."?";                    }else{echo $this->helper_model->page_url()."&";}*/                    ?>#" ><i class="fa fa-print"></i></a>                </li>                <li class="dropdown">                    <a target="" onclick="export_script();" href="<?php                    ?>#" ><i class="fa fa-file-excel-o"></i></a>                </li>                <li class="dropdown">                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>                </li>                <li class="dropdown">                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Test User <b class="caret"></b></a>                    <ul class="dropdown-menu">                        <li>                            <a href="<?= base_url()."settings/" ?>"><i class="fa fa-fw fa-gear"></i> Settings</a>                        </li>                        <li class="divider"></li>                        <li>                            <a href="<?= base_url()."logout.html"; ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>                        </li>                    </ul>                </li>            </ul>            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->            <div class="collapse navbar-collapse navbar-ex1-collapse">                <ul class="nav navbar-nav side-nav">                    <li class="<?php if($this->uri->segment(1) == 'admin' || $this->uri->segment(1) == ''){echo "active";} ?>">                        <a href="<?= base_url().""; ?>"><i class="fa fa-fw fa-home"></i> Home</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'customers'){echo "active";} ?>">                        <a href="<?= base_url()."customers/"; ?>"><i class="fa fa-fw fa-users"></i> Customers</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'suppliers'){echo "active";} ?>">                        <a href="<?= base_url()."suppliers/"; ?>"><i class="fa fa-fw fa-users"></i> Suppliers</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'products'){echo "active";} ?>">                        <a href="<?= base_url()."products"; ?>"><i class="fa fa-fw fa-cubes"></i> Products</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'tankers'){echo "active";} ?>">                        <a href="<?= base_url()."tankers"; ?>"><i class="fa fa-fw fa-truck"></i> Tankers</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'purchases'){echo "active";} ?>">                        <a href="<?= base_url()."purchases"; ?>"><i class="fa fa-fw fa-shopping-cart"></i> Purchases</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'sales'){echo "active";} ?>">                        <a href="<?= base_url()."sales"; ?>"><i class="fa fa-fw fa-rupee"></i> Sales</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'stock'){echo "active";} ?>">                        <a href="<?= base_url()."stock"; ?>"><i class="fa fa-fw fa-cubes"></i> Stock</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'payments'){echo "active";} ?>">                        <a href="<?= base_url()."payments/"; ?>"><i class="fa fa-fw fa-file-o"></i> Payments</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'receipts'){echo "active";} ?>">                        <a href="<?= base_url()."receipts/"; ?>"><i class="fa fa-fw fa-file-o"></i> Receipts</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'accounts'){echo "active";} ?>">                        <a href="<?= base_url()."accounts/"; ?>"><i class="fa fa-fw fa-file-o"></i> Accounts</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'reports'){echo "active";} ?>">                        <a href="<?= base_url()."reports/"; ?>"><i class="fa fa-fw fa-file-text-o"></i> Reports</a>                    </li>                    <li class="<?php if($this->uri->segment(1) == 'daybook'){echo "active";} ?>">                        <a href="<?= base_url()."daybook/"; ?>"><i class="fa fa-fw fa-book"></i> Day Book</a>                    </li>                </ul>            </div>        </nav>