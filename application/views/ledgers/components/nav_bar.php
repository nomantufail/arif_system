<div class="col-lg-12">
    <ul id="myTab" class="nav nav-pills" style="border-bottom: 0px solid;">
        <li class="<?php if($section == 'customers'){echo "active";} ?>">
            <a href="<?= base_url()."ledgers/customers" ?>"><i class="fa fa-fw fa-file-o"></i> Customers </a>
        </li>
        <li class="<?php if($section == 'suppliers'){echo "active";} ?>">
            <a href="<?= base_url()."ledgers/suppliers" ?>"><i class="fa fa-fw fa-file-o"></i> Suppliers </a>
        </li>
        <li class="<?php if($section == 'tankers'){echo "active";} ?>">
            <a href="<?= base_url()."ledgers/tankers" ?>"><i class="fa fa-fw fa-file-o"></i> Tankers </a>
        </li>
        <li class="<?php if($section == 'bank_accounts'){echo "active";} ?>">
            <a href="<?= base_url()."ledgers/bank_accounts" ?>"><i class="fa fa-fw fa-file-o"></i> Bank Accounts </a>
        </li>
        <li class="<?php if($section == 'withdrawls'){echo "active";} ?>">
            <a href="<?= base_url()."ledgers/withdrawls" ?>"><i class="fa fa-fw fa-file-o"></i> Withdrawls </a>
        </li>
    </ul>
</div>