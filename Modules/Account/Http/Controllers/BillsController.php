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
    public function getBills(Request $request)
    {

        $bills = new Bills();

        $input = $request->all();

        $args = [
            'number' => isset($input['per_page']) ? $input['per_page'] : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $bill_data   = $bills->getBills($args);
        $total_items = $bills->getBills(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($bill_data as $item) {
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
     * Get a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getBill(Request $request)
    {
        $bills = new Bills();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_bill_invalid_id', __('Invalid resource id.'));
            return;
        }

        $bill_data = $bills->getBill($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $formatted_items[] = $this->prepareItemForResponse($bill_data, $request, $additional_fields);

        return  response()->json($formatted_items);
    }

    /**
     * Create a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function createBill(Request $request)
    {
        $bills = new Bills();

        $input = $request->all();

        $bill_data = $this->prepareItemFDatabase($request);

        $item_total        = [];
        $additional_fields = [];

        $items = $input['bill_details'];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['amount'];
        }

        $bill_data['attachments']     = maybe_serialize($bill_data['attachments']);
        $bill_data['billing_address'] = isset($bill_data['billing_address']) ? maybe_serialize($bill_data['billing_address']) : '';
        $bill_data['amount']          = array_sum($item_total);

        $bill = $bills->insertBill($bill_data);

        $this->addLog($bill, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $bill_data = $this->prepareItemForResponse($bill, $request, $additional_fields);
        return response()->json($bill_data);
    }

    /**
     * Update a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateBill(Request $request)
    {
        $common = new CommonFunc();
        $bills = new Bills();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_bill_invalid_id', __('Invalid resource id.'));
            return;
        }

        $can_edit = $common->checkVoucherEditState($id);

        if (!$can_edit) {
            config('kernel.messageBag')->add('rest_bill_invalid_edit', __('Invalid edit permission for update.'));
            return;
        }

        $bill_data = $this->prepareItemFDatabase($request);

        $item_total        = [];
        $additional_fields = [];

        $items = $input['bill_details'];

        foreach ($items as $key => $item) {
            $item_total[$key] = $item['amount'];
        }

        $bill_data['attachments']     = maybe_serialize($bill_data['attachments']);
        $bill_data['billing_address'] = isset($bill_data['billing_address']) ? maybe_serialize($bill_data['billing_address']) : '';
        $bill_data['amount']          = array_sum($item_total);

        $old_data = $bills->getBill($id);
        $bill     = $bills->updateBill($bill_data, $id);

        $this->addLog($bill_data, 'edit', $old_data);

        $additional_fields['namespace'] = __NAMESPACE__;

        $bill_data = $this->prepareItemForResponse($bill, $request, $additional_fields);

        return response()->json($bill_data);
    }

    /**
     * Void a bill
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function voidBill(Request $request)
    {
        $bills = new Bills();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_bill_invalid_id', __('Invalid resource id.'));
            return;
        }

        $bills->voidBill($id);

        return response()->json(['status' => true]);
    }

    /**
     * Get a collection of bills with due of a people
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function dueBills(Request $request)
    {
        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_bill_invalid_id', __('Invalid resource id.'));
            return;
        }

        $args = [
            'number' => !empty($input['per_page']) ? $input['per_page'] : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $bill_data   = $this->getDueBillsByPeople(['people_id' => $id]);
        $total_items = $this->getDueBillsByPeople(
            [
                'people_id' => $id,
                'count'     => true,
                'number'    => -1,
            ]
        );

        foreach ($bill_data as $item) {
            if (isset($input['include'])) {
                $include_params = explode(',', str_replace(' ', '', $input['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $formatted_items[] = $this->prepareItemForResponse($item, $request, $additional_fields);
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
    public function getOverviewPayables(Request $request)
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

        if (isset($input['trn_date'])) {
            $prepared_item['trn_date'] = $input['trn_date'];
        }

        if (isset($input['due_date'])) {
            $prepared_item['due_date'] = $input['due_date'];
        }

        if (isset($input['amount'])) {
            $prepared_item['total'] = (int) $input['amount'];
        }

        if (isset($input['due'])) {
            $prepared_item['due'] = (int) $input['due'];
        }

        if (isset($input['trn_no'])) {
            $prepared_item['trn_no'] = $input['trn_no'];
        }

        if (isset($input['trn_by'])) {
            $prepared_item['trn_by'] = $input['trn_by'];
        }

        if (isset($input['bill_details'])) {
            $prepared_item['bill_details'] = $input['bill_details'];
        }

        if (isset($input['status'])) {
            $prepared_item['status'] = $input['status'];
        }

        if (isset($input['particulars'])) {
            $prepared_item['particulars'] = $input['particulars'];
        }

        if (isset($input['attachments'])) {
            $prepared_item['attachments'] = $input['attachments'];
        }

        if (isset($input['billing_address'])) {
            $prepared_item['billing_address'] = maybe_serialize($input['billing_address']);
        }

        if (isset($input['ref'])) {
            $prepared_item['ref'] = $input['ref'];
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
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
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
    public function getItemSchema()
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
                    'description' => __('List of line items data.'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'ledger_id'   => [
                            'description' => __('Ledger id.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'description' => [
                            'description' => __('Item Particular.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                            'arg_options' => [
                                'sanitize_callback' => 'sanitize_text_field',
                            ],
                        ],
                        'amount'      => [
                            'description' => __('Bill Amount'),
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
                    'description' => __('Item Type.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'particulars' => [
                    'description' => __('Bill Particular.'),
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
