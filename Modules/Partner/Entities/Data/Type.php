<?php

namespace Modules\Partner\Entities\Data;

use Modules\Core\Classes\Datasetter;

class Type
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $datasetter->add_data('partner', 'type', 'name', [
            "name" => "company",
        ]);
        $datasetter->add_data('partner', 'type', 'name', [
            "name" => "contact",
        ]);
        $datasetter->add_data('partner', 'type', 'name', [
            "name" => "customer",
        ]);
        $datasetter->add_data('partner', 'type', 'name', [
            "name" => "employee",
        ]);
        $datasetter->add_data('partner', 'type', 'name', [
            "name" => "vendor",
        ]);
    }
}
