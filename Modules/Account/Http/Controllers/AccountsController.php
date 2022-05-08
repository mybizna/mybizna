<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Modules\Account\Classes\Reports\TrialBalance;
use Modules\Account\Classes\Bank;

class AccountsController extends Controller
{

    /**
     * Get a collection of accounts
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_accounts($request)
    {
        $bank = new Bank();
        $items = $bank->getTransferAccounts(true);

        $formatted_items = [];

        foreach ($items as $item) {
            $additional_fields = [];

            $data              = $this->prepare_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, 0);

        return $response;
    }

    /**
     * Get a specific account
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_account($request)
    {
        $bank = new Bank();
        $id   = (int) $request['id'];
        $item = $bank->getBank($id);

        if (empty($id) || empty($item->id)) {
            return new WP_Error('rest_bank_account_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $item     = $this->prepare_item_for_response($item, $request, []);
        $response = rest_ensure_response($item);

        return $response;
    }

    /**
     * Delete a specific account
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function delete_account($request)
    {
        $bank = new Bank();
        $id   = (int) $request['id'];
        $item = $bank->deleteBank($id);

        if (empty($id) || empty($item->id)) {
            return new WP_Error('rest_bank_account_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $item     = $this->prepare_item_for_response($item, $request, []);
        $response = rest_ensure_response($item);

        return $response;
    }

    /**
     * Transfer money from one account to another
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function transfer_money($request)
    {
        $trialbal = new TrialBalance();
        $bank = new Bank();
        $item = $this->prepare_item_for_database($request);

        if (empty($item['from_account_id']) || empty($item['to_account_id'])) {
            return new WP_Error('rest_transfer_invalid_accounts', __('Both accounts should be present.'), ['status' => 400]);
        }
        $args               = [];
        $args['start_date'] = date('Y-m-d');

        $closest_fy_date    = $trialbal->getClosestFnYearDate($args['start_date']);
        $args['start_date'] = $closest_fy_date['start_date'];
        $args['end_date']   = $closest_fy_date['end_date'];

        $ledger_details = get_ledger_balance_with_opening_balance($item['from_account_id'], $args['start_date'], $args['end_date']);

        if (empty($ledger_details)) {
            return new WP_Error('rest_transfer_invalid_account', __('Something Went Wrong! Account not found.'), ['status' => 400]);
        }

        $from_balance = $ledger_details['balance'];

        // if ( $from_balance < $item['amount'] ) {
        //     return new WP_Error( 'rest_transfer_insufficient_funds', __( 'Not enough money on selected transfer source.' ), [ 'status' => 400 ] );
        // }

        $id = $bank->performTransfer($item);

        if (is_wp_error($id)) {
            return $id;
        }

        $this->add_log($item, 'transfer');

        return new WP_REST_Response(true, 201);
    }

    /**
     * Get a list of transfers
     *
     * @param $request
     *
     * @return mixed|object|WP_REST_Response
     */
    public function get_transfer_list($request)
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

            $data              = $this->prepare_list_item_for_response($item, $request, $additional_fields, $accounts);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, 0);

        return $response;
    }

    /**
     * Get single voucher
     */
    public function get_single_transfer($request)
    {

        $bank = new Bank();
        $id       = !empty($request['id']) ? intval($request['id']) : 0;
        $item     = $bank->getSingleVoucher($id);
        $accounts = $bank->getTransferAccounts();
        $accounts = wp_list_pluck($accounts, 'name', 'id');
        $data     = $this->prepare_list_item_for_response($item, $request, [], $accounts);
        $response = rest_ensure_response($data);

        return $response;
    }

    /**
     * Get a collection of bank accounts
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_bank_accounts($request)
    {
        $bank = new Bank();
        $items = $bank->getBanks(true, true, false);

        if (empty($items)) {
            return new WP_Error('rest_empty_accounts', __('Bank accounts are empty.'), ['status' => 204]);
        }

        $formatted_items = [];

        foreach ($items as $item) {
            $additional_fields = [];

            $data              = $this->prepare_bank_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, 0);

        return $response;
    }

    /**
     * Get dashboard bank accounts
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_cash_at_bank($request)
    {
        $bank = new Bank();
        $formatted_items = [];
        $items           = $bank->getDashboardBanks();

        if (empty($items)) {
            return new WP_Error('rest_empty_accounts', __('Bank accounts are empty.'), ['status' => 204]);
        }

        foreach ($items as $item) {
            $additional_fields = [];

            $data              = $this->prepare_bank_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, 0);

        return $response;
    }

    /**
     * Log when transfer
     *
     * @param $data
     * @param $action
     */
    public function add_log($data, $action)
    {
    }

    /**
     * Prepare a single item for create or update
     *
     * @param WP_REST_Request $request request object
     *
     * @return array $prepared_item
     */
    protected function prepare_item_for_database($request)
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
     * @param WP_REST_Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return WP_REST_Response $response response data
     */
    public function prepare_item_for_response($item, $request, $additional_fields = [])
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

        // Wrap the data in a response object
        $response = rest_ensure_response($data);

        return $response;
    }

    /**
     * Prepare a single dashboard output for response
     *
     * @param object          $item
     * @param WP_REST_Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return WP_REST_Response $response response data
     */
    public function prepare_dashboard_item_for_response($item, $request, $additional_fields = [])
    {
        if (isset($request['include'])) {
            $include_params = explode(',', str_replace(' ', '', $request['include']));

            if (in_array('created_by', $include_params, true)) {
                $data['created_by'] = $this->get_user(intval($item->created_by));
            }
        }

        $data = array_merge((array) $item, $additional_fields);

        // Wrap the data in a response object
        $response = rest_ensure_response($data);

        return $response;
    }

    /**
     * @param $item
     * @param $request
     * @param $additional_fields
     * @param $accounts
     *
     * @return mixed|WP_REST_Response
     */
    public function prepare_list_item_for_response($item, $request, $additional_fields, $accounts)
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
        $response = rest_ensure_response($data);

        return $response;
    }

    /**
     * @param $item
     * @param $request
     * @param $additional_fields
     *
     * @return mixed|WP_REST_Response
     */
    public function prepare_bank_item_for_response($item, $request, $additional_fields)
    {
        $data = array_merge($item, $additional_fields);

        // Wrap the data in a response object
        $response = rest_ensure_response($data);

        return $response;
    }

    /**
     * Get the User's schema, conforming to JSON Schema
     *
     * @return array
     */
    public function get_item_schema()
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
