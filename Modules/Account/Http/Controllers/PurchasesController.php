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
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_purchases($request)
    {
        $purchases = new Purchases();
        $args = [
            'number' => (int) !empty($request['per_page']) ? intval($request['per_page']) : 20,
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $purchase_data = $purchases->getPurchases($args);
        $total_items   = $purchases->getPurchases(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($purchase_data as $item) {
            if (isset($request['include'])) {
                $include_params = explode(',', str_replace(' ', '', $request['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $data              = $this->prepare_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, $total_items);

        $response->set_status(200);

        return $response;
    }

    /**
     * Get a collection of purchases with due of a vendor
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function due_purchases($request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $args = [];

        $args['number']    = !empty($request['per_page']) ? $request['per_page'] : 20;
        $args['offset']    = ($args['number'] * (intval($request['page']) - 1));
        $args['vendor_id'] = $id;
        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $puchase_data = $this->getDuePurchasesByVendor($args);
        $total_items  = count($puchase_data);

        foreach ($puchase_data as $item) {
            if (isset($request['include'])) {
                $include_params = explode(',', str_replace(' ', '', $request['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $item['line_items'] = []; // TEST?

            $data              = $this->prepare_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, $total_items);

        $response->set_status(200);

        return $response;
    }

    /**
     * Get a purchase
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_purchase($request)
    {
        $purchases = new Purchases();
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_purchase_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $item = $purchases->getPurchases($id);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $item     = $this->prepare_item_for_response($item, $request, $additional_fields);
        $response = rest_ensure_response($item);

        $response->set_status(200);

        return $response;
    }

    /**
     * Create a purchase
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function create_purchase($request)
    {
        $purchase_data  = $this->prepare_item_for_database($request);
        $items          = $request['line_items'];
        $item_total     = [];
        $item_tax_total = [];

        foreach ($items as $key => $item) {
            $item_total[$key]      = $item['item_total'];
            $item_tax_total[$key]  = !empty($item['tax_amount']) ? $item['tax_amount'] : 0;
        }

        $purchase_data['tax']           = array_sum($item_tax_total);
        $purchase_data['amount']        = array_sum($item_total) + $purchase_data['tax'];
        $purchase_data['attachments']   = maybe_serialize($request['attachments']);
        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $purchase_data = $this->insertPurchase($purchase_data);

        $this->add_log($purchase_data, 'add');

        $purchase_data = $this->prepare_item_for_response($purchase_data, $request, $additional_fields);

        $response = rest_ensure_response($purchase_data);
        $response->set_status(201);

        return $response;
    }

    /**
     * Update a purchase
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_purchase($request)
    {
        $common = new CommonFunc();
        $purchases = new Purchases();
        
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_purchase_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $can_edit = $common->checkVoucherEditState($id);

        if (!$can_edit) {
            return new WP_Error('rest_purchase_invalid_edit', __('Invalid edit permission for update.'), ['status' => 403]);
        }

        $purchase_data = $this->prepare_item_for_database($request);

        $items      = $request['line_items'];
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

        $this->add_log($purchase_data, 'edit', $old_data);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $purchase_data = $this->prepare_item_for_response($purchase, $request, $additional_fields);

        $response = rest_ensure_response($purchase_data);
        $response->set_status(200);

        return $response;
    }

    /**
     * Void a purchase
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function void_purchase($request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_purchase_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $this->voidPurchase($id);

        return new WP_REST_Response(true, 204);
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
    public function add_log($data, $action, $old_data = [])
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
     * @param WP_REST_Request $request request object
     *
     * @return array $prepared_item
     */
    protected function prepare_item_for_database($request)
    {
        $prepared_item = [];

        if (isset($request['vendor_id'])) {
            $prepared_item['vendor_id'] = $request['vendor_id'];
        }

        if (isset($request['vendor_name'])) {
            $prepared_item['vendor_name'] = $request['vendor_name'];
        }

        if (isset($request['ref'])) {
            $prepared_item['ref'] = $request['ref'];
        }

        if (isset($request['trn_date'])) {
            $prepared_item['trn_date'] = $request['trn_date'];
        }

        if (isset($request['due_date'])) {
            $prepared_item['due_date'] = $request['due_date'];
        }

        if (isset($request['particulars'])) {
            $prepared_item['particulars'] = $request['particulars'];
        }

        if (isset($request['type'])) {
            $prepared_item['type'] = $request['type'];
        }

        if (isset($request['status'])) {
            $prepared_item['status'] = $request['status'];
        }

        if (isset($request['purchase_order'])) {
            $prepared_item['purchase_order'] = $request['purchase_order'];
        }

        if (isset($request['line_items'])) {
            $prepared_item['line_items'] = $request['line_items'];
        }

        if (isset($request['tax_rate'])) {
            $prepared_item['tax_rate'] = $request['tax_rate'];
        }

        if (isset($request['attachments'])) {
            $prepared_item['attachments'] = maybe_serialize($request['attachments']);
        }

        if (isset($request['billing_address'])) {
            $prepared_item['billing_address'] = maybe_serialize($request['billing_address']);
        }

        if (isset($request['convert'])) {
            $prepared_item['convert'] = $request['convert'];
        }

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param array|object    $item
     * @param WP_REST_Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return WP_REST_Response $response response data
     */
    public function prepare_item_for_response($item, $request, $additional_fields = [])
    {

        $people = new People();
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

        // Wrap the data in a response object
        $response = rest_ensure_response($data);

        $response = $this->add_links($response, $item, $additional_fields);

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
                    'description' => __('List of line items data.', 'erp'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'product_id'   => [
                            'description' => __('Product id.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'product_type' => [
                            'description' => __('Product type.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'qty'          => [
                            'description' => __('Product quantity.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'unit_price'   => [
                            'description' => __('Unit price.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'discount'     => [
                            'description' => __('Discount.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'tax'          => [
                            'description' => __('Tax.'),
                            'type'        => 'integer',
                            'context'     => ['edit'],
                        ],
                        'tax_percent'  => [
                            'description' => __('Tax percent.', 'erp'),
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
