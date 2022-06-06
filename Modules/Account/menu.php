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
$this->add_menu("account", "journals", "Journal", "/journals", "fas fa-cogs", 1);
$this->add_menu("account", "invoices", "Invoices", "/invoices", "fas fa-cogs", 1);
$this->add_menu("account", "settings", "Settings", "/settings", "fas fa-cogs", 5);
$this->add_menu("account", "reports", "Reports", "/reports", "fas fa-cogs", 5);

//$this->add_submenu("module", "key", "title","path", "position");

$this->add_submenu("account", "settings", "Chart of Accounts", "/settings/charts", 5);
$this->add_submenu("account", "settings", "Bank Accounts", "/settings/banks", 5);
$this->add_submenu("account", "settings", "Tax Rates", "/settings/taxes/tax-rates", 5);
$this->add_submenu("account", "settings", "Tax Payments", "/settings/taxes/tax-records", 5);
$this->add_submenu("account", "settings", "Tax Rates", "/settings/taxes/tax-rates", 5);
