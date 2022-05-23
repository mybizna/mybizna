<?php

namespace Modules\Base\Entities\Data;

use App\Classes\Datasetter;
use Illuminate\Support\Facades\DB;

class LedgerCategory
{

    public $ordering = 4;

    public function data(Datasetter $datasetter)
    {
        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'asset')->value('id');

        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Current Asset",
            "slug" => 'current_asset',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Fixed Asset",
            "slug" => 'fixed_asset',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Inventory",
            "slug" => 'inventory',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Non-current Asset",
            "slug" => 'non_current_asset',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Prepayment",
            "slug" => 'prepayment',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Bank & Cash",
            "slug" => 'bank_cash',
            "chart_id" => $chart_id
        ]);


        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'liability')->value('id');


        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Current Liability",
            "slug" => 'current_liability',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Liability",
            "slug" => 'liability',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Non-current Liability",
            "slug" => 'non_current_liability',
            "chart_id" => $chart_id
        ]);


        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'equity')->value('id');

        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Depreciation",
            "slug" => 'depreciation',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Direct Costs",
            "slug" => 'direct_costs',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Expense",
            "slug" => 'expense',
            "chart_id" => $chart_id
        ]);


        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'income')->value('id');


        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Revenue",
            "slug" => 'revenue',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Sales",
            "slug" => 'sales',
            "chart_id" => $chart_id
        ]);
        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Other Income",
            "slug" => 'other_income',
            "chart_id" => $chart_id
        ]);


        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'expense')->value('id');


        $datasetter->add_data('account', 'ledger_category', 'slug', [
            "name" => "Equity",
            "slug" => 'equity',
            "chart_id" => $chart_id
        ]);
    }
}
