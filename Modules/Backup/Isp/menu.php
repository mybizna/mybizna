<?php

$this->add_module_info("isp", [
    'title' => 'Isp',
    'description' => 'Isp',
    'icon' => 'fas fa-network-wired',
    'path' => '/admin/isp',
    'class_str' => 'text-secondary border-secondary'
]);

$this->add_menu("isp", "dashboard", "Dashboard", "/dashboard", "fas fa-cogs", 1);
$this->add_menu("isp", "billing", "Billing", "/isp/admin/billing", "fas fa-cogs", 5);
$this->add_menu("isp", "connection", "Connection", "/isp/admin/connection", "fas fa-cogs", 5);
$this->add_menu("isp", "package", "Package", "/isp/admin/package", "fas fa-cogs", 5);


$this->add_submenu("isp", "billing", "Billing", "/isp/admin/billing", 5);
$this->add_submenu("isp", "billing", "Billing Cylce", "/isp/admin/billing_cycle", 5);
$this->add_submenu("isp", "billing", "Billing Item", "/isp/admin/billing_item", 5);
$this->add_submenu("isp", "connection", "Connection", "/isp/admin/connection", 5);
$this->add_submenu("isp", "connection", "Invoice", "/isp/admin/connection_connection_invoice", 5);
$this->add_submenu("isp", "connection", "Setup Item", "/isp/admin/connection_setup_item", 5);
$this->add_submenu("isp", "package", "Package", "/isp/admin/package", 5);
$this->add_submenu("isp", "package", "Setup Item", "/isp/admin/package_setup_item", 5);
