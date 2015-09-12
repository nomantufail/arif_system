<div class="col-lg-12">
    <ul id="myTab" class="nav nav-pills" style="border-bottom: 0px solid;">

        <li class="<?php if($this->uri->segment(2) == 'overview'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."overview" ?>"><i class="fa fa-fw fa-list"></i>Overview</a>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'history'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."history" ?>"><i class="fa fa-fw fa-history"></i>History</a>
        </li>
    </ul>
</div>