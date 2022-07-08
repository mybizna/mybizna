<?php

$this->add_module_info("sale", [
    'title' => 'Sale',
    'description' => 'Sale',
    'icon' => 'fas fa-chart-pie',
    'path' => '/transactions/sales',
    'class_str'=> 'text-primary border-primary'
]);


//$this->add_menu("module", "key", "title","path", "icon", "position");
$this->add_menu("sale", "dashboard", "Dashboard", "/dashboard", "fas fa-cogs", 1);
$this->add_menu("sale", "sales", "Sales", "/sales", "fas fa-cogs", 5);
$this->add_menu("sale", "purchases", "Purchases", "/purchases", "fas fa-cogs", 5);

//$this->add_submenu("module", "key", "title","path", "position");

