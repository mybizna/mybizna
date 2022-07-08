<?php

namespace Modules\Account\Entities\Data;

use Modules\Base\Classes\Datasetter;

class Gateway
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $datasetter->add_data('account', 'gateway', 'slug', [
            "title" => "Manual",
            "slug" => "manual",
            "ordering" => 0,
            "is_default" => true,
            "published" => true
        ]);
    }
}
