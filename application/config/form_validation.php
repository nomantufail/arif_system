<?php$config = array(    'add_customer' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|min_length[1]|max_length[100]|xss_clean|callback__check_unique_customer'        ),        array(            'field' => 'phone',            'label' => 'Phone',            'rules' => 'trim|min_length[1]|max_length[100]|xss_clean'        ),        array(            'field' => 'address',            'label' => 'Address',            'rules' => 'trim|min_length[1]|max_length[100]|xss_clean'        ),    ),    'delete_customer' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|xss_clean|callback__check_customer_deletable'        ),    ),    'add_supplier' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|min_length[4]|max_length[100]|xss_clean|callback__check_unique_supplier'        ),        array(            'field' => 'phone',            'label' => 'Phone',            'rules' => 'trim|min_length[1]|max_length[100]|xss_clean'        ),        array(            'field' => 'address',            'label' => 'Address',            'rules' => 'trim|min_length[1]|max_length[100]|xss_clean'        ),    ),    'delete_supplier' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|xss_clean|callback__check_supplier_deletable'        ),    ),    'add_product' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|min_length[1]|max_length[100]|xss_clean|is_unique[products.name]'        ),        array(            'field' => 'description',            'label' => 'Description',            'rules' => 'trim|max_length[100]|xss_clean'        ),    ),    'delete_product' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|xss_clean|callback__check_product_deletable'        ),    ),    'delete_expense_title' => array(        array(            'field' => 'title',            'label' => 'Expense Title',            'rules' => 'trim|required|xss_clean|callback__check_expense_title_deletable'        ),    ),    'add_city' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|min_length[1]|max_length[100]|xss_clean|is_unique[cities.name]'        ),    ),    'delete_city' => array(        array(            'field' => 'id',            'label' => 'City#',            'rules' => 'trim|required|xss_clean'        ),    ),    'add_expense_title' => array(        array(            'field' => 'title',            'label' => 'Expense Title',            'rules' => 'trim|required|min_length[1]|max_length[250]|xss_clean|is_unique[expense_titles.title]'        ),    ),    'addWithdrawAccount' => array(        array(            'field' => 'title',            'label' => 'Withdraw Title',            'rules' => 'trim|required|min_length[1]|max_length[250]|xss_clean|is_unique[withdraw_accounts.title]'        ),    ),    'addExpense' => array(        array(            'field' => 'expense_title',            'label' => 'Expense Title',            'rules' => 'trim|required|min_length[1]|max_length[250]|xss_clean'        ),        array(            'field' => 'tanker',            'label' => 'Tanker Number',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'amount',            'label' => 'Expense Amount',            'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'        ),        array(            'field' => 'expense_date',            'label' => 'Expense Date',            'rules' => 'trim|required|xss_clean'        ),    ),    'saveExpensePayment' => array(        array(            'field' => 'voucher_date',            'label' => 'Voucher Date',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'bank_ac',            'label' => 'Bank A/C',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'amount',            'label' => 'Amount',            'rules' => 'trim|required|numeric|xss_clean'        ),    ),    'withdraw' => array(        array(            'field' => 'voucher_date',            'label' => 'Voucher Date',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'bank_ac',            'label' => 'Bank A/C',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'withdraw_account',            'label' => 'Withdraw A/C',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'amount',            'label' => 'Amount',            'rules' => 'trim|required|numeric|xss_clean'        ),    ),    'add_tanker' => array(        array(            'field' => 'name',            'label' => 'Name',            'rules' => 'trim|required|min_length[1]|max_length[100]|xss_clean|callback__check_unique_customer'        ),        array(            'field' => 'number',            'label' => 'Number',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'capacity',            'label' => 'Capacity',            'rules' => 'trim|xss_clean'        ),        array(            'field' => 'chambers',            'label' => 'Chambers',            'rules' => 'trim|xss_clean'        ),    ),    'delete_tanker' => array(        array(            'field' => 'number',            'label' => 'Tanker Number',            'rules' => 'trim|required|xss_clean|callback__check_tanker_deletable'        ),    ),    'add_bank_ac' => array(        array(            'field' => 'title',            'label' => 'Account Title',            'rules' => 'trim|required|min_length[4]|max_length[100]|xss_clean|callback__check_bank_title_unique'        ),        array(            'field' => 'account_number',            'label' => 'Account Number',            'rules' => 'trim|required|min_length[5]|max_length[20]|xss_clean|is_unique[user_bank_accounts.account_number]'        ),        array(            'field' => 'type',            'label' => 'Account Type',            'rules' => 'trim|max_length[100]|xss_clean'        ),    ),    'add_product_with_freight' => array(        array(            'field' => 'tanker',            'label' => 'Tanker',            'rules' => 'trim|required|xss_clean|callback__check_product_availability|callback__check_for_same_product_selection|callback__check_for_any_product_selected'        ),        array(            'field' => 'invoice_date',            'label' => 'Invoice Date',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'customer',            'label' => 'Customer',            'rules' => 'trim|required|xss_clean'        ),    ),    'add_freight_sale' => array(        array(            'field' => 'tanker',            'label' => 'Tanker',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'invoice_date',            'label' => 'Invoice Date',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'source',            'label' => 'Source',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'destination',            'label' => 'Destination',            'rules' => 'trim|required|xss_clean'        ),    ),    'add_product_sale' => array(        array(            'field' => 'tanker',            'label' => 'Tanker',            'rules' => 'trim|required|xss_clean|callback__check_product_availability|callback__check_for_same_product_selection|callback__check_for_any_product_selected'        ),        array(            'field' => 'invoice_date',            'label' => 'Invoice Date',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'customer',            'label' => 'Customer',            'rules' => 'trim|required|xss_clean'        ),    ),    'add_product_purchase' => array(        array(            'field' => 'tanker',            'label' => 'Tanker',            'rules' => 'trim|required|xss_clean|callback__check_for_same_product_selection|callback__check_for_any_product_selected'        ),        array(            'field' => 'invoice_date',            'label' => 'Invoice Date',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'supplier',            'label' => 'Supplier',            'rules' => 'trim|required|xss_clean'        ),    ),    'delete_sale_invoice'=>array(        array(            'field' => 'invoice_number',            'label' => 'Invoice Number',            'rules' => 'trim|required|numeric|xss_clean'        ),        array(            'field' => 'item_id',            'label' => 'Item Number',            'rules' => 'trim|required|greater_than[0]|xss_clean'        ),    ),    'delete_purchase_invoice'=>array(        array(            'field' => 'invoice_number',            'label' => 'Invoice Number',            'rules' => 'trim|required|numeric|xss_clean'        ),        array(            'field' => 'item_id',            'label' => 'Item Number',            'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'        ),    ),    'delete_payment_invoice'=>array(        array(            'field' => 'invoice_number',            'label' => 'Invoice Number',            'rules' => 'trim|required|numeric|xss_clean'        ),    ),    'delete_receipt_invoice'=>array(        array(            'field' => 'invoice_number',            'label' => 'Invoice Number',            'rules' => 'trim|required|numeric|xss_clean'        ),    ),    'delete_expense_invoice'=>array(        array(            'field' => 'invoice_number',            'label' => 'Invoice Number',            'rules' => 'trim|required|numeric|xss_clean'        ),    ),    'delete_expense_payment_invoice'=>array(        array(            'field' => 'invoice_number',            'label' => 'Invoice Number',            'rules' => 'trim|required|numeric|xss_clean'        ),    ),    'login' => array(        array(            'field' => 'username',            'label' => 'Username',            'rules' => 'trim|required|xss_clean'        ),        array(            'field' => 'password',            'label' => 'Password',            'rules' => 'trim|required|xss_clean'        ),    ),);?>