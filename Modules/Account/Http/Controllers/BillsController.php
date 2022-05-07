<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Bills extends Controller
{
    /**
     * Get a collection of bills
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_bills($request)
    {
        $args = [
            'number' => isset($request['per_page']) ? $request['per_page'] : 20,
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $bill_data   = $bills->getBills($args);
        $total_items = $bills->getBills(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($bill_data as $item) {
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
     * Get a bill
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_bill($request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $bill_data = $bills->getBill($id);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;
        $data            = $this->prepare_item_for_response($bill_data, $request, $additional_fields);
        $formatted_items = $this->prepare_response_for_collection($data);
        $response        = rest_ensure_response($formatted_items);

        $response->set_status(200);

        return $response;
    }

    /**
     * Create a bill
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function create_bill($request)
    {
        $bill_data = $this->prepare_item_for_database($request);

        $item_total        = [];
        $additional_fields = [];

        $items = $request['bill_details'];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['amount'];
        }

        $bill_data['attachments']     = maybe_serialize($bill_data['attachments']);
        $bill_data['billing_address'] = isset($bill_data['billing_address']) ? maybe_serialize($bill_data['billing_address']) : '';
        $bill_data['amount']          = array_sum($item_total);

        $bill = erp_acct_insert_bill($bill_data);

        $this->add_log($bill, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $bill_data = $this->prepare_item_for_response($bill, $request, $additional_fields);
        $response = rest_ensure_response($bill_data);
        $response->set_status(201);

        return $response;
    }

    /**
     * Update a bill
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_bill($request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $can_edit = $common->checkVoucherEditState($id);

        if (!$can_edit) {
            return new WP_Error('rest_bill_invalid_edit', __('Invalid edit permission for update.'), ['status' => 403]);
        }

        $bill_data = $this->prepare_item_for_database($request);

        $item_total        = [];
        $additional_fields = [];

        $items = $request['bill_details'];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['amount'];
        }

        $bill_data['attachments']     = maybe_serialize($bill_data['attachments']);
        $bill_data['billing_address'] = isset($bill_data['billing_address']) ? maybe_serialize($bill_data['billing_address']) : '';
        $bill_data['amount']          = array_sum($item_total);

        $old_data = $bills->getBill($id);
        $bill     = $bills->updateBill($bill_data, $id);

        $this->add_log($bill_data, 'edit', $old_data);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $bill_data = $this->prepare_item_for_response($bill, $request, $additional_fields);

        $response = rest_ensure_response($bill_data);
        $response->set_status(200);

        return $response;
    }

    /**
     * Void a bill
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function void_bill($request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $bills->voidBill($id);

        return new WP_REST_Response(true, 204);
    }

    /**
     * Get a collection of bills with due of a people
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function due_bills($request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $args = [
            'number' => !empty($request['per_page']) ? $request['per_page'] : 20,
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $bill_data   = $this->getDueBillsByPeople(['people_id' => $id]);
        $total_items = $this->getDueBillsByPeople(
            [
                'people_id' => $id,
                'count'     => true,
                'number'    => -1,
            ]
        );

        foreach ($bill_data as $item) {
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
     * Get Dashboard Payable segments
     *
     * @param $request
     *
     * @return mixed|WP_REST_Response
     */
    public function get_overview_payables($request)
    {
        $items    = $common->getPayables();
        $response = rest_ensure_response($items);

        $response->set_status(200);

        return $response;
    }

    /**
     * Log for bill related actions
     *
     * @param array $data
     * @param string $action
     * @param array $old_data
     *
     * @return void
     */
    public function add_log($data, $action, $old_data = [])
    {
        switch ($action) {
            case 'edit':
                $operation = 'updated';
                $changes   = !empty($old_data) ? erp_get_array_diff($data, $old_data) : [];
                break;
            case 'delete':
                $operation = 'deleted';
                break;
            default:
                $operation = 'created';
        }

        erp_log()->add(
            [
                'component'     => 'Accounting',
                'sub_component' => __('Bill', 'erp'),
                'old_value'     => isset($changes['old_value']) ? $changes['old_value'] : '',
                'new_value'     => isset($changes['new_value']) ? $changes['new_value'] : '',
                'message'       => sprintf(__('A bill of %1$s has been %2$s for %3$s', 'erp'), $data['amount'], $operation, $people->getPeopleNameByPeopleId($data['vendor_id'])),
                'changetype'    => $action,
                'created_by'    => get_current_user_id(),
            ]
        );
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

        if (isset($request['trn_date'])) {
            $prepared_item['trn_date'] = $request['trn_date'];
        }

        if (isset($request['due_date'])) {
            $prepared_item['due_date'] = $request['due_date'];
        }

        if (isset($request['amount'])) {
            $prepared_item['total'] = (int) $request['amount'];
        }

        if (isset($request['due'])) {
            $prepared_item['due'] = (int) $request['due'];
        }

        if (isset($request['trn_no'])) {
            $prepared_item['trn_no'] = $request['trn_no'];
        }

        if (isset($request['trn_by'])) {
            $prepared_item['trn_by'] = $request['trn_by'];
        }

        if (isset($request['bill_details'])) {
            $prepared_item['bill_details'] = $request['bill_details'];
        }

        if (isset($request['status'])) {
            $prepared_item['status'] = $request['status'];
        }

        if (isset($request['particulars'])) {
            $prepared_item['particulars'] = $request['particulars'];
        }

        if (isset($request['attachments'])) {
            $prepared_item['attachments'] = $request['attachments'];
        }

        if (isset($request['billing_address'])) {
            $prepared_item['billing_address'] = maybe_serialize($request['billing_address']);
        }

        if (isset($request['ref'])) {
            $prepared_item['ref'] = $request['ref'];
        }

        $prepared_item['request'] = $request;

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
        $item = (object) $item;

        $data = [
            'id'              => (int) $item->id,
            'editable'        => !empty($item->editable) ? (int) $item->editable : 1,
            'voucher_no'      => (int) $item->voucher_no,
            'vendor_id'       => (int) $item->vendor_id,
            'vendor_name'     => $item->vendor_name,
            'trn_date'        => $item->trn_date,
            'due_date'        => $item->due_date,
            'billing_address' => !empty($item->billing_address) ? $item->billing_address : $people->getPeopleAddress($item->vendor_id),
            'pdf_link'        => $item->pdf_link,
            'bill_details'    => !empty($item->bill_details) ? $item->bill_details : [],
            'amount'          => (int) $item->amount,
            'due'             => !empty($item->due) ? $item->due : $item->amount,
            'ref'             => !empty($item->ref) ? $item->ref : '',
            'particulars'     => $item->particulars,
            'status'          => $item->status,
            'created_at'      => $item->created_at,
            'attachments'     => maybe_unserialize($item->attachments),
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
            'title'      => 'bill',
            'type'       => 'object',
            'properties' => [
                'id'           => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'voucher_no'   => [
                    'description' => __('Voucher no. for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                ],
                'vendor_id'    => [
                    'description' => __('People id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'trn_date'     => [
                    'description' => __('Date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'due_date'     => [
                    'description' => __('Due date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'ref'     => [
                    'description' => __('Reference number for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'billing_address' => [
                    'description' => __('Billing address for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'bill_details' => [
                    'description' => __('List of line items data.', 'erp'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'ledger_id'   => [
                            'description' => __('Ledger id.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'description' => [
                            'description' => __('Item Particular.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                            'arg_options' => [
                                'sanitize_callback' => 'sanitize_text_field',
                            ],
                        ],
                        'amount'      => [
                            'description' => __('Bill Amount', 'erp'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'status'       => [
                    'description' => __('Status for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'type' => [
                    'description' => __('Item Type.', 'erp'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'particulars' => [
                    'description' => __('Bill Particular.', 'erp'),
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
