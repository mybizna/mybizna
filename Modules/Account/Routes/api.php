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
        $apicontroller = 'Modules\Account\Http\Controllers\AccountsController';

        Route::get('/', $apicontroller . '@get_accounts')
            ->middleware('sanctum.abilities:erp_ac_view_bank_accounts');

        Route::get('/{id}', $apicontroller . '@get_account')
            ->middleware('sanctum.abilities:erp_ac_view_bank_accounts');
        Route::delete('/{id}', $apicontroller . '@delete_account')
            ->middleware('sanctum.abilities:erp_ac_create_bank_transfer');

        Route::post('transfer/', $apicontroller . '@transfer_money')
            ->middleware('sanctum.abilities:erp_ac_create_bank_transfer');
        Route::get('/transfers/{id}', $apicontroller . '@get_single_transfer')
            ->middleware('sanctum.abilities:erp_ac_create_bank_transfer');
        Route::get('/transfers/list', $apicontroller . '@get_transfer_list')
            ->middleware('sanctum.abilities:erp_ac_create_bank_transfer');

        Route::get('/bank-accounts', $apicontroller . '@get_bank_accounts')
            ->middleware('sanctum.abilities:erp_ac_view_bank_accounts');

        Route::get('/cash-at-bank', $apicontroller . '@get_cash_at_bank')
            ->middleware('sanctum.abilities:erp_ac_view_bank_accounts');
    }
);

Route::group(
    ['prefix' => 'bills', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\BillsController';

        Route::get('/', $apicontroller . '@get_bills')
            ->middleware('sanctum.abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_bill')
            ->middleware('sanctum.abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_bill')
            ->middleware('sanctum.abilities:erp_ac_view_expense');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_bill')
            ->middleware('sanctum.abilities:erp_ac_view_expense');

        Route::get('/due/{id}', $apicontroller . '@due_bills')
            ->middleware('sanctum.abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_bill')
            ->middleware('sanctum.abilities:erp_ac_publish_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_overview_payables')
            ->middleware('sanctum.abilities:erp_ac_view_sales_summary');
    }
);

Route::group(
    ['prefix' => 'closing-balance', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::post('/', $apicontroller . '@close_balancesheet')
            ->middleware('sanctum.abilities:erp_ac_create_expenses_voucher');

        Route::get('/', $apicontroller . '@closest-fn-year')
            ->middleware('sanctum.abilities:erp_ac_view_expense');

        Route::get('/', $apicontroller . '@next-fn-year')
            ->middleware('sanctum.abilities:erp_ac_view_expense');
    }
);

Route::group(
    ['prefix' => 'company', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';


        Route::get('/', $apicontroller . '@get_company')
            ->middleware('sanctum.abilities:erp_ac_view_dashboard');
    }
);

Route::group(
    ['prefix' => 'currencies', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_currencies')
            ->middleware('sanctum.abilities:erp_ac_view_dashboard');
    }
);

Route::group(
    ['prefix' => 'customers', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_customers')
            ->middleware('sanctum.abilities:erp_ac_view_customer');
        Route::post('/', $apicontroller . '@create_customer')
            ->middleware('sanctum.abilities:erp_ac_create_customer');

        Route::get('/{id}', $apicontroller . '@get_customer')
            ->middleware('sanctum.abilities:erp_ac_view_customer');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_customer')
            ->middleware('sanctum.abilities:erp_ac_edit_customer');
        Route::delete('/{id}', $apicontroller . '@delete_customer')
            ->middleware('sanctum.abilities:erp_ac_delete_customer');


        Route::delete('/delete/{id}', $apicontroller . '@bulk_delete_customers')
            ->middleware('sanctum.abilities:erp_ac_delete_customer');

        Route::get('/{id}/transactions', $apicontroller . '@get_transactions')
            ->middleware('sanctum.abilities:erp_ac_view_customer');


        Route::get('/{id}/transactions/filter', $apicontroller . '@filter_transactions')
            ->middleware('sanctum.abilities:erp_ac_view_customer');

        Route::get('/country', $apicontroller . '@get_countries')
            ->middleware('sanctum.abilities:erp_ac_view_customer');
    }
);


Route::group(
    ['prefix' => 'employees', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_employees')
            ->middleware('sanctum.abilities:erp_view_list');

        Route::get('/{id}', $apicontroller . '@get_employee')
            ->middleware('sanctum.abilities:erp_list_employee');

        Route::get('/{id}/transactions', $apicontroller . '@get_transactions')
            ->middleware('sanctum.abilities:erp_view_list');
    }
);

Route::group(
    ['prefix' => 'expenses', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_expenses')
            ->middleware('sanctum.abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_expense')
            ->middleware('sanctum.abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_transactions')
            ->middleware('sanctum.abilities:erp_view_list');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_expense')
            ->middleware('sanctum.abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_expense')
            ->middleware('sanctum.abilities:erp_ac_publish_expenses_voucher');
        Route::get('/checks/{id}', $apicontroller . '@get_check')
            ->middleware('sanctum.abilities:erp_ac_view_expense');
    }
);

Route::group(
    ['prefix' => 'expenses', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_expenses')
            ->middleware('sanctum.abilities:erp_ac_view_expense');
        Route::post('/', $apicontroller . '@create_expense')
            ->middleware('sanctum.abilities:erp_ac_create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@get_transactions')
            ->middleware('sanctum.abilities:erp_view_list');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_expense')
            ->middleware('sanctum.abilities:erp_ac_create_expenses_voucher');

        Route::post('/{id}/void', $apicontroller . '@void_expense')
            ->middleware('sanctum.abilities:erp_ac_publish_expenses_voucher');
        Route::get('/checks/{id}', $apicontroller . '@get_check')
            ->middleware('sanctum.abilities:erp_ac_view_expense');
    }
);


Route::group(
    ['prefix' => 'invoices', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_invoices')
            ->middleware('sanctum.abilities:erp_ac_view_sale');
        Route::post('/', $apicontroller . '@create_invoice')
            ->middleware('sanctum.abilities:erp_ac_create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@get_invoice')
            ->middleware('sanctum.abilities:erp_ac_view_sales_summary');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_invoice')
            ->middleware('sanctum.abilities:erp_ac_create_sales_invoice');

        Route::post('/{id}/void', $apicontroller . '@void_invoice')
            ->middleware('sanctum.abilities:erp_ac_create_sales_invoice');

        Route::get('/due/{id}', $apicontroller . '@due_invoices')
            ->middleware('sanctum.abilities:erp_ac_create_sales_invoice');

        Route::post('/attachments', $apicontroller . '@upload_attachments')
            ->middleware('sanctum.abilities:erp_ac_create_sales_invoice');

        Route::get('/overview-receivable', $apicontroller . '@get_overview_receivables')
            ->middleware('sanctum.abilities:erp_ac_create_sales_invoice');
    }
);

Route::group(
    ['prefix' => 'journals', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_journals')
            ->middleware('sanctum.abilities:erp_ac_view_journal');

        Route::post('/', $apicontroller . '@create_journal')
            ->middleware('sanctum.abilities:erp_ac_create_journal');

        Route::get('/{id}', $apicontroller . '@get_journal')
            ->middleware('sanctum.abilities:erp_ac_view_journal');

        Route::get('/next', $apicontroller . '@get_next_journal_id')
            ->middleware('sanctum.abilities:erp_ac_view_journal');
    }
);

Route::group(
    ['prefix' => 'ledgers', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_all_ledger_accounts')
            ->middleware('sanctum.abilities:erp_ac_view_account_lists');
        Route::post('/', $apicontroller . '@create_ledger_account')
            ->middleware('sanctum.abilities:erp_ac_create_account');

        Route::get('/{id}', $apicontroller . '@get_ledger_account')
            ->middleware('sanctum.abilities:erp_ac_view_single_account');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@update_ledger_account')
            ->middleware('sanctum.abilities:erp_ac_edit_account');
        Route::delete('/{id}', $apicontroller . '@delete_ledger_account')
            ->middleware('sanctum.abilities:erp_ac_delete_account');

        Route::get('/{id}/accounts', $apicontroller . '@get_ledger_accounts_by_chart')
            ->middleware('sanctum.abilities:erp_ac_view_account_lists');

        Route::get('/accounts', $apicontroller . '@get_chart_accounts')
            ->middleware('sanctum.abilities:erp_ac_view_account_lists');

        Route::get('/bank-accounts', $apicontroller . '@get_bank_accounts')
            ->middleware('sanctum.abilities:erp_ac_view_account_lists');

        Route::get('/cash-accounts', $apicontroller . '@get_cash_accounts')
            ->middleware('sanctum.abilities:erp_ac_view_account_lists');
        /*
        Route::get('/categories/{id}', $apicontroller . '@get_ledger_categories')
        ->middleware('sanctum.abilities:erp_ac_view_account_lists');
        Route::post('/categories/{id}', $apicontroller . '@create_ledger_category')
        ->middleware('sanctum.abilities:erp_ac_create_account');
        Route::match(['post', 'put', 'patch'], '/categories/{id}',  $apicontroller . '@update_ledger_category')
        ->middleware('sanctum.abilities:erp_ac_edit_account');
        Route::delete('/categories/{id}', $apicontroller . '@delete_ledger_category')
        ->middleware('sanctum.abilities:erp_ac_delete_account');
        */
    }
);

Route::group(
    ['prefix' => 'opening-balances', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'Modules\Account\Http\Controllers\ClosingBalanceController';

        Route::get('/', $apicontroller . '@get_opening_balances')
            ->middleware('sanctum.abilities:erp_ac_view_journal');
        Route::post('/', $apicontroller . '@create_opening_balance')
            ->middleware('sanctum.abilities:erp_ac_create_journal');
    }
);
