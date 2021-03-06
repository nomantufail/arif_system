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
<h3 style="text-align: center;">Daybook <?= Carbon::now()->toFormattedDateString() ?></h3>
<table class="my_table list_table table table-bordered">
<thead>
<tr class="table_header_row">
    <th colspan="9" style="text-align: center; font-size: 18px;">
        Purchases
    </th>
</tr>
<tr class="">
    <th>Invoice#</th>
    <th>Date</th>
    <th>Supplier</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Cost / Item</th>
    <th>Total Cost</th>
    <th>Debit</th>
    <th>Credit</th>
</tr>
</thead>
<tbody>
<?php
$total_product_quantity = 0;
$total_credit = 0;
$total_debit = 0;
?>
<?php $parent_count = 0; ?>
<?php  foreach($purchases as $record): ?>
    <?php
    $count = 0;
    $num_invoice_items = sizeof($record->entries);
    ?>
    <?php foreach($record->entries as $entry): ?>
        <?php
        $count++;
        $parent_count++;
        ?>

        <tr style="<?= (($count == 1)?"border-top:2px solid lightgray":"") ?>;">
            <?php if($count == 1){echo "<td rowspan=".($num_invoice_items)." style=''>".$record->id."</td>";} ?>
            <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".Carbon::createFromFormat('Y-m-d',$record->date)->toFormattedDateString()."</td>";} ?>

            <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->supplier->name."</td>";} ?>

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
                echo rupee_format($entry->costPerItem);
                ?>
            </td>
            <td>
                <?php
                echo rupee_format($entry->total_cost());
                ?>
            </td>

            <?php if($count == 1):?>
                <td rowspan="<?=($num_invoice_items)?>">

                </td>
            <?php endif; ?>
            <?php if($count == 1):?>
                <td rowspan="<?=($num_invoice_items)?>" style="vertical-align: middle;">
                    <?php
                    $total_credit += $record->grand_total_purchase_price();
                    echo rupee_format($record->grand_total_purchase_price());
                    ?>
                </td>
            <?php endif; ?>

        </tr>
    <?php endforeach ?>
<?php endforeach; ?>
<tr>
    <th colspan="7" style='text-align:right;'>Totals</th>
    <th style="background-color: lightblue;"><?= rupee_format($total_debit) ?></th>
    <th style="background-color: lightblue;"><?= rupee_format($total_credit) ?></th>
</tr>
</tbody>

<thead>
<tr class="table_header_row">
    <th colspan="9" style="text-align: center; font-size: 18px;">
        Sales
    </th>
</tr>
<tr class="">
    <th>Invoice#</th>
    <th>Date</th>
    <th>Customer</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Price / Item</th>
    <th>Total Price</th>
    <th>Debit</th>
    <th>Credit</th>
</tr>
</thead>
<tbody>
<?php
$total_product_quantity = 0;
$total_cost = 0;
$total_debit = 0;
$total_credit = 0;
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

        <tr style="<?= (($count == 1)?"border-top:2px solid lightgray":"") ?>;">
            <?php if($count == 1){echo "<td rowspan=".($num_invoice_items)." style=''>".$record->id."</td>";} ?>
            <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".Carbon::createFromFormat('Y-m-d',$record->date)->toFormattedDateString()."</td>";} ?>

            <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->customer->name."</td>";} ?>

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

            <?php if($count == 1):?>
                <td rowspan="<?=($num_invoice_items)?>">
                    <?php
                    $total_debit += $record->grand_total_sale_price();
                    echo rupee_format($record->grand_total_sale_price());
                    ?>
                </td>
            <?php endif; ?>
            <?php if($count == 1):?>
                <td rowspan="<?=($num_invoice_items)?>" style="vertical-align: middle;">

                </td>
            <?php endif; ?>


        </tr>
    <?php endforeach ?>
<?php endforeach; ?>
<tr>
    <th colspan="7" style='text-align:right;'>Totals</th>
    <th class='total_amount'><?= rupee_format($total_debit) ?></th>
    <th class='total_amount'><?= rupee_format($total_credit) ?></th>
</tr>
</tbody>

<thead>
<tr class="table_header_row">
    <th colspan="9" style="text-align: center; font-size: 18px;">
        Receipts
    </th>
</tr>
<tr>
    <th>Voucher#</th>
    <th>Date</th>
    <th>Customer</th>
    <th colspan="4">Bank</th>
    <th>Debit</th>
    <th>Credit</th>
</tr>
</thead>
<tbody>
<?php
$total_product_quantity = 0;
$total_cost = 0;
$total_credit = 0;
$total_debit = 0;
?>
<?php $parent_count = 0; ?>
<?php  foreach($receipts as $record): ?>

    <tr style="">

        <td>
            <?php
            echo $record->voucher_id;
            ?>
        </td>

        <td>
            <?php
            echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
            ?>
        </td>
        <td>
            <?php
            $customer = $record->related_customer;
            echo $customer;
            ?>
        </td>
        <td colspan="4">
            <?php
            $bank = $record->bank_ac;
            echo $bank;
            ?>
        </td>
        <td>

        </td>
        <td>
            <?php
            $amount = $record->amount;
            $total_credit += $amount;
            echo rupee_format($amount);
            ?>
        </td>

    </tr>
<?php endforeach; ?>
</tr>
<tr>
    <th colspan="7" style='text-align:right;'>Totals</th>
    <th class='total_amount'><?= rupee_format($total_debit) ?></th>
    <th class='total_amount'><?= rupee_format($total_credit) ?></th>
</tr>
</tbody>

<thead>
<tr class="table_header_row">
    <th colspan="9" style="text-align: center; font-size: 18px;">
        Payments
    </th>
</tr>
<tr>
    <th>Voucher#</th>
    <th>Date</th>
    <th>Supplier</th>
    <th colspan="4">Bank</th>
    <th>Debit</th>
    <th>Credit</th>
</tr>
</thead>
<tbody>
<?php
$total_product_quantity = 0;
$total_cost = 0;
$total_credit = 0;
$total_debit = 0;
?>
<?php $parent_count = 0; ?>
<?php  foreach($payments as $record): ?>

    <tr style="">

        <td>
            <?php
            echo $record->voucher_id;
            ?>
        </td>

        <td>
            <?php
            echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
            ?>
        </td>
        <td>
            <?php
            $supplier = $record->related_supplier;
            echo $supplier;
            ?>
        </td>
        <td colspan="4">
            <?php
            $bank = $record->bank_ac;
            echo $bank;
            ?>
        </td>
        <td>
            <?php
            $amount = $record->amount;
            $total_debit += $amount;
            echo rupee_format($amount);
            ?>
        </td>
        <td>
            <?php

            ?>
        </td>

    </tr>
<?php endforeach; ?>
<tr>
    <th colspan="7" style='text-align:right;'>Totals</th>
    <th class='total_amount'><?= rupee_format($total_debit) ?></th>
    <th class='total_amount'><?= rupee_format($total_credit) ?></th>
</tr>
</tbody>

<thead>
<tr class="table_header_row">
    <th colspan="9" style="text-align: center; font-size: 18px;">
        Expenses
    </th>
</tr>
<tr>
    <th>Voucher#</th>
    <th>Date</th>
    <th>Tanker</th>
    <th colspan="4">Title</th>
    <th>Debit</th>
    <th>Credit</th>
</tr>
</thead>
<tbody>

<?php
$total_credit = 0;
$total_debit = 0;
?>
<?php $parent_count = 0; ?>
<?php  foreach($expenses as $record): ?>

    <tr style="">

        <td>
            <?php
            echo $record->invoice_id;
            ?>
        </td>

        <td>
            <?php
            echo Carbon::createFromFormat('Y-m-d',$record->expense_date)->toFormattedDateString();
            ?>
        </td>
        <td>
            <?php
            echo $record->tanker;
            ?>
        </td>
        <td colspan="4">
            <?php
            echo $record->expense_title;
            ?>
        </td>
        <td>
            <?php
            $total_debit += $record->amount;
            echo rupee_format($record->amount);
            ?>
        </td>
        <td>

        </td>

    </tr>
<?php endforeach; ?>
<tr>
    <th colspan="7" style='text-align:right;'>Totals</th>
    <th class='total_amount'><?= rupee_format($total_debit) ?></th>
    <th class='total_amount'><?= rupee_format($total_credit) ?></th>
</tr>
</tbody>


<thead>
<tr class="table_header_row">
    <th colspan="9" style="text-align: center; font-size: 18px;">
        Withdrawls
    </th>
</tr>
<tr>
    <th>Voucher#</th>
    <th>Date</th>
    <th colspan="2">Bank a/c</th>
    <th colspan="3">Withdraw A/c</th>
    <th>Debit</th>
    <th>Credit</th>
</tr>
</thead>
<tbody>

<?php
$total_credit = 0;
$total_debit = 0;
?>
<?php $parent_count = 0; ?>
<?php  foreach($withdrawls as $record): ?>

    <tr style="">

        <td>
            <?php
            echo $record->voucher_id;
            ?>
        </td>

        <td>
            <?php
            echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
            ?>
        </td>
        <td colspan="2">
            <?php
            echo $record->bank_ac;
            ?>
        </td>
        <td colspan="3">
            <?php
            echo $record->withdraw_account;
            ?>
        </td>
        <td>
            <?php
            $total_debit += $record->amount;
            echo rupee_format($record->amount);
            ?>
        </td>
        <td></td>

    </tr>
<?php endforeach; ?>
<tr>
    <th colspan="7" style='text-align:right;'>Totals</th>
    <th class='total_amount'><?= rupee_format($total_debit) ?></th>
    <th class='total_amount'><?= rupee_format($total_credit) ?></th>
</tr>
</tbody>


</table>