<?php

$this->add_module_info("expense", [
    'title' => 'Expense',
    'description' => 'Expense',
    'icon' => 'fas fa-chart-pie',
    'path' => '/transactions/expenses',
    'class_str'=> 'text-primary border-primary'
]);


//$this->add_menu("module", "key", "title","path", "icon", "position");
$this->add_menu("expense", "transactions", "New Expense", "/expenses", "fas fa-cogs", 5);
$this->add_menu("expense", "transactions-new", "Expenses", "/expenses/new", "fas fa-cogs", 5);

//$this->add_submenu("module", "key", "title","path", "position");

