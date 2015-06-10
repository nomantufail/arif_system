<style>
    .insert_table td input{
        width: 100%;
    }
    .insert_table td select{
        width: 100%;
        height: 25px;
    }
    .insert_table button
    {
        width: 100%;
    }
    .insert_table .lable{

    }
</style>
<div class="row page_heading_container">
    <div class="col-lg-12">
        <section class="col-md-6">
            <h3 class="">
                Home <small></small>
            </h3>
        </section>
    </div>
</div>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row actual_body_contents">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Business Status ( <?= Carbon::createFromFormat('Y-m-d',$from)->toFormattedDateString()." to ".Carbon::createFromFormat('Y-m-d',$to)->toFormattedDateString() ?> )</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th class="title">Total Purchases</th>
                                    <th class="amount"><?= rupee_format($total_purchases) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Sales</th>
                                    <th class="amount"><?= rupee_format($total_sales) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Payables</th>
                                    <th class="amount"><?= rupee_format($total_payables) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Receivables</th>
                                    <th class="amount"><?= rupee_format($total_receivables) ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Profit & Loss ( <?= Carbon::createFromFormat('Y-m-d',$from)->toFormattedDateString()." to ".Carbon::createFromFormat('Y-m-d',$to)->toFormattedDateString() ?> )</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th class="title">Total Sales</th>
                                    <th class="amount"><?= rupee_format($profit_loss['total_sale_price']) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Cost</th>
                                    <th class="amount"><?= rupee_format($profit_loss['total_purchase_price']) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Expenses</th>
                                    <th class="amount"><?= rupee_format($profit_loss['total_expense']) ?></th>
                                </tr>
                                <tr style="color: #2a6496;">
                                    <th class="" colspan="2">Profit/Loss: Sales - Purchases - Expenses</th>
                                </tr>
                                <tr>
                                    <th class="" colspan="2" style="text-align: center;">
                                        <?php
                                        $profit = $profit_loss['total_sale_price'] - $profit_loss['total_purchase_price'] - $profit_loss['total_expense'];
                                        ?>
                                        <h3 style="color: <?= (($profit < 0)?"red;":"green") ?>"><?= ($profit < 0)?"Loss":"Profit" ?>: <?= rupee_format($profit) ?> Rs.</h3>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Bank Accounts Summary</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr class="table_header_row">
                                    <th>Account Title</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($bank_accounts as $account): ?>
                                    <tr>
                                        <th><?= $account['title']." [ ".$account['sub_title']." ]" ?></th>
                                        <td>
                                            <?php
                                            $balance = $account['debit'] - $account['credit'];
                                            if($balance >= 0)
                                            {
                                                echo "<span style='color: green;'>";
                                                echo rupee_format($balance)." Dr";
                                                echo "</span>";
                                            }else{
                                                echo "<span style='color: red;'>";
                                                echo rupee_format($balance*-1)." Cr";
                                                echo "</span>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <script type="text/javascript"
                        src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>

                <script type="text/javascript">
                    google.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Month', 'Sales', 'Purchases', 'Expenses'],
                            <?php
                            $counter = 1;
                            foreach($business_performance as $status)
                            {
                                echo "['".$status->getMonthNameFormatted()."', ".$status->getSales().", ".$status->getPurchases().", ".$status->getExpenses()."]".(($counter == sizeof($business_performance))?'':',')."";
                                $counter++;
                            }
                            ?>
                        ]);

                        var options = {
                            title: 'Company Performance',
                            curveType: 'function',
                            legend: { position: 'bottom' }
                        };

                        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                        chart.draw(data, options);
                    }
                </script>

                <div id="curve_chart" class="col-lg-12" style="height: 500px;"></div>
            </div>
        </div>
    </div>

</div>