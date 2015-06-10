<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 6/4/15
 * Time: 7:07 AM
 */

class Expense_Sales_Purchase_Monthly_status {

    private $month_number;
    private $sales;
    private $expenses;
    private $purchases;
    private $monthNameFormatted;
    private $months;

    public function __construct()
    {
        $this->setSales(0);
        $this->setPurchases(0);
        $this->setExpenses(0);

        $this->months = array(
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        );
    }

    /**
     * @param mixed $expenses
     */
    public function setExpenses($expenses)
    {
        $this->expenses = $expenses;
    }

    /**
     * @return mixed
     */
    public function getExpenses()
    {
        return $this->expenses;
    }

    /**
     * @param mixed $monthNameFormatted
     */
    public function setMonthNameFormatted($monthNameFormatted)
    {
        $this->monthNameFormatted = $monthNameFormatted;
    }

    /**
     * @return mixed
     */
    public function getMonthNameFormatted()
    {
        return $this->months[$this->getMonthNumber()-1];
    }

    /**
     * @param mixed $month_number
     */
    public function setMonthNumber($month_number)
    {
        $this->month_number = $month_number;
    }

    /**
     * @return mixed
     */
    public function getMonthNumber()
    {
        return $this->month_number;
    }

    /**
     * @param mixed $purchases
     */
    public function setPurchases($purchases)
    {
        $this->purchases = $purchases;
    }

    /**
     * @return mixed
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * @param mixed $sales
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    }

    /**
     * @return mixed
     */
    public function getSales()
    {
        return $this->sales;
    }



} 