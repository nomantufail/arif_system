<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 6/8/15
 * Time: 9:16 AM
 */
?>
<?php
include_once(APPPATH."views/prints/components/libs.php");
?>
<h3>Stock History</h3>
<?php
$available_stock = $opening_stock;
?>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr>
        <td colspan="11" style="text-align: right;">Opening Stock: <?= $opening_stock ?></td>
    </tr>
    <tr class="table_row table_header_row">
        <th>Date</th>
        <th>Product</th>
        <th>Tanker</th>
        <th>Agent</th>
        <th>In</th>
        <th>Out</th>
        <th>Available</th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_in = 0;
    $total_out = 0;
    ?>

    <?php  foreach($history as $record): ?>
        <tr>
            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                echo $record->product;
                ?>
            </td>
            <td>
                <?php
                echo $record->tanker;
                ?>
            </td>
            <td>
                <?php
                echo $record->agent;
                ?>
            </td>
            <td>
                <?php
                echo $record->s_in;
                $total_in += $record->s_in;
                ?>
            </td>
            <td>
                <?php
                echo $record->s_out;
                $total_out += $record->s_out;
                ?>
            </td>
            <td>
                <?php
                $available_stock = ($available_stock + ($record->s_in - $record->s_out));
                echo $available_stock;
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">
        <th colspan="4">Totals</th>
        <th class="total_amount"><?= $total_in ?></th>
        <th class="total_amount"><?= $total_out ?></th>
        <th></th>
    </tr>
    </tfoot>
</table>
