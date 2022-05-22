<?php

namespace Modules\Hrm\Entities\Data;

use App\Classes\Datasetter;

class Designation
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {


        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "President",
            "slug" => "president",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Vice President",
            "slug" => "vice_president",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "CEO",
            "slug" => "ceo",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Managing Director",
            "slug" => "managing_director",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Product Manager",
            "slug" => "product_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Project Manager",
            "slug" => "project_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Program Manager",
            "slug" => "program_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Operations Manager",
            "slug" => "operations_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Marketing Manager",
            "slug" => "marketing_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Business Manager",
            "slug" => "business_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Technology Manager",
            "slug" => "technology_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Finance\/Accounts Manager",
            "slug" => "finance_accounts_anager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Human Resource Manager",
            "slug" => "human_resource_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Hiring Manager",
            "slug" => "hiring_manager",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Senior Engineer",
            "slug" => "senior_engineer",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Engineer",
            "slug" => "engineer",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Junior Engineer",
            "slug" => "junior_engineer",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Business Executive",
            "slug" => "business_executive",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Marketing Executive",
            "slug" => "marketing_executive",
            "status" => "1"
        ]);
        $datasetter->add_data('hrm', 'designation', 'slug', [
            "title" => "Customer Support Executive",
            "slug" => "customer_support_executive",
            "status" => "1"
        ]);
    }
}
