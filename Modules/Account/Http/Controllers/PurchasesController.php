<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\People;
use Modules\Account\Classes\Purchases;

use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{

    /**
     * Get a collection of purchases
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchases(Request $request)
    {
        $purchases = new Purchases();

        $input = $request->all();
        $args = [
            'number' => (int) !empty($input['per_page']) ? intval($input['per_page']) : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $purchase_data = $purchases->getPurchases($args);
        $total_items   = $purchases->getPurchases(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($purchase_data as $item) {
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
     * Get a collection of purchases with due of a vendor
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function duePurchases(Request $request)
    {

        $input = $request->all();
        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_bill_invalid_id', __('Invalid resource id.'));
            return;
        }

        $args = [];

        $args['number']    = !empty($input['per_page']) ? $input['per_page'] : 20;
        $args['offset']    = ($args['number'] * (intval($input['page']) - 1));
        $args['vendor_id'] = $id;
        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $puchase_data = $this->getDuePurchasesByVendor($args);
        $total_items  = count($puchase_data);

        foreach ($puchase_data as $item) {
            if (isset($input['include'])) {
                $include_params = explode(',', str_replace(' ', '', $input['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $item['line_items'] = []; // TEST?

            $formatted_items[]              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get a purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchase(Request $request)
    {
        $purchases = new Purchases();

        $input = $request->all();
        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_purchase_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $purchases->getPurchases($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $item     = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($item);
    }

    /**
     * Create a purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function createPurchase(Request $request)
    {

        $input = $request->all();
        $purchase_data  = $this->prepareItemFDatabase($request);
        $items          = $input['line_items'];
        $item_total     = [];
        $item_tax_total = [];

        foreach ($items as $key => $item) {
            $item_total[$key]      = $item['item_total'];
            $item_tax_total[$key]  = !empty($item['tax_amount']) ? $item['tax_amount'] : 0;
        }

        $purchase_data['tax']           = array_sum($item_tax_total);
        $purchase_data['amount']        = array_sum($item_total) + $purchase_data['tax'];
        $purchase_data['attachments']   = maybe_serialize($input['attachments']);
        $additional_fields['namespace'] = __NAMESPACE__;

        $purchase_data = $this->insertPurchase($purchase_data);

        $this->addLog($purchase_data, 'add');

        $purchase_data = $this->prepareItemForResponse($purchase_data, $request, $additional_fields);

        return response()->json($purchase_data);
    }

    /**
     * Update a purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePurchase(Request $request)
    {
        $common = new CommonFunc();
        $purchases = new Purchases();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_purchase_invalid_id', __('Invalid resource id.'));
            return;
        }

        $can_edit = $common->checkVoucherEditState($id);

        if (!$can_edit) {
            messageBag('rest_purchase_invalid_edit', __('Invalid edit permission for update.'));
            return;
        }

        $purchase_data = $this->prepareItemFDatabase($request);

        $items      = $input['line_items'];
        $item_total = [];
        $tax_total  = [];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['item_total'];
            $tax_total[$key]  = $item['tax_amount'];
        }

        $purchase_data['attachments']     = maybe_serialize($purchase_data['attachments']);
        $purchase_data['billing_address'] = isset($purchase_data['billing_address']) ? maybe_serialize($purchase_data['billing_address']) : '';
        $purchase_data['amount']          = array_sum($item_total);
        $purchase_data['tax']             = array_sum($tax_total);

        $old_data = $purchases->getPurchases($id);
        $purchase = $purchases->updatePurchase($purchase_data, $id);

        $this->addLog($purchase_data, 'edit', $old_data);

        $additional_fields['namespace'] = __NAMESPACE__;

        $purchase_data = $this->prepareItemForResponse($purchase, $request, $additional_fields);

        return response()->json($purchase_data);
    }

    /**
     * Void a purchase
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function voidPurchase(Request $request)
    {

        $input = $request->all();
        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_purchase_invalid_id', __('Invalid resource id.'));
            return;
        }

        $this->voidPurchase($id);

        return response()->json(['status' => true]);
    }

    /**
     * Log for inventory purchase related actions
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

        if (isset($input['vendor_id'])) {
            $prepared_item['vendor_id'] = $input['vendor_id'];
        }

        if (isset($input['vendor_name'])) {
            $prepared_item['vendor_name'] = $input['vendor_name'];
        }

        if (isset($input['ref'])) {
            $prepared_item['ref'] = $input['ref'];
        }

        if (isset($input['trn_date'])) {
            $prepared_item['trn_date'] = $input['trn_date'];
        }

        if (isset($input['due_date'])) {
            $prepared_item['due_date'] = $input['due_date'];
        }

        if (isset($input['particulars'])) {
            $prepared_item['particulars'] = $input['particulars'];
        }

        if (isset($input['type'])) {
            $prepared_item['type'] = $input['type'];
        }

        if (isset($input['status'])) {
            $prepared_item['status'] = $input['status'];
        }

        if (isset($input['purchase_order'])) {
            $prepared_item['purchase_order'] = $input['purchase_order'];
        }

        if (isset($input['line_items'])) {
            $prepared_item['line_items'] = $input['line_items'];
        }

        if (isset($input['tax_rate'])) {
            $prepared_item['tax_rate'] = $input['tax_rate'];
        }

        if (isset($input['attachments'])) {
            $prepared_item['attachments'] = maybe_serialize($input['attachments']);
        }

        if (isset($input['billing_address'])) {
            $prepared_item['billing_address'] = maybe_serialize($input['billing_address']);
        }

        if (isset($input['convert'])) {
            $prepared_item['convert'] = $input['convert'];
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

        $people = new People();
        $purchases = new Purchases();

        $item = (object) $item;

        $data = [
            'id'             => (int) $item->id,
            'editable'       => (int) $item->editable,
            'vendor_id'      => (int) $item->vendor_id,
            'voucher_no'     => (int) $item->voucher_no,
            'vendor_name'    => $item->vendor_name,
            'date'           => $item->trn_date,
            'due_date'       => $item->due_date,
            'line_items'     => $item->line_items,
            'type'           => !empty($item->type) ? $item->type : 'purchase',
            'tax'            => $item->tax,
            'tax_zone_id'    => $item->tax_zone_id,
            'ref'            => $item->ref,
            'billing_address' => $people->formatPeopleAddress($people->getPeopleAddress((int) $item->vendor_id)),
            'pdf_link'       => $item->pdf_link,
            'status'         => $item->status,
            'purchase_order' => $item->purchase_order,
            'amount'         => $item->amount,
            'created_at'     => $item->created_at,
            'due'            => empty($item->due) ? $purchases->getPurchaseDue($item->voucher_no) : $item->due,
            'attachments'    => maybe_unserialize($item->attachments),
            'particulars'    => $item->particulars,
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
            'title'      => 'purchase',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'voucher_no'  => [
                    'description' => __('Voucher no. for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'vendor_id'   => [
                    'description' => __('Customer id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'vendor_name' => [
                    'description' => __('Customer id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'trn_date'    => [
                    'description' => __('Date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'due_date'    => [
                    'description' => __('Due date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'line_items'  => [
                    'description' => __('List of line items data.'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'product_id'   => [
                            'description' => __('Product id.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'product_type' => [
                            'description' => __('Product type.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'qty'          => [
                            'description' => __('Product quantity.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'unit_price'   => [
                            'description' => __('Unit price.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'discount'     => [
                            'description' => __('Discount.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'tax'          => [
                            'description' => __('Tax.'),
                            'type'        => 'integer',
                            'context'     => ['edit'],
                        ],
                        'tax_percent'  => [
                            'description' => __('Tax percent.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'item_total'   => [
                            'description' => __('Item total.'),
                            'type'        => 'integer',
                            'context'     => ['edit'],
                        ],
                    ],
                ],
                'type'        => [
                    'description' => __('Type for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'status'      => [
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
