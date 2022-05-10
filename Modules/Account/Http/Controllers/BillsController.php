<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\People;
use Modules\Account\Classes\Bills;

use Illuminate\Support\Facades\DB;

class BillsController extends Controller
{
    /**
     * Get a collection of bills
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_bills(Request $request)
    {

        $bills = new Bills();
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

        return response()->json($formatted_items);

        
    }

    /**
     * Get a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_bill(Request $request)
    {
        $bills = new Bills();
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $bill_data = $bills->getBill($id);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;
        $data            = $this->prepare_item_for_response($bill_data, $request, $additional_fields);
        $formatted_items = $this->prepare_response_for_collection($data);

        return  response()->json($formatted_items);


        
    }

    /**
     * Create a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function create_bill(Request $request)
    {
        $bills = new Bills();
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

        $bill = $bills->insertBill($bill_data);

        $this->add_log($bill, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $bill_data = $this->prepare_item_for_response($bill, $request, $additional_fields);
        return response()->json($bill_data);

        
    }

    /**
     * Update a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function update_bill(Request $request)
    {
        $common = new CommonFunc();
        $bills = new Bills();
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $can_edit = $common->checkVoucherEditState($id);

        if (!$can_edit) {
            messageBag()->add('rest_bill_invalid_edit', __('Invalid edit permission for update.'), ['status' => 403]);
            return ;
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

        return response()->json($bill_data);

        
    }

    /**
     * Void a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function void_bill(Request $request)
    {
        $bills = new Bills();

        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $bills->voidBill($id);

        return new WP_REST_Response(true, 204);
    }

    /**
     * Get a collection of bills with due of a people
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function due_bills(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_bill_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
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

        return response()->json($formatted_items);

        
    }

    /**
     * Get Dashboard Payable segments
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return mixed|\Illuminate\Http\Response
     */
    public function get_overview_payables(Request $request)
    {
        $common = new CommonFunc();
        $items    = $common->getPayables();
        return response()->json($items);


        
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
    protected function prepare_item_for_database(Request $request)
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
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepare_item_for_response($item, Request $request, $additional_fields = [])
    {
        $people = new People();
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



        return $data;
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
