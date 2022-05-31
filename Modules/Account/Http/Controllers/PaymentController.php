<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\LedgerAccounts;
use Modules\Account\Classes\RecPayments;
use Modules\Account\Classes\Purchases;

use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    /**
     * Get a collection of payments
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayments(Request $request)
    {
        $recpayments = new RecPayments();

        $input = $request->all();

        $args = [
            'number' => isset($input['per_page']) ? $input['per_page'] : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $payment_data  = $recpayments->getPayments($args);
        $payment_count = $recpayments->getPayments(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($payment_data as $item) {
            if (isset($input['include'])) {
                $include_params = explode(',', str_replace(' ', '', $input['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $formatted_items[]              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get a payment
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_payment(Request $request)
    {
        $recpayments = new RecPayments();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_payment_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $recpayments->getPayment($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $item     = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($item);
    }

    /**
     * Create a payment
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function createPayment(Request $request)
    {
        $recpayments = new RecPayments();

        $input = $request->all();
        $additional_fields = [];
        $payment_data      = $this->prepareItemFDatabase($request);

        $items      = $input['line_items'];
        $item_total = [];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['line_total'];
        }

        $payment_data['amount'] = array_sum($item_total);

        $payment_data = $recpayments->insertPayment($payment_data);

        $this->addLog($payment_data, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $payment_data = $this->prepareItemForResponse($payment_data, $request, $additional_fields);

        return response()->json($payment_data);
    }

    /**
     * Update a payment
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePayment(Request $request)
    {
        $recpayments = new RecPayments();

        $input = $request->all();
        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_payment_invalid_id', __('Invalid resource id.'));
            return;
        }

        $payment_data = $this->prepareItemFDatabase($request);

        $items      = $input['line_items'];
        $item_total = [];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['line_total'];
        }

        $payment_data['amount'] = array_sum($item_total);

        $old_data     = $recpayments->getPayment($id);
        $payment_data = $recpayments->updatePayment($payment_data, $id);

        $this->addLog($payment_data, 'edit', $old_data);

        $additional_fields              = [];
        $additional_fields['namespace'] = __NAMESPACE__;

        $payment_response = $this->prepareItemForResponse($payment_data, $request, $additional_fields);

        return response()->json($payment_response);
    }

    /**
     * Void a payment
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function voidPayment(Request $request)
    {
        $payment = new RecPayments();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_payment_invalid_id', __('Invalid resource id.'));
            return;
        }

        $payment->voidPayment($id);

        return response()->json(['status' => true]);
    }

    /**
     * Log for inventory payment related actions
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
                $changes   = !empty($old_data) ? $common->getArrayDiff($data, $old_data) : [];
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

        $input = $request->all();

        if (isset($input['id'])) {
            $prepared_item['id'] = $input['id'];
        }

        if (isset($input['customer_id'])) {
            $prepared_item['customer_id'] = $input['customer_id'];
        }

        if (isset($input['trn_date'])) {
            $prepared_item['trn_date'] = $input['trn_date'];
        }

        if (isset($input['line_items'])) {
            $prepared_item['line_items'] = $input['line_items'];
        }

        if (isset($input['particulars'])) {
            $prepared_item['particulars'] = $input['particulars'];
        }

        if (isset($input['invoice_no'])) {
            $prepared_item['invoice_no'] = $input['invoice_no'];
        }

        if (isset($input['amount'])) {
            $prepared_item['amount'] = $input['amount'];
        }

        if (isset($input['ref'])) {
            $prepared_item['ref'] = $input['ref'];
        }

        if (isset($input['due'])) {
            $prepared_item['due'] = $input['due'];
        }

        if (isset($input['line_total'])) {
            $prepared_item['line_total'] = $input['line_total'];
        }

        if (isset($input['trn_by'])) {
            $prepared_item['trn_by'] = $input['trn_by'];
        }

        if (isset($input['type'])) {
            $prepared_item['type'] = $input['type'];
        }

        if (isset($input['status'])) {
            $prepared_item['status'] = $input['status'];
        }

        if (isset($input['attachments'])) {
            $prepared_item['attachments'] = maybe_serialize($input['attachments']);
        }

        if (isset($input['billing_address'])) {
            $prepared_item['billing_address'] = maybe_serialize($input['billing_address']);
        }

        if (isset($input['deposit_to'])) {
            $prepared_item['deposit_to'] = $input['deposit_to'];
        }

        if (isset($input['name'])) {
            $prepared_item['name'] = $input['name'];
        }

        if (isset($input['bank'])) {
            $prepared_item['bank'] = $input['bank'];
        }

        if (isset($input['check_no'])) {
            $prepared_item['check_no'] = $input['check_no'];
        }

        if (isset($input['bank_trn_charge'])) {
            $prepared_item['bank_trn_charge'] = $input['bank_trn_charge'];
        }

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param array|object    $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $common = new CommonFunc();
        $ledger = new LedgerAccounts();
        $item = (object) $item;

        $data = [
            'id'                    => (int) $item->id,
            'voucher_no'            => (int) $item->voucher_no,
            'customer_id'           => (int) $item->customer_id,
            'customer_name'         => $item->customer_name,
            'trn_date'              => $item->trn_date,
            'amount'                => $item->amount,
            'transaction_charge'    => $item->transaction_charge,
            'ref'                   => $item->ref,
            'account'               => $ledger->getLedgerNameById($item->trn_by_ledger_id),
            'line_items'            => $item->line_items,
            'attachments'           => maybe_unserialize($item->attachments),
            'status'                => $common->getTrnStatusById($item->status),
            'pdf_link'              => $item->pdf_link,
            'type'                  => !empty($item->type) ? $item->type : 'payment',
            'particulars'           => $item->particulars,
            'created_at'            => $item->created_at,
        ];

        $data = array_merge($data, $additional_fields);


        return $data;
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
            'title'      => 'payment',
            'type'       => 'object',
            'properties' => [
                'id'              => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'voucher_no'      => [
                    'description' => __('Voucher no. for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'customer_id'     => [
                    'description' => __('Vendor id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'trn_date'        => [
                    'description' => __('Date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'billing_address' => [
                    'description' => __('List of billing address data.'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'city'        => [
                            'description' => __('City name.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'state'       => [
                            'description' => __('ISO code or name of the state, province or district.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'postal_code' => [
                            'description' => __('Postal code.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'country'     => [
                            'description' => __('ISO code of the country.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'phone'       => [
                            'description' => __('Phone for the resource.'),
                            'type'        => 'string',
                            'context'     => ['edit'],
                        ],
                    ],
                ],
                'line_items'      => [
                    'description' => __('List of line items data.'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'invoice_no' => [
                            'description' => __('Invoice no.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'amount'     => [
                            'description' => __('Invoice amount.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'due'        => [
                            'description' => __('Invoice due.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'line_total' => [
                            'description' => __('Total.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'check_no'        => [
                    'description' => __('Check no for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'name'            => [
                    'description' => __('Check name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'type'            => [
                    'description' => __('Type for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'status'          => [
                    'description' => __('Status for the resource.'),
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
