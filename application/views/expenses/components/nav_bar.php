<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/15/15
 * Time: 5:09 AM
 */
?>
<style>
    .payments_navbar li{
        float: left;
    }
</style>
<div class="col-lg-12 payments_navbar" style="border-bottom: 0px solid lightgray;">
    <ul id="myTab" class="nav nav-pills col-md-4">
        <li class="<?php if($section == 'add'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."add" ?>"><i class="fa fa-fw fa-plus-circle"></i>New</a>
        </li>

        <li class="<?php if($section == 'show'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."show" ?>"><i class="fa fa-fw fa-file-o"></i>History</a>
        </li>
    </ul>
</div>