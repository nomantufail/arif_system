<?php    $link_extension = "";    if(isset($link)){        $link_extension = $link;    }?><!--<div style="position: fixed; margin: auto; bottom: 0px; right: 0; width: 200px; z-index: 1;">    <ul id="myTab" class="nav nav-pills page-header">        <li class="active"><a href="<?/*= base_url()."trips/make/".$link_extension */?>">Make New Trip</a></li>    </ul></div>--><div class="row col-lg-12 text-left" style="color: gray; font-size: 12px; height: 35px; line-height: 25px;">This product is powered by zeenomlabs (2012 - <?= date("Y") ?>)</div><script>    $(".select_box").select2();</script><script src="<?= js()?>myjquery.js"></script><script src="<?= js()?>myjs.js"></script><script src="<?= js()?>virik.js"></script><!-- Bootstrap Core JavaScript --><!-- Morris Charts JavaScript --><script src="<?= js()?>plugins/morris/raphael.min.js"></script><script src="<?= js()?>plugins/morris/morris.min.js"></script><script src="<?= js()?>plugins/morris/morris-data.js"></script><script src="<?= js()?>bootstrap-datepicker.js"></script><script src="<?= js()?>sorttable.js"></script></div></body></html>