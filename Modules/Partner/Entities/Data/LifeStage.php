<?php

namespace Modules\Partner\Entities\Data;

use App\Classes\Datasetter;

class LifeStage
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $datasetter->add_data('partner', 'life_stage', 'slug', [
            "title" => "company",
        ]);

        $datasetter->add_data('partner', 'life_stage', 'slug', [
            "slug" => "customer",
            "title" => "Customer",
            "title_plural" => "Customers",
            "position" => "1"
        ]);
        $datasetter->add_data('partner', 'life_stage', 'slug', [
            "slug" => "lead",
            "title" => "Lead",
            "title_plural" => "Leads",
            "position" => "2"
        ]);
        $datasetter->add_data('partner', 'life_stage', 'slug', [
            "slug" => "opportunity",
            "title" => "Opportunity",
            "title_plural" => "Opportunities",
            "position" => "3"
        ]);
        $datasetter->add_data('partner', 'life_stage', 'slug', [
            "slug" => "subscriber",
            "title" => "Subscriber",
            "title_plural" => "Subscribers",
            "position" => "4"
        ]);
    }
}
