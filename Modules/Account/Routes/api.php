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

        Route::get('/', $apicontroller . '@getccounts')
            ->middleware('abilities:view_bank_accounts');

        Route::get('/{id}', $apicontroller . '@getAccount')
            ->middleware('abilities:view_bank_accounts')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteAccount')
            ->middleware('abilities:create_bank_transfer')->where('id', '[0-9]+');

        Route::post('transfer/', $apicontroller . '@transferMoney')
            ->middleware('abilities:create_bank_transfer');
        Route::get('/transfers/{id}', $apicontroller . '@getSingleTransfer')
            ->middleware('abilities:create_bank_transfer')->where('id', '[0-9]+');
        Route::get('/transfers/list', $apicontroller . '@getTransferList')
            ->middleware('abilities:create_bank_transfer');

        Route::get('/bank-accounts', $apicontroller . '@getBankAccounts')
            ->middleware('abilities:view_bank_accounts');

        Route::get('/cash-at-bank', $apicontroller . '@get_cash_at_bank')
            ->middleware('abilities:view_bank_accounts');
    }
);

Route::group(
    ['prefix' => 'bills', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'BillsController';

        Route::get('/', $apicontroller . '@getBills')
            ->middleware('abilities:view_expense');
        Route::post('/', $apicontroller . '@createBill')
            ->middleware('abilities:create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@getBill')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateBill')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');

        Route::get('/due/{id}', $apicontroller . '@dueBills')
            ->middleware('abilities:create_expenses_voucher')->where('id', '[0-9]+');

        Route::post('/{id}/void', $apicontroller . '@voidBill')
            ->middleware('abilities:publish_expenses_voucher')->where('id', '[0-9]+');

        Route::get('/{id}', $apicontroller . '@getOverviewPayables')
            ->middleware('abilities:view_sales_summary')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'closing-balance', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ClosingBalanceController';

        Route::post('/', $apicontroller . '@closeBalancesheet')
            ->middleware('abilities:create_expenses_voucher');

        Route::get('/', $apicontroller . '@closestFnYear')
            ->middleware('abilities:view_expense');

        Route::get('/', $apicontroller . '@nextFnYear')
            ->middleware('abilities:view_expense');
    }
);

Route::group(
    ['prefix' => 'company', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'CompanyController';

        Route::get('/', $apicontroller . '@getCompany')
            ->middleware('abilities:view_dashboard');
    }
);

Route::group(
    ['prefix' => 'currencies', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'CurrenciesController';

        Route::get('/', $apicontroller . '@getCurrencies')
            ->middleware('abilities:view_dashboard');
    }
);

Route::group(
    ['prefix' => 'customers', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'CustomersController';


        Route::get('/', $apicontroller . '@getCustomers')
            ->middleware('abilities:view_customer');
        Route::post('/', $apicontroller . '@createCustomer')
            ->middleware('abilities:create_customer');

        Route::get('/{id}', $apicontroller . '@getCustomer')
            ->middleware('abilities:view_customer')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateCustomer')
            ->middleware('abilities:edit_customer')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteCustomer')
            ->middleware('abilities:delete_customer')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDeleteCustomers')
            ->middleware('abilities:delete_customer')->where('id', '[0-9]+');

        Route::get('/{id}/transactions', $apicontroller . '@getTransactions')
            ->middleware('abilities:view_customer')->where('id', '[0-9]+');


        Route::get('/{id}/transactions/filter', $apicontroller . '@filterTransactions')
            ->middleware('abilities:view_customer')->where('id', '[0-9]+');

        Route::get('/country', $apicontroller . '@getCountries')
            ->middleware('abilities:view_customer');
    }
);


Route::group(
    ['prefix' => 'employees', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'EmployeesController';

        Route::get('/', $apicontroller . '@getEmployees')
            ->middleware('abilities:view_list');

        Route::get('/{id}', $apicontroller . '@getEmployee')
            ->middleware('abilities:list_employee')->where('id', '[0-9]+');

        Route::get('/{id}/transactions', $apicontroller . '@getTransactions')
            ->middleware('abilities:view_list')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'expenses', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ExpensesController';

        Route::get('/', $apicontroller . '@getExpenses')
            ->middleware('abilities:view_expense');
        Route::post('/', $apicontroller . '@createExpense')
            ->middleware('abilities:create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@getTransactions')
            ->middleware('abilities:view_list')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateExpense')
            ->middleware('abilities:create_expenses_voucher')->where('id', '[0-9]+');

        Route::post('/{id}/void', $apicontroller . '@voidExpense')
            ->middleware('abilities:publish_expenses_voucher')->where('id', '[0-9]+');
        Route::get('/checks/{id}', $apicontroller . '@getCheck')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');
    }
);


Route::group(
    ['prefix' => 'invoices', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'InvoicesController';

        Route::get('/', $apicontroller . '@getInvoices')
            ->middleware('abilities:view_sale');
        Route::post('/', $apicontroller . '@createInvoice')
            ->middleware('abilities:create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@getInvoice')
            ->middleware('abilities:view_sales_summary')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateInvoice')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::post('/{id}/void', $apicontroller . '@voidInvoice')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::get('/due/{id}', $apicontroller . '@dueInvoices')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::post('/attachments', $apicontroller . '@uploadAttachments')
            ->middleware('abilities:create_sales_invoice');

        Route::get('/overview-receivable', $apicontroller . '@getOverviewReceivables')
            ->middleware('abilities:create_sales_invoice');
    }
);

Route::group(
    ['prefix' => 'journals', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'JournalsController';

        Route::get('/', $apicontroller . '@getJournals')
            ->middleware('abilities:view_journal');

        Route::post('/', $apicontroller . '@createJournal')
            ->middleware('abilities:create_journal');

        Route::get('/{id}', $apicontroller . '@getJournal')
            ->middleware('abilities:view_journal')->where('id', '[0-9]+');

        Route::get('/next', $apicontroller . '@getNextJournalId')
            ->middleware('abilities:view_journal');
    }
);

Route::group(
    ['prefix' => 'ledgers', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'LedgersController';

        Route::get('/', $apicontroller . '@getAllLedgerAccounts')
            ->middleware('abilities:view_account_lists');
        Route::post('/', $apicontroller . '@createLedgerAccount')
            ->middleware('abilities:create_account');

        Route::get('/{id}', $apicontroller . '@getLedgerAccount')
            ->middleware('abilities:view_single_account')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateLedgerAccount')
            ->middleware('abilities:edit_account')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteLedgerAccount')
            ->middleware('abilities:delete_account')->where('id', '[0-9]+');

        Route::get('/{id}/accounts', $apicontroller . '@getLedgerAccountsByChart')
            ->middleware('abilities:view_account_lists')->where('id', '[0-9]+');

        Route::get('/accounts', $apicontroller . '@getChartAccounts')
            ->middleware('abilities:view_account_lists');

        Route::get('/bank-accounts', $apicontroller . '@getBankAccounts')
            ->middleware('abilities:view_account_lists');

        Route::get('/cash-accounts', $apicontroller . '@getCashAccounts')
            ->middleware('abilities:view_account_lists');
        /*
        Route::get('/categories/{id}', $apicontroller . '@get_ledger_categories')
        ->middleware('abilities:view_account_lists')->where('id', '[0-9]+');
        Route::post('/categories/{id}', $apicontroller . '@create_ledger_category')
        ->middleware('abilities:create_account')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/categories/{id}',  $apicontroller . '@update_ledger_category')
        ->middleware('abilities:edit_account')->where('id', '[0-9]+');
        Route::delete('/categories/{id}', $apicontroller . '@delete_ledger_category')
        ->middleware('abilities:delete_account')->where('id', '[0-9]+');
        */
    }
);

Route::group(
    ['prefix' => 'opening-balances', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'OpeningBalanceController';

        Route::get('/', $apicontroller . '@getOpeningBalances')
            ->middleware('abilities:view_journal');
        Route::post('/', $apicontroller . '@createOpeningBalance')
            ->middleware('abilities:create_journal');

        Route::get('/names', $apicontroller . '@getOpeningBalanceNames')
            ->middleware('abilities:view_journal');

        Route::get('/{id}', $apicontroller . '@getOpeningBalance')
            ->middleware('abilities:view_journal')->where('id', '[0-9]+');

        Route::get('/virtual-accts/{id}', $apicontroller . '@getVirtualAcctsByYear')
            ->middleware('abilities:view_journal')->where('id', '[0-9]+');


        Route::get('/acc-payable-receivable', $apicontroller . '@getAccPayableReceivable')
            ->middleware('abilities:view_journal');
    }
);


Route::group(
    ['prefix' => 'pay-bills', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PayBillsController';

        Route::get('/', $apicontroller . '@getPayBills')
            ->middleware('abilities:view_expense');
        Route::post('/', $apicontroller . '@createPayBill')
            ->middleware('abilities:create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@getPayBill')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updatePayBill')
            ->middleware('abilities:create_expenses_voucher')->where('id', '[0-9]+');

        Route::post('/{id}/void', $apicontroller . '@voidPayBill')
            ->middleware('abilities:publish_expenses_voucher')->where('id', '[0-9]+');
    }
);


Route::group(
    ['prefix' => 'pay-purchases', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PayPurchasesController';

        Route::get('/', $apicontroller . '@getPayPurchases')
            ->middleware('abilities:view_expense');
        Route::post('/', $apicontroller . '@createPayPurchase')
            ->middleware('abilities:create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@getPayPurchase')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updatePayPurchase')
            ->middleware('abilities:create_expenses_voucher')->where('id', '[0-9]+');

        Route::post('/{id}/void', $apicontroller . '@voidPayPurchase')
            ->middleware('abilities:publish_expenses_voucher')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'people', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PeopleController';

        Route::get('/', $apicontroller . '@getAllPeople')
            ->middleware('abilities:view_expense');

        Route::get('/{id}', $apicontroller . '@getPeople')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');

        Route::get('/{id}/address', $apicontroller . '@getPeopleAddress')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');

        Route::get('/{id}/opening-balance', $apicontroller . '@getOpeningBalance')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');

        Route::get('/check-email', $apicontroller . '@checkPeopleEmail')
            ->middleware('abilities:view_expense');
    }
);

Route::group(
    ['prefix' => 'product-cats', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ProductCategoriesController';

        Route::get('/', $apicontroller . '@getAllInventoryProductCats')
            ->middleware('abilities:manager');
        Route::post('/', $apicontroller . '@createInventoryProductCat')
            ->middleware('abilities:manager');

        Route::get('/{id}', $apicontroller . '@getInventoryProductCat')
            ->middleware('abilities:manager')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateInventoryProductCat')
            ->middleware('abilities:manager')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteInventoryProductCat')
            ->middleware('abilities:manager')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDeleteCat')
            ->middleware('abilities:manager')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'products', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ProductsController';

        Route::get('/', $apicontroller . '@getInventoryProducts')
            ->middleware('abilities:manager');
        Route::post('/', $apicontroller . '@createInventoryProducts')
            ->middleware('abilities:manager');

        Route::get('/{id}', $apicontroller . '@getInventoryProduct')
            ->middleware('abilities:manager')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateInventoryProduct')
            ->middleware('abilities:manager')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteInventoryProduct')
            ->middleware('abilities:manager')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDelete')
            ->middleware('abilities:manager')->where('id', '[0-9]+');

        Route::post('/csv/validate', $apicontroller . '@validateCsvData')
            ->middleware('abilities:manager');

        Route::post('/csv/import', $apicontroller . '@importProducts')
            ->middleware('abilities:manager');
    }
);

Route::group(
    ['prefix' => 'purchases', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PurchasesController';

        Route::get('/', $apicontroller . '@getPurchases')
            ->middleware('abilities:view_expense');
        Route::post('/', $apicontroller . '@createPurchase')
            ->middleware('abilities:create_expenses_voucher');

        Route::get('/{id}', $apicontroller . '@getPurchase')
            ->middleware('abilities:view_expense')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updatePurchase')
            ->middleware('abilities:create_expenses_voucher')->where('id', '[0-9]+');

        Route::post('/{id}/void', $apicontroller . '@voidPurchase')
            ->middleware('abilities:publish_expenses_voucher')->where('id', '[0-9]+');

        Route::get('/due/{id}', $apicontroller . '@duePurchases')
            ->middleware('abilities:create_expenses_voucher')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'payments', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'PaymentController';

        Route::get('/', $apicontroller . '@getPayments')
            ->middleware('abilities:view_sale');
        Route::post('/', $apicontroller . '@createPayment')
            ->middleware('abilities:create_sales_payment');

        Route::get('/{id}', $apicontroller . '@getPayment')
            ->middleware('abilities:view_sales_summary')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updatePayment')
            ->middleware('abilities:create_sales_payment')->where('id', '[0-9]+');

        Route::post('/{id}/void', $apicontroller . '@voidPayment')
            ->middleware('abilities:create_sales_payment')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'reports', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'ReportsController';

        Route::get('/trial-balance', $apicontroller . '@getTrialBalance')
            ->middleware('abilities:view_sales_summary');

        Route::get('/ledger-report', $apicontroller . '@getLedgerReport')
            ->middleware('abilities:view_sales_summary');

        Route::get('/sales-tax', $apicontroller . '@getSalesTaxReport')
            ->middleware('abilities:view_sales_summary');

        Route::get('/income-statement', $apicontroller . '@getIncomeStatement')
            ->middleware('abilities:view_sales_summary');

        Route::get('/balance-sheet', $apicontroller . '@getBalanceSheet')
            ->middleware('abilities:view_sales_summary');

        Route::get('/closest-fn-year', $apicontroller . '@getClosestFnYear')
            ->middleware('abilities:view_sales_summary');
    }
);

Route::group(
    ['prefix' => 'tax-agencies', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxAgenciesController';

        Route::get('/', $apicontroller . '@getTaxAgencies')
            ->middleware('abilities:view_sale');
        Route::post('/', $apicontroller . '@createTaxAgency')
            ->middleware('abilities:create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@getTaxAgency')
            ->middleware('abilities:view_sale')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateTaxAgency')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteTaxAgency')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::get('/due/{id}', $apicontroller . '@getAgencyDue')
            ->middleware('abilities:view_sale')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDelete')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'tax-cats', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxCategoriesController';

        Route::get('/', $apicontroller . '@getTaxCats')
            ->middleware('abilities:view_sale');
        Route::post('/', $apicontroller . '@createTaxCat')
            ->middleware('abilities:create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@getTaxCat')
            ->middleware('abilities:view_sale')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateTaxCat')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteTaxCat')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDelete')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');
    }
);

Route::group(
    ['prefix' => 'tax-rate-names', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxRateNamesController';

        Route::get('/', $apicontroller . '@getTaxRateNames')
            ->middleware('abilities:view_sale');
        Route::post('/', $apicontroller . '@createTaxRateName')
            ->middleware('abilities:create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@getTaxRateName')
            ->middleware('abilities:view_sale')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateTaxRateName')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteTaxRateName')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDelete')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');
    }
);


Route::group(
    ['prefix' => 'taxes', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TaxesController';

        Route::get('/', $apicontroller . '@getTaxRates')
            ->middleware('abilities:view_sale');
        Route::post('/', $apicontroller . '@createTaxRate')
            ->middleware('abilities:create_sales_invoice');

        Route::get('/{id}', $apicontroller . '@getTaxRate')
            ->middleware('abilities:view_sale')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateTaxRate')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteTaxRate')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDelete')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::match(['post', 'put', 'patch'], '/{id}/quick-edit',  $apicontroller . '@quickEditTaxRate')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::match(['post', 'put', 'patch'], '/{id}/line-add',  $apicontroller . '@lineAddTaxRate')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::match(['post', 'put', 'patch'], '/{id}/line-edit',  $apicontroller . '@lineEditTaxRate')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::delete('/{id}/line-delete', $apicontroller . '@lineDeleteTaxRate')
            ->middleware('abilities:create_sales_invoice')->where('id', '[0-9]+');

        Route::get('/tax-records', $apicontroller . '@getTaxPayRecords')
            ->middleware('abilities:view_sale');

        Route::get('/tax-records/{id}', $apicontroller . '@getTaxPayRecord')
            ->middleware('abilities:view_sale')->where('id', '[0-9]+');

        Route::post('/pay-tax', $apicontroller . '@payTax')
            ->middleware('abilities:create_sales_payment');

        Route::get('/summary', $apicontroller . '@getTaxSummary')
            ->middleware('abilities:view_sale');
    }
);

Route::group(
    ['prefix' => 'transactions', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'TransactionsController';

        Route::get('/{voucher_no}', $apicontroller . '@getTransactionType')
            ->middleware('abilities:view_sales_summary')->where('id', '[0-9]+');

        Route::get('/statuses', $apicontroller . '@getTrnStatuses')
            ->middleware('abilities:view_sales_summary');

        Route::get('/sales', $apicontroller . '@getSales')
            ->middleware('abilities:view_sales_summary');

        Route::get('/expenses', $apicontroller . '@getExpenses')
            ->middleware('abilities:view_sales_summary');

        Route::get('/purchases', $apicontroller . '@getPurchases')
            ->middleware('abilities:view_sales_summary');

        Route::get('/sales/chart-status', $apicontroller . '@getSalesChartStatus')
            ->middleware('abilities:view_sales_summary');

        Route::get('/sales/chart-payment', $apicontroller . '@getSalesChartPayment')
            ->middleware('abilities:view_sales_summary');

        Route::get('/income-expense-overview', $apicontroller . '@getIncomeExpenseOverview')
            ->middleware('abilities:view_sales_summary');

        Route::get('/expense/chart-expense', $apicontroller . '@getExpenseChartData')
            ->middleware('abilities:view_sales_summary');

        Route::get('/expense/chart-status', $apicontroller . '@getExpenseChartStatus')
            ->middleware('abilities:view_sales_summary');

        Route::get('/purchase/chart-purchase', $apicontroller . '@getPurchaseChartData')
            ->middleware('abilities:view_sales_summary');

        Route::get('/purchase/chart-status', $apicontroller . '@getPurchaseChartStatus')
            ->middleware('abilities:view_sales_summary');

        Route::get('/payment-methods', $apicontroller . '@getPaymentMethods')
            ->middleware('abilities:view_sales_summary');

        Route::get('/send-pdf/{id}', $apicontroller . '@sendAsPdf')
            ->middleware('abilities:view_sales_summary')->where('id', '[0-9]+');

        Route::get('/people-chart/trn-amount/{id}', $apicontroller . '@getPeopleTrnAmountData')
            ->middleware('abilities:view_sales_summary')->where('id', '[0-9]+');

        Route::get('/people-chart/trn-status/{id}', $apicontroller . '@getPeopleTrnStatusData')
            ->middleware('abilities:view_sales_summary')->where('id', '[0-9]+');

        Route::get('/voucher-type', $apicontroller . '@getVoucherType')
            ->middleware('abilities:view_sales_summary');
    }
);


Route::group(
    ['prefix' => 'vendors', 'middleware' => ['auth:sanctum']],
    function () {
        $apicontroller = 'VendorsController';

        Route::get('/', $apicontroller . '@getVendors')
            ->middleware('abilities:view_vendor');
        Route::post('/', $apicontroller . '@createVendor')
            ->middleware('abilities:create_vendor');

        Route::get('/{id}', $apicontroller . '@getVendor')
            ->middleware('abilities:view_vendor')->where('id', '[0-9]+');
        Route::match(['post', 'put', 'patch'], '/{id}',  $apicontroller . '@updateVendor')
            ->middleware('abilities:edit_vendor')->where('id', '[0-9]+');
        Route::delete('/{id}', $apicontroller . '@deleteVendor')
            ->middleware('abilities:delete_vendor')->where('id', '[0-9]+');

        Route::delete('/delete/{id}', $apicontroller . '@bulkDeleteVendors')
            ->middleware('abilities:delete_vendor')->where('id', '[0-9]+');

        Route::get('/{id}/transactions', $apicontroller . '@getTransactions')
            ->middleware('abilities:view_vendor')->where('id', '[0-9]+');

        Route::get('/{id}/transactions/filter', $apicontroller . '@filterTransactions')
            ->middleware('abilities:view_vendor')->where('id', '[0-9]+');

        Route::get('/{id}/products', $apicontroller . '@getVendorProducts')
            ->middleware('abilities:view_vendor')->where('id', '[0-9]+');
    }
);
