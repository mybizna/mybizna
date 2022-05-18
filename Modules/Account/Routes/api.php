<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    ['prefix' => 'accounts', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'AccountsController';

        Route::get('/', $apicontroller . '@get_accounts')
            ->middleware('abilities:erp_ac_view_bank_accounts');

        Route::get('/{id}', $apicontroller . '@get_account')
            ->middleware('abilities:erp_ac_view_bank_accounts');
        Route::delete('/{id}', $apicontroller . '@delete_account')
            ->middleware('abilities:erp_ac_create_bank_transfer');

        Route::post('transfer/', $apicontroller . '@transfer_money')
            ->middleware('abilities:erp_ac_create_bank_transfer');
        Route::get('/transfers/{id}', $apicontroller . '@get_single_transfer')
            ->middleware('abilities:erp_ac_create_bank_transfer');
        Route::get('/transfers/list', $apicontroller . '@get_transfer_list')
            ->middleware('abilities:erp_ac_create_bank_transfer');

        Route::get('/bank-accounts', $apicontroller . '@get_bank_accounts')
            ->middleware('abilities:erp_ac_view_bank_accounts');

        Route::get('/cash-at-bank', $apicontroller . '@get_cash_at_bank')
            ->middleware('abilities:erp_ac_view_bank_accounts');
    }
);

Route::group(
    ['prefix' => 'bills', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'BillsController';

        Route::get('/', $apicontroller . '@get_bills')
            ->middleware('abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_bill')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_bill')
            ->middleware('abilities:erp_ac_view_expense');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_bill')
            ->middleware('abilities:erp_ac_view_expense');

        Route::get('/due/{id}', $apicontroller . '@due_bills')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_bill')
            ->middleware('abilities:erp_ac_publish_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_overview_payables')
            ->middleware('abilities:erp_ac_view_sales_summary');
    }
);

Route::group(
    ['prefix' => 'closing-balance', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ClosingBalanceController';

        Route::post('/', $apicontroller . '@close_balancesheet')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::get('/', $apicontroller . '@closest-fn-year')
            ->middleware('abilities:erp_ac_view_expense');

        Route::get('/', $apicontroller . '@next-fn-year')
            ->middleware('abilities:erp_ac_view_expense');
    }
);

Route::group(
    ['prefix' => 'company', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'CompanyController';

        Route::get('/', $apicontroller . '@get_company')
            ->middleware('abilities:erp_ac_view_dashboard');
    }
);

Route::group(
    ['prefix' => 'currencies', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'CurrenciesController';

        Route::get('/', $apicontroller . '@get_currencies')
            ->middleware('abilities:erp_ac_view_dashboard');
    }
);

Route::group(
    ['prefix' => 'customers', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'CustomersController';

        Route::get('/', $apicontroller . '@get_customers')
            ->middleware('abilities:erp_ac_view_customer');
        Route::post('/', $apicontroller . '@create_customer')
            ->middleware('abilities:erp_ac_create_customer');

        Route::get('/{id}', $apicontroller . '@get_customer')
            ->middleware('abilities:erp_ac_view_customer');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_customer')
            ->middleware('abilities:erp_ac_edit_customer');
        Route::delete('/{id}', $apicontroller . '@delete_customer')
            ->middleware('abilities:erp_ac_delete_customer');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete_customers')
            ->middleware('abilities:erp_ac_delete_customer');

        Route::get('/{id}/transactions', $apicontroller . '@get_transactions')
            ->middleware('abilities:erp_ac_view_customer');


        Route::get('/{id}/transactions/filter', $apicontroller . '@filter_transactions')
            ->middleware('abilities:erp_ac_view_customer');

        Route::get('/country', $apicontroller . '@get_countries')
            ->middleware('abilities:erp_ac_view_customer');
    }
);


Route::group(
    ['prefix' => 'employees', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'EmployeesController';

        Route::get('/', $apicontroller . '@get_employees')
            ->middleware('abilities:erp_view_list');

        Route::get('/{id}', $apicontroller . '@get_employee')
            ->middleware('abilities:erp_list_employee');

        Route::get('/{id}/transactions', $apicontroller . '@get_transactions')
            ->middleware('abilities:erp_view_list');
    }
);

Route::group(
    ['prefix' => 'expenses', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ExpensesController';

        Route::get('/', $apicontroller . '@get_expenses')
            ->middleware('abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_expense')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_transactions')
            ->middleware('abilities:erp_view_list');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_expense')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_expense')
            ->middleware('abilities:erp_ac_publish_expenses_voucher');
        Route::get('/checks/{id}', $apicontroller . '@get_check')
            ->middleware('abilities:erp_ac_view_expense');
    }
);


Route::group(
    ['prefix' => 'invoices', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'InvoicesController';

        Route::get('/', $apicontroller . '@get_invoices')
            ->middleware('abilities:erp_ac_view_sale');
        Route::post('/', $apicontroller . '@create_invoice')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@get_invoice')
            ->middleware('abilities:erp_ac_view_sales_summary');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_invoice')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::post('/{id}/void', $apicontroller . '@void_invoice')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/due/{id}', $apicontroller . '@due_invoices')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::post('/attachments', $apicontroller . '@upload_attachments')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/overview-receivable', $apicontroller . '@get_overview_receivables')
            ->middleware('abilities:erp_ac_create_sales_invoice');
    }
);

Route::group(
    ['prefix' => 'journals', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'JournalsController';

        Route::get('/', $apicontroller . '@get_journals')
            ->middleware('abilities:erp_ac_view_journal');

        Route::post('/', $apicontroller . '@create_journal')
            ->middleware('abilities:erp_ac_create_journal');

        Route::get('/{id}', $apicontroller . '@get_journal')
            ->middleware('abilities:erp_ac_view_journal');

        Route::get('/next', $apicontroller . '@get_next_journal_id')
            ->middleware('abilities:erp_ac_view_journal');
    }
);

Route::group(
    ['prefix' => 'ledgers', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'LedgersController';

        Route::get('/', $apicontroller . '@get_all_ledger_accounts')
            ->middleware('abilities:erp_ac_view_account_lists');
        Route::post('/', $apicontroller . '@create_ledger_account')
            ->middleware('abilities:erp_ac_create_account');

        Route::get('/{id}', $apicontroller . '@get_ledger_account')
            ->middleware('abilities:erp_ac_view_single_account');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_ledger_account')
            ->middleware('abilities:erp_ac_edit_account');
        Route::delete('/{id}', $apicontroller . '@delete_ledger_account')
            ->middleware('abilities:erp_ac_delete_account');

        Route::get('/{id}/accounts', $apicontroller . '@get_ledger_accounts_by_chart')
            ->middleware('abilities:erp_ac_view_account_lists');

        Route::get('/accounts', $apicontroller . '@get_chart_accounts')
            ->middleware('abilities:erp_ac_view_account_lists');

        Route::get('/bank-accounts', $apicontroller . '@get_bank_accounts')
            ->middleware('abilities:erp_ac_view_account_lists');

        Route::get('/cash-accounts', $apicontroller . '@get_cash_accounts')
            ->middleware('abilities:erp_ac_view_account_lists');
        /*
        Route::get('/categories/{id}', $apicontroller . '@get_ledger_categories')
        ->middleware('abilities:erp_ac_view_account_lists');
        Route::post('/categories/{id}', $apicontroller . '@create_ledger_category')
        ->middleware('abilities:erp_ac_create_account');
        Route::match(['post', 'put', 'patch'], '/categories/{id}',  $apicontroller . '@update_ledger_category')
        ->middleware('abilities:erp_ac_edit_account');
        Route::delete('/categories/{id}', $apicontroller . '@delete_ledger_category')
        ->middleware('abilities:erp_ac_delete_account');
        */
    }
);

Route::group(
    ['prefix' => 'opening-balances', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'OpeningBalanceController';

        Route::get('/', $apicontroller . '@get_opening_balances')
            ->middleware('abilities:erp_ac_view_journal');
        Route::post('/', $apicontroller . '@create_opening_balance')
            ->middleware('abilities:erp_ac_create_journal');

        Route::get('/names', $apicontroller . '@get_opening_balance_names')
            ->middleware('abilities:erp_ac_view_journal');

        Route::get('/{id}', $apicontroller . '@get_opening_balance')
            ->middleware('abilities:erp_ac_view_journal');

        Route::get('/virtual-accts/{id}', $apicontroller . '@get_virtual_accts_by_year')
            ->middleware('abilities:erp_ac_view_journal');


        Route::get('/acc-payable-receivable', $apicontroller . '@get_acc_payable_receivable')
            ->middleware('abilities:erp_ac_view_journal');
    }
);


Route::group(
    ['prefix' => 'pay-bills', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PayBillsController';

        Route::get('/', $apicontroller . '@get_pay_bills')
            ->middleware('abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_pay_bill')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_pay_bill')
            ->middleware('abilities:erp_ac_view_expense');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_pay_bill')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_pay_bill')
            ->middleware('abilities:erp_ac_publish_expenses_voucher');
    }
);


Route::group(
    ['prefix' => 'pay-purchases', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PayPurchasesController';

        Route::get('/', $apicontroller . '@get_pay_purchases')
            ->middleware('abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_pay_purchase')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_pay_purchase')
            ->middleware('abilities:erp_ac_view_expense');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_pay_purchase')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_pay_purchase')
            ->middleware('abilities:erp_ac_publish_expenses_voucher');
    }
);

Route::group(
    ['prefix' => 'people', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PeopleController';

        Route::get('/', $apicontroller . '@get_all_people')
            ->middleware('abilities:erp_ac_view_expense');

        Route::get('/{id}', $apicontroller . '@get_people')
            ->middleware('abilities:erp_ac_view_expense');

        Route::get('/{id}/address', $apicontroller . '@get_people_address')
            ->middleware('abilities:erp_ac_view_expense');

        Route::get('/{id}/opening-balance', $apicontroller . '@get_opening_balance')
            ->middleware('abilities:erp_ac_view_expense');

        Route::get('/check-email', $apicontroller . '@check_people_email')
            ->middleware('abilities:erp_ac_view_expense');
    }
);

Route::group(
    ['prefix' => 'product-cats', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ProductCategoriesController';

        Route::get('/', $apicontroller . '@get_all_inventory_product_cats')
            ->middleware('abilities:erp_ac_manager');
        Route::post('/', $apicontroller . '@create_inventory_product_cat')
            ->middleware('abilities:erp_ac_manager');

        Route::get('/{id}', $apicontroller . '@get_inventory_product_cat')
            ->middleware('abilities:erp_ac_manager');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_inventory_product_cat')
            ->middleware('abilities:erp_ac_manager');
        Route::delete('/{id}', $apicontroller . '@delete_inventory_product_cat')
            ->middleware('abilities:erp_ac_manager');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete_cat')
            ->middleware('abilities:erp_ac_manager');
    }
);

Route::group(
    ['prefix' => 'products', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ProductsController';

        Route::get('/', $apicontroller . '@get_inventory_products')
            ->middleware('abilities:erp_ac_manager');
        Route::post('/', $apicontroller . '@create_inventory_products')
            ->middleware('abilities:erp_ac_manager');

        Route::get('/{id}', $apicontroller . '@get_inventory_product')
            ->middleware('abilities:erp_ac_manager');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_inventory_product')
            ->middleware('abilities:erp_ac_manager');
        Route::delete('/{id}', $apicontroller . '@delete_inventory_product')
            ->middleware('abilities:erp_ac_manager');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete')
            ->middleware('abilities:erp_ac_manager');

        Route::post('/csv/validate', $apicontroller . '@validate_csv_data')
            ->middleware('abilities:erp_ac_manager');

        Route::post('/csv/import', $apicontroller . '@import_products')
            ->middleware('abilities:erp_ac_manager');
    }
);

Route::group(
    ['prefix' => 'purchases', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PurchasesController';

        Route::get('/', $apicontroller . '@get_purchases')
            ->middleware('abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_purchase')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_purchase')
            ->middleware('abilities:erp_ac_view_expense');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_purchase')
            ->middleware('abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_purchase')
            ->middleware('abilities:erp_ac_publish_expenses_voucher');

        Route::get('/due/{id}', $apicontroller . '@due_purchases')
            ->middleware('abilities:erp_ac_create_expenses_voucher');
    }
);

Route::group(
    ['prefix' => 'payments', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PaymentController';

        Route::get('/', $apicontroller . '@get_payments')
            ->middleware('abilities:erp_ac_view_sale');
        Route::post('/', $apicontroller . '@create_payment')
            ->middleware('abilities:erp_ac_create_sales_payment');

        Route::get('/{id}', $apicontroller . '@get_payment')
            ->middleware('abilities:erp_ac_view_sales_summary');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_payment')
            ->middleware('abilities:erp_ac_create_sales_payment');

        Route::post('/{id}/void', $apicontroller . '@void_payment')
            ->middleware('abilities:erp_ac_create_sales_payment');
    }
);

Route::group(
    ['prefix' => 'reports', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ReportsController';

        Route::get('/trial-balance', $apicontroller . '@get_trial_balance')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/ledger-report', $apicontroller . '@get_ledger_report')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/sales-tax', $apicontroller . '@get_sales_tax_report')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/income-statement', $apicontroller . '@get_income_statement')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/balance-sheet', $apicontroller . '@get_balance_sheet')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/closest-fn-year', $apicontroller . '@get_closest_fn_year')
            ->middleware('abilities:erp_ac_view_sales_summary');
    }
);

Route::group(
    ['prefix' => 'tax-agencies', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxAgenciesController';

        Route::get('/', $apicontroller . '@get_tax_agencies')
            ->middleware('abilities:erp_ac_view_sale');
        Route::post('/', $apicontroller . '@create_tax_agency')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@get_tax_agency')
            ->middleware('abilities:erp_ac_view_sale');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_tax_agency')
            ->middleware('abilities:erp_ac_create_sales_invoice');
        Route::delete('/{id}', $apicontroller . '@delete_tax_agency')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/due/{id}', $apicontroller . '@get_agency_due')
            ->middleware('abilities:erp_ac_view_sale');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete')
            ->middleware('abilities:erp_ac_create_sales_invoice');
    }
);

Route::group(
    ['prefix' => 'tax-cats', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxCategoriesController';

        Route::get('/', $apicontroller . '@get_tax_cats')
            ->middleware('abilities:erp_ac_view_sale');
        Route::post('/', $apicontroller . '@create_tax_cat')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@get_tax_cat')
            ->middleware('abilities:erp_ac_view_sale');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_tax_cat')
            ->middleware('abilities:erp_ac_create_sales_invoice');
        Route::delete('/{id}', $apicontroller . '@delete_tax_cat')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete')
            ->middleware('abilities:erp_ac_create_sales_invoice');
    }
);

Route::group(
    ['prefix' => 'tax-rate-names', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxRateNamesController';

        Route::get('/', $apicontroller . '@get_tax_rate_names')
            ->middleware('abilities:erp_ac_view_sale');
        Route::post('/', $apicontroller . '@create_tax_rate_name')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@get_tax_rate_name')
            ->middleware('abilities:erp_ac_view_sale');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_tax_rate_name')
            ->middleware('abilities:erp_ac_create_sales_invoice');
        Route::delete('/{id}', $apicontroller . '@delete_tax_rate_name')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete')
            ->middleware('abilities:erp_ac_create_sales_invoice');
    }
);


Route::group(
    ['prefix' => 'taxes', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxesController';

        Route::get('/', $apicontroller . '@get_tax_rates')
            ->middleware('abilities:erp_ac_view_sale');
        Route::post('/', $apicontroller . '@create_tax_rate')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@get_tax_rate')
            ->middleware('abilities:erp_ac_view_sale');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_tax_rate')
            ->middleware('abilities:erp_ac_create_sales_invoice');
        Route::delete('/{id}', $apicontroller . '@delete_tax_rate')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::match(['post', 'put', 'patch'], '/{id}/quick-edit',  $apicontroller . '@quick_edit_tax_rate')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::match(['post', 'put', 'patch'], '/{id}/line-add',  $apicontroller . '@line_add_tax_rate')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::match(['post', 'put', 'patch'], '/{id}/line-edit',  $apicontroller . '@line_edit_tax_rate')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::delete('/{id}/line-delete', $apicontroller . '@line_delete_tax_rate')
            ->middleware('abilities:erp_ac_create_sales_invoice');

        Route::get('/tax-records', $apicontroller . '@get_tax_pay_records')
            ->middleware('abilities:erp_ac_view_sale');

        Route::get('/tax-records/{id}', $apicontroller . '@get_tax_pay_record')
            ->middleware('abilities:erp_ac_view_sale');

        Route::post('/pay-tax', $apicontroller . '@pay_tax')
            ->middleware('abilities:erp_ac_create_sales_payment');

        Route::get('/summary', $apicontroller . '@get_tax_summary')
            ->middleware('abilities:erp_ac_view_sale');
    }
);

Route::group(
    ['prefix' => 'transactions', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TransactionsController';

        Route::get('/{voucher_no}', $apicontroller . '@get_transaction_type')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/statuses', $apicontroller . '@get_trn_statuses')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/sales', $apicontroller . '@get_sales')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/expenses', $apicontroller . '@get_expenses')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/purchases', $apicontroller . '@get_purchases')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/sales/chart-status', $apicontroller . '@get_sales_chart_status')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/sales/chart-payment', $apicontroller . '@get_sales_chart_payment')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/income-expense-overview', $apicontroller . '@get_income_expense_overview')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/expense/chart-expense', $apicontroller . '@get_expense_chart_data')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/expense/chart-status', $apicontroller . '@get_expense_chart_status')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/purchase/chart-purchase', $apicontroller . '@get_purchase_chart_data')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/purchase/chart-status', $apicontroller . '@get_purchase_chart_status')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/payment-methods', $apicontroller . '@get_payment_methods')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/send-pdf/{id}', $apicontroller . '@send_as_pdf')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/people-chart/trn-amount/{id}', $apicontroller . '@get_people_trn_amount_data')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/people-chart/trn-status/{id}', $apicontroller . '@get_people_trn_status_data')
            ->middleware('abilities:erp_ac_view_sales_summary');

        Route::get('/voucher-type', $apicontroller . '@get_voucher_type')
            ->middleware('abilities:erp_ac_view_sales_summary');
    }
);


Route::group(
    ['prefix' => 'vendors', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'VendorsController';

        Route::get('/', $apicontroller . '@get_vendors')
            ->middleware('abilities:erp_ac_view_vendor');
        Route::post('/', $apicontroller . '@create_vendor')
            ->middleware('abilities:erp_ac_create_vendor');

        Route::get('/{id}', $apicontroller . '@get_vendor')
            ->middleware('abilities:erp_ac_view_vendor');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_vendor')
            ->middleware('abilities:erp_ac_edit_vendor');
        Route::delete('/{id}', $apicontroller . '@delete_vendor')
            ->middleware('abilities:erp_ac_delete_vendor');

        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete_vendors')
            ->middleware('abilities:erp_ac_delete_vendor');

        Route::get('/{id}/transactions', $apicontroller . '@get_transactions')
            ->middleware('abilities:erp_ac_view_vendor');

        Route::get('/{id}/transactions/filter', $apicontroller . '@filter_transactions')
            ->middleware('abilities:erp_ac_view_vendor');

        Route::get('/{id}/products', $apicontroller . '@get_vendor_products')
            ->middleware('abilities:erp_ac_view_vendor');
    }
);
