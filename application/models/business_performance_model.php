<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 6/4/15
 * Time: 7:02 AM
 */

class Business_Performance_Model extends parent_model{

    public function __construct()
    {
        parent::__construct();

        include_once(APPPATH."models/helperClasses/Expense_Sales_Purchase_Monthly_status.php");
    }

    public function month_by_month_expense_sales_purchase_sheet($year = null)
    {
        $year = ($year == null)?date('Y'):$year;
        $current_month_number = date('m');

        $monthely_statuses = array();
        for($counter = 1; $counter <= $current_month_number; $counter++)
        {
            $temp_status = new Expense_Sales_Purchase_Monthly_status();
            $temp_status->setMonthNumber($counter);
            array_push($monthely_statuses, $temp_status);
        }

        /**
         * Calculating Total Sales
         **/
        $product_sales = $this->sales_model->search_limited_product_sale_invoices(array('from'=>$year."-01-01",'to'=>$year."-12-31"),null);
        $product_with_freight_sales = $this->sales_model->search_limited_product_sale_with_freight_invoices(array('from'=>$year."-01-01",'to'=>$year."-12-31"),null);

        foreach($product_sales as $sale)
        {
            $date = $sale->date;
            $date_parts = explode('-',$date);
            $month_number = $date_parts[1];

            $amount = $sale->entries[0]->total_cost();

            $status_object = &$monthely_statuses[$month_number-1];

            $now_total_sales = $status_object->getSales() + $amount;
            $status_object->setSales($now_total_sales);
        }
        foreach($product_with_freight_sales as $sale)
        {
            $date = $sale->date;
            $date_parts = explode('-',$date);
            $month_number = $date_parts[1];

            $amount = $sale->entries[0]->total_cost();

            $status_object = &$monthely_statuses[$month_number-1];

            $now_total_sales = $status_object->getSales() + $amount;
            $status_object->setSales($now_total_sales);
        }

        /**
         * Calculating Total Purchases
         **/
        $all_purchases = $this->purchases_model->search_limited_invoices(array('from'=>$year."-01-01",'to'=>$year."-12-31"),null);
        foreach($all_purchases as $purchase)
        {
            $date = $purchase->date;
            $date_parts = explode('-',$date);
            $month_number = $date_parts[1];

            $amount = $purchase->entries[0]->total_cost();

            $status_object = &$monthely_statuses[$month_number-1];

            $now_total_purchases = $status_object->getPurchases() + $amount;
            $status_object->setPurchases($now_total_purchases);
        }

        /**
         * Calculating Total Purchases
         **/
        $all_expenses = $this->expenses_model->search_expense_history(array('from'=>$year."-01-01",'to'=>$year."-12-31"),null);
        foreach($all_expenses as $expense)
        {
            $date = $expense->expense_date;
            $date_parts = explode('-',$date);
            $month_number = $date_parts[1];

            $amount = $expense->amount;

            $status_object = &$monthely_statuses[$month_number-1];

            $now_total_expenses = $status_object->getExpenses() + $amount;
            $status_object->setExpenses($now_total_expenses);
        }

        return $monthely_statuses;

    }
} 