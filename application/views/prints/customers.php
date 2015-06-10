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
<h3 style="text-align: center;">Customers</h3>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">ID</th>
        <th class="column_heading">Name</th>
        <th class="column_heading">Phone</th>
        <th class="column_heading">Address</th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php foreach($customers as $customer):?>
        <tr class="table_row table_body_row">
            <td class="table_td"><?= ucwords($customer->id)?></td>
            <td class="table_td">
                <?php
                echo $customer->name;
                ?>
            </td>
            <td class="table_td">
                <?php
                echo $customer->phone;
                ?>
            </td>
            <td class="table_td">
                <?php
                echo $customer->address
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>