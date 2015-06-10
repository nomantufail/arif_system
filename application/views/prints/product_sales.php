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

<h3 style="text-align: center;">Product Sale</h3>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th>Invoice#</th>
        <th>Date</th>
        <th>Customer</th>
        <th>Tanker</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Sale Price / Item</th>
        <th>Total Price</th>
        <th>Extra Info</th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_product_quantity = 0;
    $grand_total_cost = 0;
    ?>
    <?php $parent_count = 0; ?>
    <?php  foreach($sales as $record): ?>
        <?php
        $count = 0;
        $num_invoice_items = sizeof($record->entries);
        ?>
        <?php foreach($record->entries as $entry): ?>
            <?php
            $count++;
            $parent_count++;
            ?>

            <tr style="border-top: <?= ($count == 1)?'3':'0'; ?>px solid lightblue;">
                <?php if($count == 1){echo "<td rowspan=".($num_invoice_items)." style=''>".$record->id."</td>";} ?>
                <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".Carbon::createFromFormat('Y-m-d',$record->date)->toFormattedDateString()."</td>";} ?>

                <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->customer->name."</td>";} ?>
                <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->tanker."</td>";} ?>

                <td>
                    <?php
                    echo $entry->product->name;
                    ?>
                </td>

                <td>
                    <?php
                    $total_product_quantity += $entry->quantity;
                    echo $entry->quantity;
                    ?>
                </td>
                <td>
                    <?php
                    echo rupee_format($entry->salePricePerItem);
                    ?>
                </td>
                <td>
                    <?php
                    $grand_total_cost += $entry->total_cost();
                    echo rupee_format($entry->total_cost());
                    ?>
                </td>

                <?php if($count == 1):?>
                    <td rowspan="<?=($num_invoice_items)?>">
                        <?php
                        echo $record->summary_simplified();
                        ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach ?>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">
        <th style="text-align: right;" colspan="7">Totals</th>
        <th class="total_amount"><?= $grand_total_cost ?></th>
        <th colspan="1"></th>
    </tr>
    </tfoot>
</table>
