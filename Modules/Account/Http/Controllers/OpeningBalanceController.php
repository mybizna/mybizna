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

        $args['number'] = !empty($request['per_page']) ? $request['per_page'] : 20;
        $args['offset'] = ($request['per_page'] * ($request['page'] - 1));

        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $items       = $obalance->getAllOpeningBalances($args);
        $total_items = $obalance->getAllOpeningBalances(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        $formatted_items = [];

        foreach ($items as $item) {
            $data              = $this->prepareItemForResponse($item, $request, $additional_fields);
            $formatted_items[] = $this->prepareResponseForCollection($data);
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

        $id                = (int) $request['id'];
        $additional_fields = [];

        if (empty($id)) {
            messageBag()->add('rest_opening_balance_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return;
        }

        $ledgers = $obalance->getAllOpeningBalances($id);

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        foreach ($ledgers as $ledger) {
            if (7 === $ledger['chart_id']) {
                $ledger['bank']['id']   = $ledger['ledger_id'];
                $ledger['bank']['name'] = $ledger['name'];
            }
            $data              = $this->prepareItemForResponse($ledger, $request, $additional_fields);
            $formatted_items[] = $this->prepareResponseForCollection($data);
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


        $id                = (int) $request['id'];
        $additional_fields = [];

        if (empty($id)) {
            messageBag()->add('rest_opening_balance_invalid_id', __('Invalid resource id.'), ['status' => 404]);
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

        $id                = (int) $request['id'];
        $additional_fields = [];

        if (empty($id)) {
            messageBag()->add('rest_opening_balance_invalid_id', __('Invalid resource id.'), ['status' => 404]);
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

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $item = $open_balance->getOpeningBalanceNames();

        return response()->json($item);
    }

    /**
     * Create a opening_balance
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function createOpeningBalance(Request $request)
    {
        $obalance = new OpeningBalances();

        $opening_balance_data = $this->prepareItemFDatabase($request);

        $items = $opening_balance_data['ledgers'];

        $ledgers  = [];
        $total_dr = 0;
        $total_cr = 0;

        $total_dr = (isset($request['total_dr']) ? $request['total_dr'] : 0);
        $total_cr = (isset($request['total_dr']) ? $request['total_dr'] : 0);

        if ($total_dr !== $total_cr) {
            messageBag()->add('rest_opening_balance_invalid_amount', __('Summation of debit and credit must be equal.'), ['status' => 400]);
            return;
        }

        $opening_balance_data['amount'] = $total_dr;

        $opening_balance = $obalance->getVirtualAcct($opening_balance_data);

        $this->addLog($opening_balance_data, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

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

        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $acc_pay_rec = [];

        $acc_pay_rec['invoice_acc']       = $open_balance->getOpbInvoiceAccountDetails($request['start_date']);
        $acc_pay_rec['bill_purchase_acc'] = $this->getOpbBillPurchaseAccountDetails($request['start_date']);

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

        if (isset($request['year'])) {
            $prepared_item['year'] = $request['year'];
        }

        if (isset($request['ledgers'])) {
            $prepared_item['ledgers'] = $request['ledgers'];
        }

        if (isset($request['description'])) {
            $prepared_item['description'] = $request['description'];
        }

        if (isset($request['acct_pay'])) {
            $prepared_item['acct_pay'] = $request['acct_pay'];
        }

        if (isset($request['acct_rec'])) {
            $prepared_item['acct_rec'] = $request['acct_rec'];
        }

        if (isset($request['tax_pay'])) {
            $prepared_item['tax_pay'] = $request['tax_pay'];
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
