<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Account\Classes\OpeningBalances;

use Illuminate\Support\Facades\DB;

class OpeningBalanceController extends Controller
{

    /**
     * Get a collection of opening_balances
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getOpeningBalances(Request $request)
    {
        $obalance = new OpeningBalances();
        $input = $request->all();

        $args['number'] = !empty($input['per_page']) ? $input['per_page'] : 20;
        $args['offset'] = ($input['per_page'] * ($input['page'] - 1));

        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $items       = $obalance->getAllOpeningBalances($args);
        $total_items = $obalance->getAllOpeningBalances(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        $formatted_items = [];

        foreach ($items as $item) {
            $formatted_items[]              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get opening balances of a year
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getOpeningBalance(Request $request)
    {

        $obalance = new OpeningBalances();
        $input = $request->all();

        $id                = (int) $input['id'];
        $additional_fields = [];

        if (empty($id)) {
            messageBag('rest_opening_balance_invalid_id', __('Invalid resource id.'));
            return;
        }

        $ledgers = $obalance->getAllOpeningBalances($id);

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        foreach ($ledgers as $ledger) {
            if (7 === $ledger['chart_id']) {
                $ledger['bank']['id']   = $ledger['ledger_id'];
                $ledger['bank']['name'] = $ledger['name'];
            }
            $formatted_items[]              = $this->prepareItemForResponse($ledger, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get number of entries of a financial year
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getOpeningBalanceCountByFy(Request $request)
    {
        $input = $request->all();

        $id                = (int) $input['id'];
        $additional_fields = [];

        if (empty($id)) {
            messageBag('rest_opening_balance_invalid_id', __('Invalid resource id.'));
            return;
        }

        $result = DB::select("select count(*) as num from account_opening_balance where financial_year_id = %d", [$id]);
        $result = (!empty($result)) ? $result[0] : null;

        return response()->json($result->num);
    }

    /**
     * Get a virtual accounts of a year
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getVirtualAcctsByYear(Request $request)
    {
        $open_balances = new OpeningBalances();
        $input = $request->all();

        $id                = (int) $input['id'];
        $additional_fields = [];

        if (empty($id)) {
            messageBag('rest_opening_balance_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $open_balances->getVirtualAcct($id);

        return response()->json($item);
    }

    /**
     * Get a collection of opening_balance_names
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getOpeningBalanceNames(Request $request)
    {
        $open_balance = new OpeningBalances();

        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $item = $open_balance->getOpeningBalanceNames();

        return response()->json($item);
    }

    /**
     * Create a opening_balance
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function createOpeningBalance(Request $request)
    {
        $obalance = new OpeningBalances();
        $input = $request->all();

        $opening_balance_data = $this->prepareItemFDatabase($request);

        $items = $opening_balance_data['ledgers'];

        $ledgers  = [];
        $total_dr = 0;
        $total_cr = 0;

        $total_dr = (isset($input['total_dr']) ? $input['total_dr'] : 0);
        $total_cr = (isset($input['total_dr']) ? $input['total_dr'] : 0);

        if ($total_dr !== $total_cr) {
            messageBag('rest_opening_balance_invalid_amount', __('Summation of debit and credit must be equal.'), ['status' => 400]);
            return;
        }

        $opening_balance_data['amount'] = $total_dr;

        $opening_balance = $obalance->getVirtualAcct($opening_balance_data);

        $this->addLog($opening_balance_data, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $response = $this->prepareItemForResponse($opening_balance, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Get account payable & receivable
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccPayableReceivable(Request $request)
    {
        $open_balance = new OpeningBalances();
        $input = $request->all();
        

        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $acc_pay_rec = [];

        $acc_pay_rec['invoice_acc']       = $open_balance->getOpbInvoiceAccountDetails($input['start_date']);
        $acc_pay_rec['bill_purchase_acc'] = $this->getOpbBillPurchaseAccountDetails($input['start_date']);

        return response()->json($acc_pay_rec);
    }

    /**
     * Log when opening balance is created
     *
     * @param $data
     * @param $action
     */
    public function addLog($data, $action)
    {
        $data = (array) $data;
    }

    /**
     * Prepare a single item for create or update
     *
     * @param \Illuminate\Http\Request $request request object
     *
     * @return array $prepared_item
     */
    protected function prepareItemFDatabase(Request $request)
    {
        $prepared_item = [];

        $input = $request->all();

        if (isset($input['year'])) {
            $prepared_item['year'] = $input['year'];
        }

        if (isset($input['ledgers'])) {
            $prepared_item['ledgers'] = $input['ledgers'];
        }

        if (isset($input['description'])) {
            $prepared_item['description'] = $input['description'];
        }

        if (isset($input['acct_pay'])) {
            $prepared_item['acct_pay'] = $input['acct_pay'];
        }

        if (isset($input['acct_rec'])) {
            $prepared_item['acct_rec'] = $input['acct_rec'];
        }

        if (isset($input['tax_pay'])) {
            $prepared_item['tax_pay'] = $input['tax_pay'];
        }

        return $prepared_item;
    }

    /**
     * Prepare output for response
     *
     * @param array|object    $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $item = (array) $item;

        $data = array_merge($item, $additional_fields);


        return $data;
    }

    /**
     * Get currency's schema, conforming to JSON Schema
     *
     * @return array
     */
    public function getItemSchema()
    {
        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'opening_balance',
            'type'       => 'object',
            'properties' => [
                'id'      => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'year'    => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'ledgers' => [
                    'description' => __('Ledger names for the resource.'),
                    'type'        => 'array',
                    'context'     => ['edit'],
                ],
                'acct_pay' => [
                    'description' => __('Ledger names for the resource.'),
                    'type'        => 'array',
                    'context'     => ['edit'],
                ],
                'acct_rec' => [
                    'description' => __('Ledger names for the resource.'),
                    'type'        => 'array',
                    'context'     => ['edit'],
                ],
                'tax_pay' => [
                    'description' => __('Ledger names for the resource.'),
                    'type'        => 'array',
                    'context'     => ['edit'],
                ],
                'total_dr'      => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'number',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'total_cr'      => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'number',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'description'      => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'string',
                    'context'     => ['embed', 'view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ],
        ];

        return $schema;
    }
}
