<div class="col-lg-12">
    <ul id="myTab" class="nav nav-pills" style="border-bottom: 0px solid;">
        <li class="<?php if($section == 'customers'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."customers" ?>"><i class="fa fa-fw fa-file-o"></i> Customers </a>
        </li>
        <li class="<?php if($section == 'suppliers'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."suppliers" ?>"><i class="fa fa-fw fa-file-o"></i> Suppliers </a>
        </li>
        <li class="<?php if($section == 'tankers'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."tankers" ?>"><i class="fa fa-fw fa-file-o"></i> Tankers </a>
        </li>
        <li class="<?php if($section == 'bank_accounts'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."bank_accounts" ?>"><i class="fa fa-fw fa-file-o"></i> Bank Accounts </a>
        </li>
        <li class="<?php if($section == 'withdrawls'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."withdrawls" ?>"><i class="fa fa-fw fa-file-o"></i> Withdrawls </a>
        </li>
    </ul>
</div>