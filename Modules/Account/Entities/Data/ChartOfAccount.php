<?php

namespace Modules\Account\Entities\Data;

use App\Classes\Datasetter;

class ChartOfAccount
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $datasetter->add_data('account', 'chart_of_account', 'slug', [
            "name" => "Asset",
            "slug" => "asset",
        ]);

        $datasetter->add_data('account', 'chart_of_account', 'slug', [
            "name" => "Liability",
            "slug" => "liability",
        ]);

        $datasetter->add_data('account', 'chart_of_account', 'slug', [
            "name" => "Equity",
            "slug" => "equity",
        ]);

        $datasetter->add_data('account', 'chart_of_account', 'slug', [
            "name" => "Income",
            "slug" => "income",
        ]);

        $datasetter->add_data('account', 'chart_of_account', 'slug', [
            "name" => "Expense",
            "slug" => "expense",
        ]);

        $datasetter->add_data('account', 'chart_of_account', 'slug', [
            "name" => "Asset & Liability",
            "slug" => "asset_liability",
        ]);


        $datasetter->add_data('account', 'chart_of_account', 'slug', [
            "name" => "Bank",
            "slug" => "bank",
        ]);
    }
}
