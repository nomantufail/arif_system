<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/19/15
 * Time: 11:13 PM
 */
?>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Invoice#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Customer</th>
        <th class="column_heading">Tanker</th>
        <th class="column_heading">Product</th>
        <th class="column_heading">Qty</th>
        <th class="column_heading">Sale Price / Item</th>
        <th class="column_heading">Total Price</th>
        <th class="column_heading">Freight</th>
        <th class="column_heading">Extra Info</th>
        <th class="column_heading"></th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_product_quantity = 0;
    $total_cost = 0;
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
                <?php if($count == 1){echo "<td rowspan=".($num_invoice_items)." style=''><a target=_blank href='".base_url()."sales/edit_product_with_freight_sale/".$record->id."'>".$record->id."</a></td>";} ?>
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
                    echo rupee_format($entry->total_cost());
                    ?>
                </td>
                <td>
                    <?php
                    echo rupee_format($entry->freight);
                    ?>
                </td>

                <?php if($count == 1):?>
                    <td rowspan="<?=($num_invoice_items)?>">
                        <?php
                        echo $record->summary_simplified();
                        ?>
                    </td>
                <?php endif; ?>
                <?php if($count == 1):?>
                    <td rowspan="<?=($num_invoice_items)?>" style="vertical-align: middle;">
                        <?php deleting_btn_test(array(
                            'invoice_number'=>$record->id,
                            'item_id'=>$entry->item_id,
                        ), 'delete_freight_sale_invoice') ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach ?>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">

    </tr>
    </tfoot>
</table>
