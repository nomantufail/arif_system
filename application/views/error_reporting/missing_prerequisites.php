<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 6/15/15
 * Time: 11:04 PM
 */
?>


<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">

        <div class="row">
            <h3 style="text-align: center;">
                Dear User! There are some prerequisites for this section.
            </h3>
            <hr>
            <?php
            $errors = $this->helper_model->get_flash_errors();
            echo "<h4 style='color:red; text-align:center;'>".$errors."</h4>";
            ?>
        </div>

    </div>

</div>
