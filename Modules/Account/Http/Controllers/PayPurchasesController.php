<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\PayPurchases;


use Illuminate\Support\Facades\DB;

class PayPurchasesController extends Controller
{

    /**
     * Get a collection of pay_purchases
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayPurchases(Request $request)
    {

        $input = $request->all();
        
        $args = [
            'number' => (int) isset($input['per_page']) ? $input['per_page'] : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $pay_purchase_data = $this->getPayPurchases($args);
        $total_items       = $this->getPayPurchases(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($pay_purchase_data as $item) {
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
     * Get a pay_purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayPurchase(Request $request)
    {
        $pay_purchases = new PayPurchases();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_pay_purchase_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $pay_purchases->getPayPurchase($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $item = $this->prepareItemForResponse($item, $request, $additional_fields);

        return response()->json($item);
    }

    /**
     * Create a pay_purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function createPayPurchase(Request $request)
    {
        $additional_fields = [];
        $pay_purchase_data = $this->prepareItemFDatabase($request);

        $input = $request->all();

        $items      = $input['purchase_details'];
        $item_total = [];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['line_total'];
        }

        $pay_purchase_data['amount'] = array_sum($item_total);

        $pay_purchase_data = $this->insertPayPurchase($pay_purchase_data);

        $this->addLog($pay_purchase_data, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $pay_purchase_data = $this->prepareItemForResponse($pay_purchase_data, $request, $additional_fields);

        return response()->json($pay_purchase_data);
    }

    /**
     * Update a pay_purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePayPurchase(Request $request)
    {
        $pay_purchases = new PayPurchases();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_pay_purchase_invalid_id', __('Invalid resource id.'));
            return;
        }

        $pay_purchase_data = $this->prepareItemFDatabase($request);

        $items      = $input['purchase_details'];
        $item_total = [];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['line_total'];
        }

        $pay_purchase_data['amount'] = array_sum($item_total);

        $old_data = $pay_purchases->getPayPurchase($id);

        $pay_purchase_id = $pay_purchases->updatePayPurchase($pay_purchase_data, $id);

        $this->addLog($pay_purchase_data, 'edit', $old_data);

        return response()->json($pay_purchase_data);
    }

    /**
     * Void a pay_purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function voidPayPurchase(Request $request)
    {
        $pay_purchases = new PayPurchases();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_pay_purchase_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $pay_purchases->getPayPurchase($id);

        $this->voidPayPurchase($id);

        $this->addLog($item, 'delete');

        return response()->json(['status' => true]);
    }

    /**
     * Log when purchase payment is created
     *
     * @param array $data
     * @param string $action
     * @param array $old_data
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

        if (isset($input['vendor_id'])) {
            $prepared_item['vendor_id'] = $input['vendor_id'];
        }

        if (isset($input['ref'])) {
            $prepared_item['ref'] = $input['ref'];
        }

        if (isset($input['trn_date'])) {
            $prepared_item['trn_date'] = $input['trn_date'];
        }

        if (isset($input['purchase_details'])) {
            $prepared_item['purchase_details'] = $input['purchase_details'];
        }

        if (isset($input['amount'])) {
            $prepared_item['amount'] = $input['amount'];
        }

        if (isset($input['ref'])) {
            $prepared_item['ref'] = $input['ref'];
        }

        if (isset($input['trn_by'])) {
            $prepared_item['trn_by'] = $input['trn_by'];
        }

        if (isset($input['bank_trn_charge'])) {
            $prepared_item['bank_trn_charge'] = $input['bank_trn_charge'];
        }

        if (isset($input['particulars'])) {
            $prepared_item['particulars'] = $input['particulars'];
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

        if (isset($input['type'])) {
            $prepared_item['voucher_type'] = $input['type'];
        }

        if (isset($input['check_no'])) {
            $prepared_item['check_no'] = $input['check_no'];
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
        $item = (object) $item;

        $data = [
            'id'                 => (int) $item->id,
            'voucher_no'         => (int) $item->voucher_no,
            'vendor_id'          => (int) $item->vendor_id,
            'trn_date'           => $item->trn_date,
            'purchase_details'   => $item->purchase_details,
            'pdf_link'           => $item->pdf_link,
            'ref'                =>  $item->ref,
            'amount'             => (float) $item->amount,
            'particulars'        => $item->particulars,
            'attachments'        => maybe_unserialize($item->attachments),
            'status'             => $item->status,
            'created_at'         => $item->created_at,
            'transaction_charge' => $item->transaction_charge,
            'trn_by'             => $common->getPaymentMethodById($item->trn_by)->name,
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
            'title'      => 'pay_purchase',
            'type'       => 'object',
            'properties' => [
                'id'               => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'voucher_no'       => [
                    'description' => __('Voucher no. for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                ],
                'type'             => [
                    'description' => __('Type for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'vendor_id'        => [
                    'description' => __('Vendor id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'trn_date'         => [
                    'description' => __('Date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'purchase_details' => [
                    'description' => __('List of line items data.'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'         => [
                            'description' => __('Product id.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'voucher_no' => [
                            'description' => __('Product type.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'due_date'        => [
                            'description' => __('Unit price.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'total'      => [
                            'description' => __('Discount.'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                        'due'      => [
                            'description' => __('Discount.'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                        'line_total' => [
                            'description' => __('Item total.'),
                            'type'        => 'number',
                            'context'     => ['edit'],
                        ],
                    ],
                ],
                'check_no'         => [
                    'description' => __('Check no for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'name'             => [
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
                    'type'        => 'integer',
                    'context'     => ['edit'],
                ],
                'particulars'           => [
                    'description' => __('Particulars for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'deposit_to'      => [
                    'description' => __('Status for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'trn_by'          => [
                    'description' => __('Status for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
            ],
        ];

        return $schema;
    }
}
