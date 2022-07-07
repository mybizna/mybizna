<?php

namespace Modules\Hrm\Entities\Data;

use Modules\Base\Classes\Datasetter;

class Department
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {

        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "General Management",
            "slug" => "general_management",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Operations Department",
            "slug" => "operations_department",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Finance Department",
            "slug" => "finance_department",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Sales Department",
            "slug" => "sales_department",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Human Resource Department",
            "slug" => "human_resource_department",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Purchase Department",
            "slug" => "purchase_department",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Engineering Department",
            "slug" => "engineering_department",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Production Department",
            "slug" => "production_department",
            "lead" => "2",
            "parent" => "0",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'department', 'slug', [
            "title" => "Procurement Department",
            "slug" => "procurement_department",
            "lead" => "0",
            "parent" => "0",
            "status" => "1"
        ]);
    }
}
