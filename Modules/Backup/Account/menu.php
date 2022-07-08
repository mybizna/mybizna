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
$this->add_menu("account", "transaction", "Transaction", "/account/admin/transaction", "fas fa-cogs", 1);
$this->add_menu("account", "invoice", "Invoice", "/account/admin/invoices", "fas fa-cogs", 1);
$this->add_menu("account", "coupon", "Coupon", "/account/admin/coupon", "fas fa-cogs", 1);
$this->add_menu("account", "gateway", "Gateway", "/account/admin/gateway", "fas fa-cogs", 1);
$this->add_menu("account", "payment", "Payment", "/account/admin/payment", "fas fa-cogs", 1);
$this->add_menu("account", "journal", "Journal", "/account/admin/journal", "fas fa-cogs", 1);
$this->add_menu("account", "setting", "Settings", "/settings", "fas fa-cogs", 5);
$this->add_menu("account", "reports", "Reports", "/reports", "fas fa-cogs", 5);

//$this->add_submenu("module", "key", "title","path", "position");

$this->add_submenu("account", "setting", "Financial Year", "/account/admin/Financial Year", 5);
$this->add_submenu("account", "setting", "Chart of Accounts", "/account/admin/chart_of_account", 5);
$this->add_submenu("account", "setting", "Rate", "/account/admin/rate", 5);
$this->add_submenu("account", "setting", "Ledger", "/account/admin/ledger", 5);
$this->add_submenu("account", "setting", "Ledger Category", "/account/admin/ledger_category", 5);
$this->add_submenu("account", "setting", "Ledger Setting", "/account/admin/ledger_setting", 5);

$this->add_submenu("account", "reports", "Balance Sheet", "/account/reports/balance-sheet", 5);
$this->add_submenu("account", "reports", "Income Statement", "/account/reports/balance-sheet", 5);
$this->add_submenu("account", "reports", "Ledger Report", "/account/reports/ledger-report", 5);
$this->add_submenu("account", "reports", "Trail Balance", "/account/reports/trail-balance", 5);
//$this->add_submenu("account", "settings", "Tax Rates", "/settings/taxes/tax-rates", 5);
//$this->add_submenu("account", "settings", "Tax Payments", "/settings/taxes/tax-records", 5);
//$this->add_submenu("account", "settings", "Tax Rates", "/settings/taxes/tax-rates", 5);

