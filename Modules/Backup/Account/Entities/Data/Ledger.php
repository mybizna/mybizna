<?php

namespace Modules\Account\Entities\Data;

use Modules\Base\Classes\Datasetter;
use Illuminate\Support\Facades\DB;

class Ledger
{

    public $ordering = 5;

    public function data(Datasetter $datasetter)
    {

        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'asset')->value('id');


        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Accounts Receivable",
            "slug" => "accounts_receivable",
            "code" => "120",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Inventory",
            "slug" => "inventory",
            "code" => "140",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Office Equipment",
            "slug" => "office_equipment",
            "code" => "150",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Less Accumulated Depreciation on Office Equipment",
            "slug" => "less_accumulated_depreciation_on_office_equipment",
            "code" => "151",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Computer Equipment",
            "slug" => "computer_equipment",
            "code" => "160",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Less Accumulated Depreciation on Computer Equipment",
            "slug" => "less_accumulated_depreciation_on_computer_equipment",
            "code" => "161",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Cash",
            "slug" => "cash",
            "code" => "90",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Savings Account",
            "slug" => "savings_account",
            "code" => "92",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Allowance for Doubtful Accounts",
            "slug" => "allowance_for_doubtful_accounts",
            "code" => "1001",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Interest Receivable",
            "slug" => "interest_receivable",
            "code" => "1002",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Supplies",
            "slug" => "supplies",
            "code" => "1003",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Prepaid Insurance",
            "slug" => "prepaid_insurance",
            "code" => "1004",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Prepaid Rent",
            "slug" => "prepaid_rent",
            "code" => "1005",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Prepaid Salary",
            "slug" => "prepaid_salary",
            "code" => "1006",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Land",
            "slug" => "land",
            "code" => "1007",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Furniture & Fixture",
            "slug" => "furniture_fixture",
            "code" => "1008",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Buildings",
            "slug" => "buildings",
            "code" => "1009",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Copyrights",
            "slug" => "copyrights",
            "code" => "1010",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Goodwill",
            "slug" => "goodwill",
            "code" => "1011",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Patents",
            "slug" => "patents",
            "code" => "1012",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Accoumulated Depreciation- Buildings",
            "slug" => "accoumulated_depreciation_buildings",
            "code" => "1013",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Accoumulated Depreciation- Furniture & Fixtures",
            "slug" => "accoumulated_depreciation_furniture_fixtures",
            "code" => "1014",
            "system" => "1"
        ]);

        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'liability')->value('id');

        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Accounts Payable",
            "slug" => "accounts_payable",
            "code" => "200",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Accruals",
            "slug" => "accruals",
            "code" => "205",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Unpaid Expense Claims",
            "slug" => "unpaid_expense_claims",
            "code" => "210",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Wages Payable",
            "slug" => "wages_payable",
            "code" => "215",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Wages Payable - Payroll",
            "slug" => "wages_payable_payroll",
            "code" => "216",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales Tax",
            "slug" => "sales_tax",
            "code" => "220",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Employee Tax Payable",
            "slug" => "employee_tax_payable",
            "code" => "230",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Employee Benefits Payable",
            "slug" => "employee_benefits_payable",
            "code" => "235",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Employee Deductions payable",
            "slug" => "employee_deductions_payable",
            "code" => "236",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Income Tax Payable",
            "slug" => "income_tax_payable",
            "code" => "240",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Suspense",
            "slug" => "suspense",
            "code" => "250",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Historical Adjustments",
            "slug" => "historical_adjustments",
            "code" => "255",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Rounding",
            "slug" => "rounding",
            "code" => "260",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Revenue Received in Advance",
            "slug" => "revenue_received_in_advance",
            "code" => "835",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Clearing Account",
            "slug" => "clearing_account",
            "code" => "855",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Loan",
            "slug" => "loan",
            "code" => "290",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Shipment Tax",
            "slug" => "shipment_tax",
            "code" => "221",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Notes Payable",
            "slug" => "notes_payable",
            "code" => "1201",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Salaries and Wages Payable",
            "slug" => "salaries_and_wages_payable",
            "code" => "1202",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Unearned Rent Revenue",
            "slug" => "unearned_rent_revenue",
            "code" => "1203",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Interest Payable",
            "slug" => "interest_payable",
            "code" => "1204",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Dividends Payable",
            "slug" => "dividends_payable",
            "code" => "1205",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Bonds Payable",
            "slug" => "bonds_payable",
            "code" => "1206",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Discount on Bonds Payable",
            "slug" => "discount_on_bonds_payable",
            "code" => "1207",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Premium on Bonds Payable",
            "slug" => "premium_on_bonds_payable",
            "code" => "1208",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Mortgage Payable",
            "slug" => "mortgage_payable",
            "code" => "1209",
            "system" => "1"
        ]);

        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'equity')->value('id');

        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Owners Contribution",
            "slug" => "owners_contribution",
            "code" => "300",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Owners Draw",
            "slug" => "owners_draw",
            "code" => "310",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Retained Earnings",
            "slug" => "retained_earnings",
            "code" => "320",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Common Stock",
            "slug" => "common_stock",
            "code" => "330",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Owner's Equity",
            "slug" => "owner_s_equity",
            "code" => "1301",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Paid-in Capital in Excess of Par- Common Stock",
            "slug" => "paid_in_capital_in_excess_of_par_common_stock",
            "code" => "1302",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Paid-in Capital in Excess of Par- Preferred Stock",
            "slug" => "paid_in_capital_in_excess_of_par_preferred_stock",
            "code" => "1303",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Preferred Stock",
            "slug" => "preferred_stock",
            "code" => "1304",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Treasury Stock",
            "slug" => "treasury_stock",
            "code" => "1305",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Dividends",
            "slug" => "dividends",
            "code" => "1306",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Income Summary",
            "slug" => "income_summary",
            "code" => "1307",
            "system" => "1"
        ]);

        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'income')->value('id');

        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales",
            "slug" => "sales",
            "code" => "400",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Interest Income",
            "slug" => "interest_income",
            "code" => "460",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Other Revenue",
            "slug" => "other_revenue",
            "code" => "470",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Purchase Discount",
            "slug" => "purchase_discount",
            "code" => "475",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Service Revenue",
            "slug" => "service_revenue",
            "code" => "1401",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales Revenue",
            "slug" => "sales_revenue",
            "code" => "1402",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Shipment",
            "slug" => "shipment",
            "code" => "1411",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Gain on Disposal of Plant Assets",
            "slug" => "gain_on_disposal_of_plant_assets",
            "code" => "1404",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Asset Sales",
            "slug" => "asset_sales",
            "code" => "1405",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales Return Discount",
            "slug" => "sales_return_discount",
            "code" => "1406",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales Return Tax",
            "slug" => "sales_return_tax",
            "code" => "1407",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Purchase Return",
            "slug" => "purchase_return",
            "code" => "1408",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Purchase Return VAT",
            "slug" => "purchase_return_vat",
            "code" => "1409",
            "system" => "1"
        ]);

        $chart_id = DB::table('account_chart_of_account')
            ->where('slug', 'expense')->value('id');

        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Costs of Goods Sold",
            "slug" => "costs_of_goods_sold",
            "code" => "500",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Advertising",
            "slug" => "advertising",
            "code" => "600",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Bank Service Charges",
            "slug" => "bank_service_charges",
            "code" => "605",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Bank Transaction Charge",
            "slug" => "bank_transaction_charge",
            "code" => "606",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales Return",
            "slug" => "sales_return",
            "code" => "607",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Janitorial Expenses",
            "slug" => "janitorial_expenses",
            "code" => "610",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Consulting & Accounting",
            "slug" => "consulting_accounting",
            "code" => "615",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Entertainment",
            "slug" => "entertainment",
            "code" => "620",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Postage & Delivary",
            "slug" => "postage_delivary",
            "code" => "624",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "General Expenses",
            "slug" => "general_expenses",
            "code" => "628",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Insurance",
            "slug" => "insurance",
            "code" => "632",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Legal Expenses",
            "slug" => "legal_expenses",
            "code" => "636",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Utilities",
            "slug" => "utilities",
            "code" => "640",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Automobile Expenses",
            "slug" => "automobile_expenses",
            "code" => "644",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Office Expenses",
            "slug" => "office_expenses",
            "code" => "648",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Printing & Stationary",
            "slug" => "printing_stationary",
            "code" => "652",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Rent",
            "slug" => "rent",
            "code" => "656",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Repairs & Maintenance",
            "slug" => "repairs_maintenance",
            "code" => "660",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Wages & Salaries",
            "slug" => "wages_salaries",
            "code" => "664",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Payroll Tax Expense",
            "slug" => "payroll_tax_expense",
            "code" => "668",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Dues & Subscriptions",
            "slug" => "dues_subscriptions",
            "code" => "672",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Telephone & Internet",
            "slug" => "telephone_internet",
            "code" => "676",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Travel",
            "slug" => "travel",
            "code" => "680",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Bad Debts",
            "slug" => "bad_debts",
            "code" => "684",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Depreciation",
            "slug" => "depreciation",
            "code" => "700",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Income Tax Expense",
            "slug" => "income_tax_expense",
            "code" => "710",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Employee Benefits Expense",
            "slug" => "employee_benefits_expense",
            "code" => "715",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Interest Expense",
            "slug" => "interest_expense",
            "code" => "800",
            "system" => "0"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Bank Revaluations",
            "slug" => "bank_revaluations",
            "code" => "810",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Unrealized Currency Gains",
            "slug" => "unrealized_currency_gains",
            "code" => "815",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Realized Currency Gains",
            "slug" => "realized_currency_gains",
            "code" => "820",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales Discount",
            "slug" => "sales_discount",
            "code" => "825",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Amortization Expense",
            "slug" => "amortization_expense",
            "code" => "1501",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Freight-Out",
            "slug" => "freight_out",
            "code" => "1502",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Insurance Expense",
            "slug" => "insurance_expense",
            "code" => "1503",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Loss on Disposal of Plant Assets",
            "slug" => "loss_on_disposal_of_plant_assets",
            "code" => "1504",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Maintenance and Repairs Expense",
            "slug" => "maintenance_and_repairs_expense",
            "code" => "1505",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Purchase",
            "slug" => "purchase",
            "code" => "1506",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Asset Purchase",
            "slug" => "asset_purchase",
            "code" => "1507",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Purchase VAT",
            "slug" => "purchase_vat",
            "code" => "1509",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Sales Returns and Allowance",
            "slug" => "sales_returns_and_allowance",
            "code" => "1403",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Purchase Return Discount",
            "slug" => "purchase_return_discount",
            "code" => "1410",
            "system" => "1"
        ]);
        $datasetter->add_data('account', 'ledger',  'slug', [
            "chart_id" =>  $chart_id,
            "name" => "Bank Transaction Charge",
            "slug" => "bank_transaction_charge",
            "code" => "1508",
            "system" => "1"
        ]);
    }
}
