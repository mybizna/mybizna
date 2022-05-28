<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Modules\Account\Classes\Reports\TrialBalance;
use Modules\Account\Classes\Bank;
use Modules\Account\Classes\OpeningBalances;

use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{

    /**
     * Get a collection of accounts
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccounts(Request $request)
    {
        $bank = new Bank();

        $items = $bank->getTransferAccounts(true);

        $formatted_items = [];

        foreach ($items as $item) {
            $additional_fields = [];

            $formatted_items[] = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get a specific account
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccount(Request $request)
    {
        $bank = new Bank();
        $id   = (int) $request['id'];
        $item = $bank->getBank($id);

        if (empty($id) || empty($item->id)) {
            config('kernel.messageBag')->add('rest_bank_account_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item     = $this->prepareItemForResponse($item, $request, []);
        return response()->json($item);
    }

    /**
     * Delete a specific account
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount(Request $request)
    {
        $bank = new Bank();
        $id   = (int) $request['id'];
        $item = $bank->deleteBank($id);

        if (empty($id) || empty($item->id)) {
            config('kernel.messageBag')->add('rest_bank_account_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item     = $this->prepareItemForResponse($item, $request, []);
        return response()->json($item);
    }

    /**
     * Transfer money from one account to another
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function transferMoney(Request $request)
    {
        $trialbal = new TrialBalance();
        $bank = new Bank();
        $opening_balance = new OpeningBalances();

        $item = $this->prepareItemFDatabase($request);

        if (empty($item['from_account_id']) || empty($item['to_account_id'])) {
            config('kernel.messageBag')->add('rest_transfer_invalid_accounts', __('Both accounts should be present.'));
            return;
        }
        $args               = [];
        $args['start_date'] = date('Y-m-d');

        $closest_fy_date    = $trialbal->getClosestFnYearDate($args['start_date']);
        $args['start_date'] = $closest_fy_date['start_date'];
        $args['end_date']   = $closest_fy_date['end_date'];

        $ledger_details = $opening_balance->getLedgerBalanceWithOpeningBalance($item['from_account_id'], $args['start_date'], $args['end_date']);

        if (empty($ledger_details)) {
            config('kernel.messageBag')->add('rest_transfer_invalid_account', __('Something Went Wrong! Account not found.'));
            return;
        }

        $from_balance = $ledger_details['balance'];

        // if ( $from_balance < $item['amount'] ) {
        //     config('kernel.messageBag')->add( 'rest_transfer_insufficient_funds', __( 'Not enough money on selected transfer source.' ), [ 'status' => 400 ] );
        // }

        $id = $bank->performTransfer($request);

        if ($id) {
            return $id;
        }

        //TODO: Ccheck the issues
        //$this-L($item, 'transfer');

        return response()->json(['status' => true]);
    }

    /**
     * Get a list of transfers
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return mixed|object|\Illuminate\Http\Response
     */
    public function getTransferList(Request $request)
    {
        $bank = new Bank();
        $args = [
            'order_by' => isset($request['order_by']) ? $request['order_by'] : 'id',
            'order'    => isset($request['order']) ? $request['order'] : 'DESC',
            'number'   => isset($request['per_page']) ? (int) $request['per_page'] : 20,
            'offset'   => ($request['per_page'] * ($request['page'] - 1)),
        ];

        $items    = $bank->getTransferVouchers($args);
        $accounts = $bank->getTransferAccounts();
        $accounts = wp_list_pluck($accounts, 'name', 'id');

        $formatted_items = [];

        foreach ($items as $item) {
            $additional_fields = [];

            $formatted_items[] = $this->prepareListItemForResponse($item, $request, $additional_fields, $accounts);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get single voucher
     */
    public function getSingleTransfer(Request $request)
    {

        $bank = new Bank();
        $id       = !empty($request['id']) ? intval($request['id']) : 0;
        $item     = $bank->getSingleVoucher($id);
        $accounts = $bank->getTransferAccounts();
        $accounts = wp_list_pluck($accounts, 'name', 'id');
        $data     = $this->prepareListItemForResponse($item, $request, [], $accounts);
        return response()->json($data);
    }

    /**
     * Get a collection of bank accounts
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getBankSccounts(Request $request)
    {
        $bank = new Bank();
        $items = $bank->getBanks(true, true, false);

        if (empty($items)) {
            config('kernel.messageBag')->add('rest_empty_accounts', __('Bank accounts are empty.'));
            return;
        }

        $formatted_items = [];

        foreach ($items as $item) {
            $additional_fields = [];

            $formatted_items[] = $this->prepareBankItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get dashboard bank accounts
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashAtBank(Request $request)
    {
        $bank = new Bank();
        $formatted_items = [];
        $items           = $bank->getDashboardBanks();

        if (empty($items)) {
            config('kernel.messageBag')->add('rest_empty_accounts', __('Bank accounts are empty.'));
            return;
        }

        foreach ($items as $item) {
            $additional_fields = [];

            $formatted_items[] = $this->prepareBankItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Log when transfer
     *
     * @param $data
     * @param $action
     */
    public function addLog($data, $action)
    {
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

        $prepared_item['date']            = date('Y-m-d', strtotime($request['date']));
        $prepared_item['from_account_id'] = isset($request['from_account_id']) ? intval($request['from_account_id']) : 0;
        $prepared_item['to_account_id']   = isset($request['to_account_id']) ? intval($request['to_account_id']) : 0;
        $prepared_item['amount']          = isset($request['amount']) ? floatval($request['amount']) : 0;
        $prepared_item['particulars']     = isset($request['particulars']) ? sanitize_text_field($request['particulars']) : '';

        return $prepared_item;
    }

    /**
     * Prepare a single account output for response
     *
     * @param object          $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request,  $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'id'      => (int) $item->id,
            'name'    => $item->name,
            'balance' => !empty($item->balance) ? $item->balance : 0,
        ];

        if (isset($request['include'])) {
            $include_params = explode(',', str_replace(' ', '', $request['include']));

            if (in_array('created_by', $include_params, true)) {
                $data['created_by'] = $this->get_user(intval($item->created_by));
            }
        }

        $data = array_merge($data, $additional_fields);


        return $data;
    }

    /**
     * Prepare a single dashboard output for response
     *
     * @param object          $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareDashboardItemForResponse($item, Request $request, $additional_fields = [])
    {
        if (isset($request['include'])) {
            $include_params = explode(',', str_replace(' ', '', $request['include']));

            if (in_array('created_by', $include_params, true)) {
                $data['created_by'] = $this->get_user(intval($item->created_by));
            }
        }

        $data = array_merge((array) $item, $additional_fields);

        // Wrap the data in a response object
        return response()->json($data);
    }

    /**
     * @param $item
     * @param \Illuminate\Http\Request $request Request
     * @param $additional_fields
     * @param $accounts
     *
     * @return mixed|\Illuminate\Http\Response
     */
    public function prepareListItemForResponse($item, Request $request,  $additional_fields, $accounts)
    {
        $item = (object) $item;

        $data = [
            'id'          => $item->id,
            'voucher'     => (int) $item->voucher_no,
            'ac_from'     => $accounts[$item->ac_from],
            'ac_to'       => $accounts[$item->ac_to],
            'trn_date'    => $item->trn_date,
            'particulars' => $item->particulars,
            'amount'      => $item->amount,
            'created_at'  => $item->created_at,
            'created_by'  => $this->get_user(1),
        ];

        if (isset($request['include'])) {
            $include_params = explode(',', str_replace(' ', '', $request['include']));

            if (in_array('created_by', $include_params, true)) {
                $data['created_by'] = $this->get_user(intval($item->created_by));
            }
        }

        $data = array_merge($data, $additional_fields);

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
            'title'      => 'bank account',
            'type'       => 'object',
            'properties' => [
                'id'              => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'date'            => [
                    'description' => __('Date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'from_account_id' => [
                    'description' => __('From account id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'to_account_id'   => [
                    'description' => __('To account id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'amount'          => [
                    'description' => __('Amount for the resource.'),
                    'type'        => 'number',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'particulars'     => [
                    'description' => __('Particulars for the resource.'),
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
