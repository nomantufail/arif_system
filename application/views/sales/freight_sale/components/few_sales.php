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
        <?= th('Invoice#') ?>
        <?= th('Date') ?>
        <?= th('Tanker') ?>
        <?= th('Source') ?>
        <?= th('destination') ?>
        <?= th('Freight') ?>
        <?= th('Extra Info') ?>
        <?= th("") ?>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_product_quantity = 0;
    $grand_total_cost = 0;
    $total_freight = 0;
    ?>
    <?php
    $parent_count = 0;
    $count = 0;
    ?>
    <?php foreach($sales as $entry): ?>
        <?php
        $count++;
        $parent_count++;
        ?>

        <tr style="border-top: <?= ($count == 1)?'3':'0'; ?>px solid lightblue;">
            <td><a target=_blank href='<?= base_url()."sales/edit_freight_sale/".$entry->invoice_id."" ?>'><?= $entry->invoice_id ?></a></td>
            <td><?= Carbon::createFromFormat('Y-m-d',$entry->date)->toFormattedDateString() ?></td>
             <td><?= $entry->tanker ?></td>
            <td>
                <?php
                echo $entry->source;
                ?>
            </td>
            <td>
                <?php
                echo $entry->destination;
                ?>
            </td>
            <td>
                <?php
                $total_freight += $entry->freight;
                echo rupee_format($entry->freight);
                ?>
            </td>

            <td>
                <?php
                echo $entry->summary;
                ?>
            </td>
            <td style="vertical-align: middle;">
                <?php deleting_btn_test(array(
                    'invoice_number'=>$entry->invoice_id,
                    'item_id'=>$entry->entry_id,
                ), 'delete_route_sale_invoice') ?>
            </td>

        </tr>
    <?php endforeach ?>
    </tbody>
</table>