<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;

use Modules\Account\Classes\Bank;

use Modules\Account\Classes\LedgerAccounts;

use Modules\Account\Classes\Reports\TrialBalance;
use Modules\Account\Classes\OpeningBalances;

use Illuminate\Support\Facades\DB;

class LedgersController extends Controller
{
    /**
     * Get all the ledgers of a particular chart_id
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllLedgerAccounts(Request $request)
    {
        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $ledgers = $this->getLedgersWithBalances();

        foreach ($ledgers as $ledger) {
            $formatted_items[]              = $this->prepareLedgerForResponse($ledger, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get all the ledgers of a particular chart_id
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getLedgerAccountsByChart(Request $request)
    {
        $ledger = new LedgerAccounts();
        $id = $request['chart_id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_empty_chart_id', __('Chart ID is Empty.'));
            return;
        }

        $items = $ledger->getLedgersByChartId($id);

        return response()->json($items);
    }

    /**
     * Get a specific ledger
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getLedgerAccount(Request $request)
    {
        $ledger = new LedgerAccounts();

        $items = [];

        $id = (int) $request['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_ledger_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $ledger->getLedger($id);

        $result   = $this->prepareItemForResponse($item, $request);
        return response()->json($item);
    }

    /**
     * Create an ledger
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function createLedgerAccount(Request $request)
    {
        $ledger = new LedgerAccounts();


        $exist = DB::scalar("SELECT name FROM account_ledger WHERE name = %s", [$request['name']]);

        if ($exist) {
            config('kernel.messageBag')->add('rest_ledger_name_already_exist', __('Name already exist.'));
            return;
        }

        $item = $this->prepareItemFDatabase($request);

        $result = $ledger->insertLedger($item);

        $this->addLog((array) $result, 'add');

        $request->set_param('context', 'edit');
        $response = $this->prepareItemForResponse($result, $request);
        return response()->json($response);

    }

    /**
     * Update an ledger
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function updateLedgerAccount(Request $request)
    {
        $ledger = new LedgerAccounts();


        $id = (int) $request['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_ledger_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $this->prepareItemFDatabase($request);

        $old_data = $ledger->getLedger($id);

        $result = $ledger->updateLedger($item, $id);

        $this->addLog($item, 'edit', $old_data);

        $request->set_param('context', 'edit');
        $response = $this->prepareItemForResponse($result, $request);
        return response()->json($response);

    }

    /**
     * Delete an account
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function deleteLedgerAccount(Request $request)
    {
        $ledger = new LedgerAccounts();


        $id = (int) $request['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_ledger_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $ledger->getLedger($id);

        DB::table("account_ledger")->where([['id' => $id]])->delete();

        $this->addLog($item, 'delete');

        return response()->json(['status' => true]);
    }

    /**
     * Get chart of accounts
     *
     * @param WP_REST_REQUEST $request
     *
     * @return WP_ERROR|WP_REST_REQUEST
     */
    public function getChartAccounts(Request $request)
    {
        $ledger = new LedgerAccounts();
        $accounts = $ledger->getAllCharts();

        return response()->json($accounts);
    }

    /**
     * Get a collection of bank accounts
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getBankAccounts(Request $request)
    {
        $bank = new Bank();

        $items = $bank->getBanks(true, false, false);

        if (empty($items)) {
            config('kernel.messageBag')->add('rest_empty_accounts', __('Bank accounts are empty.'));
            return;
        }

        $formatted_items = [];

        foreach ($items as $item) {
            $additional_fields = [];

            $formatted_items[]              = $this->prepareBankItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get cash accounts
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashAccounts(Request $request)
    {
        $trialbal = new TrialBalance();
        $opening_balance = new OpeningBalances();

        $args               = [];
        $args['start_date'] = date('Y-m-d');

        $closest_fy_date    = $trialbal->getClosestFnYearDate($args['start_date']);
        $args['start_date'] = $closest_fy_date['start_date'];
        $args['end_date']   = $closest_fy_date['end_date'];

        $ledger_id  = get_ledger_id_by_slug('cash');

        $c_balance = $opening_balance->getLedgerBalanceWithOpeningBalance($ledger_id, $args['start_date'], $args['end_date']);

        $item[]            = [
            'id'           => $ledger_id,
            'name'         => 'Cash',
            'obalance'     => $c_balance['obalance'],
            'balance'      => $c_balance['balance'],
            'total_debit'  => $c_balance['total_debit'],
            'total_credit' => $c_balance['total_credit'],
        ];
        $additional_fields = [];
        $data              = $this->prepareBankItemForResponse($item, $request, $additional_fields);

        return response()->json($data);
    }

    /**
     * Get ledger categories
     *
     * @param WP_REST_REQUEST $request
     *
     * @return WP_ERROR|WP_REST_REQUEST
     */
    public function getLedgerCategories(Request $request)
    {
        $ledger = new LedgerAccounts();
        $chart_id = absint($request['chart_id']);

        $categories = $ledger->getLedgerCategories($chart_id);

        return response()->json($categories);
    }

    /**
     * Create ledger categories
     *
     * @param WP_REST_REQUEST $request
     *
     * @return WP_ERROR|WP_REST_REQUEST
     */
    public function createLedgerCategory(Request $request)
    {
        $ledger = new LedgerAccounts();
        $category = $ledger->createLedgerCategory($request);

        if (!$category) {
            config('kernel.messageBag')->add('rest_ledger_already_exist', __('Category already exist.'));
            return;
        }

        return response()->json($category);
    }

    /**
     * Update ledger categories
     *
     * @param WP_REST_REQUEST $request
     *
     * @return WP_ERROR|WP_REST_REQUEST
     */
    public function updateLedgerCategory(Request $request)
    {
        $ledger = new LedgerAccounts();
        $id = (int) $request['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_ledger_invalid_id', __('Invalid resource id.'));
            return;
        }

        $category = $ledger->updateLedgerCategory($request);

        if (!$category) {
            config('kernel.messageBag')->add('rest_ledger_already_exist', __('Category already exist.'));
            return;
        }

        return response()->json($category);
    }

    /**
     * Remove category
     */
    public function deleteLedgerCategory(Request $request)
    {
        $ledger = new LedgerAccounts();
        $id = (int) $request['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_payment_invalid_id', __('Invalid resource id.'));
            return;
        }

        $ledger->deleteLedgerCategory($id);

        return response()->json(['status' => true]);
    }

    /**
     * Log for ledger related actions
     *
     * @param array $data
     * @param string $action
     * @param array $old_data
     *
     * @return void
     */
    public function addLog($data, $action, $old_data = [])
    {
        $common = new CommonFunc();
        switch ($action) {
            case 'edit':
                $operation = 'updated';
                $changes   = !empty($old_data) ? $common->getArrayDiff($data, (array) $old_data) : [];
                break;
            case 'delete':
                $operation = 'deleted';
                break;
            default:
                $operation = 'created';
        }
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

        $prepared_item['chart_id']    = !empty($request['chart_id']) ? (int) $request['chart_id'] : '';
        $prepared_item['category_id'] = !empty($request['category_id']) ? (int) $request['category_id'] : null;
        $prepared_item['name']        = !empty($request['name']) ? $request['name'] : '';
        $prepared_item['code']        = !empty($request['code']) ? $request['code'] : null;

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param object          $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $ledger = new LedgerAccounts();
        $item = (object) $item;

        $data = [
            'id'          => $item->id,
            'chart_id'    => $item->chart_id,
            'category_id' => $item->category_id,
            'name'        => $item->name,
            'slug'        => $item->slug,
            'code'        => $item->code,
            'trn_count'   => $ledger->getLedgerTrnCount($item->id),
            'system'      => $item->system,
            'balance'     => $ledger->getLedgerBalance($item->id),
        ];

        $data = array_merge($data, $additional_fields);


        return $data;
    }

    /**
     * Prepare a single user output for response
     *
     * @param object          $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareLedgerForResponse($item, Request $request, $additional_fields = [])
    {
        $item = (array) $item;

        $data = array_merge($item, $additional_fields);

        // Wrap the data in a response object
        return response()->json($data);
    }

    /**
     * @param $item
     * @param \Illuminate\Http\Request $request Request
     * @param $additional_fields
     *
     * @return mixed|\Illuminate\Http\Response
     */
    public function prepareBankItemForResponse($item, Request $request, $additional_fields)
    {
        $item = (array) $item;

        $data = array_merge($item, $additional_fields);

        // Wrap the data in a response object
        return response()->json($data);
    }

    /**
     * Get the User's schema, conforming to JSON Schema
     *
     * @return array
     */
    public function getItemSchema()
    {
        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'chart of account',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'chart_id'    => [
                    'description' => __('Type for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'category_id' => [
                    'description' => __('Code for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                ],
                'name'        => [
                    'description' => __('Name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'code'        => [
                    'description' => __('Description for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ],
        ];

        return $schema;
    }
}
