<?php

$this->add_module_info("account", [
    'title' => 'Accounting',
    'description' => 'Accounting',
    'icon' => 'fas fa-funnel-dollar',
    'path' => '/transactions',
    'class_str'=> 'text-primary border-primary'
]);

//$this->add_menu("module", "key", "title","path", "icon", "position");
$this->add_menu("account", "dashboard", "Dashboard", "/dashboard", "fas fa-cogs", 1);
$this->add_menu("account", "users", "Users", "/users", "fas fa-cogs", 5);
$this->add_menu("account", "transactions", "Transactions", "/transactions", "fas fa-cogs", 5);
$this->add_menu("account", "settings", "Settings", "/settings", "fas fa-cogs", 5);
$this->add_menu("account", "products", "Products", "/products", "fas fa-cogs", 5);
$this->add_menu("account", "reports", "Reports", "/reports", "fas fa-cogs", 5);
$this->add_menu("account", "help", "Help", "/help", "fas fa-cogs", 5);

//$this->add_submenu("module", "key", "title","path", "position");
$this->add_submenu("account", "users", "Customers", "/users/customers", 5);
$this->add_submenu("account", "users", "Vendors", "/users/vendors", 5);
$this->add_submenu("account", "users", "Employees", "/users/employees", 5);

$this->add_submenu("account", "transactions", "Sales", "/transactions/sales", 5);
$this->add_submenu("account", "transactions", "Expenses", "/transactions/expenses", 5);
$this->add_submenu("account", "transactions", "Purchases", "/transactions/purchases", 5);
$this->add_submenu("account", "transactions", "Reimbursements", "/transactions/reimbursements", 5);

$this->add_submenu("account", "settings", "Chart of Accounts", "/settings/charts", 5);
$this->add_submenu("account", "settings", "Bank Accounts", "/settings/banks", 5);
$this->add_submenu("account", "settings", "Tax Rates", "/settings/taxes/tax-rates", 5);
$this->add_submenu("account", "settings", "Tax Payments", "/settings/taxes/tax-records", 5);
$this->add_submenu("account", "settings", "Tax Rates", "/settings/taxes/tax-rates", 5);

$this->add_submenu("account", "products", "Products & Services", "/products/product-service", 5);
$this->add_submenu("account", "products", "Products Categories", "/products/product-categories", 5);
$this->add_submenu("account", "products", "Inventory", "/products/inventory", 5);
