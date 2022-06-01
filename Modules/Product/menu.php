<?php

$this->add_module_info("products", [
    'title' => 'Products',
    'description' => 'Products',
    'icon' => 'fas fa-store',
    'path' => '/products',
    'class_str' => 'text-secondary border-secondary'
]);


$this->add_menu("products", "dashboard", "Dashboard", "/dashboard", "fas fa-cogs", 1);
$this->add_menu("products", "products", "Products & Services", "/products/product-service", "fas fa-cogs", 5);
$this->add_menu("products", "products", "Products Categories", "/products/product-categories", "fas fa-cogs", 5);
$this->add_menu("products", "products", "Inventory", "/products/inventory", "fas fa-cogs", 5);
