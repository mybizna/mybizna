<?php

$this->add_module_info("partner", [
    'title' => 'Partner',
    'description' => 'Partner',
    'icon' => 'fas fa-store',
    'path' => '/products',
    'class_str'=> 'text-info border-info'
]);


$this->add_menu("partner", "dashboard", "Dashboard", "/dashboard", "fas fa-cogs", 1);
$this->add_menu("partner", "customers", "Customers", "/users/customers", "fas fa-cogs", 5);
$this->add_menu("partner", "vendors", "Vendors", "/users/vendors", "fas fa-cogs", 5);
$this->add_menu("partner", "employees", "Employees", "/users/employees", "fas fa-cogs", 5);
