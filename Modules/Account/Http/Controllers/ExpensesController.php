<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;

use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    /**
     * Get a collection of expenses
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpenses(Request $request)
    {
        $args = [
            'number' => isset($request['per_page']) ? $request['per_page'] : 20,
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $expense_data = $expense->getExpenses($args);
        $total_items  =  $expense->getExpenses(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($expense_data as $item) {
            if (isset($request['include'])) {
                $include_params = explode(',', str_replace(' ', '', $request['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $data              = $this->prepareItemForResponse($item, $request, $additional_fields);
            $formatted_items[] = $this->prepareResponseForCollection($data);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get a expense
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpense(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_expense_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $expense_data       = $expense->getExpense($id);
        $expense_data['id'] = $id;

        $expense_data['created_by'] = $this->get_user($expense_data['created_by']);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $data     = $this->prepareItemForResponse($expense_data, $request, $additional_fields);
        return response()->json($data);
    }

    /**
     * Get a check
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getCheck(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_check_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $expense_data       = $expense->getCheck($id);
        $expense_data['id'] = $id;

        $expense_data['created_by'] = $this->get_user($expense_data['created_by']);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $data     = $this->prepareItemForResponse($expense_data, $request, $additional_fields);
        return response()->json($data);
    }

    /**
     * Create a expense
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function createExpense(Request $request)
    {
        $expense_data = $this->prepareItemFDatabase($request);

        $item_amount       = [];
        $item_total        = [];
        $additional_fields = [];

        $items = $request['bill_details'];

        foreach ($items as $key => $item) {
            $item_amount[$key] = $item['amount'];
            $item_total[$key]  = $item['amount'];
        }
        $expense_data['attachments'] = maybe_serialize($request['attachments']);
        $expense_data['amount']      = array_sum($item_total);

        $expense = $expenses->insertExpense($expense_data);
        $this->addLog((array) $expense, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $expense_data = $this->prepareItemForResponse($expense, $request, $additional_fields);

        return response()->json($expense_data);

    }

    /**
     * Update a expense
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateExpense(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_expense_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $expense_data = $this->prepareItemFDatabase($request);

        $item_amount       = [];
        $item_total        = [];
        $additional_fields = [];

        $items = $request['bill_details'];

        foreach ($items as $key => $item) {
            $item_amount[$key] = $item['amount'];
            $item_total[$key]  = $item['amount'];
        }
        $expense_data['attachments'] = maybe_serialize($request['attachments']);
        $expense_data['amount']      = array_sum($item_total);

        $old_data   = $expense->getExpense($id);
        $expense_id = $this->updateExpense($expense_data, $id);

        $this->addLog($expense_data, 'edit', $old_data);

        $expense_data['id']             = $expense_id;
        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $expense_data = $this->prepareItemForResponse($expense_data, $request, $additional_fields);

        return response()->json($expense_data);
    }

    /**
     * Void a expense
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function voidExpense(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_expense_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $this->voidExpense($id);

        return response()->json({'status': true});;
    }

    /**
     * Log for expense related actions
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

        if (isset($request['people_id'])) {
            $prepared_item['people_id'] = $request['people_id'];
        }

        if (isset($request['ref'])) {
            $prepared_item['ref'] = $request['ref'];
        }

        if (isset($request['bank'])) {
            $prepared_item['bank'] = $request['bank'];
        }

        if (isset($request['check_no'])) {
            $prepared_item['check_no'] = $request['check_no'];
        }

        if (isset($request['trn_date'])) {
            $prepared_item['trn_date'] = $request['trn_date'];
        }

        if (isset($request['due_date'])) {
            $prepared_item['due_date'] = $request['due_date'];
        }

        if (isset($request['amount'])) {
            $prepared_item['total'] = $request['amount'];
        }

        if (isset($request['trn_no'])) {
            $prepared_item['trn_no'] = $request['trn_no'];
        }

        if (isset($request['attachments'])) {
            $prepared_item['attachments'] = $request['attachments'];
        }

        if (isset($request['deposit_to'])) {
            $prepared_item['trn_by_ledger_id'] = $request['deposit_to'];
        }

        if (isset($request['trn_by'])) {
            $prepared_item['trn_by'] = $request['trn_by'];
        }

        if (isset($request['bank_trn_charge'])) {
            $prepared_item['bank_trn_charge'] = $request['bank_trn_charge'];
        }

        if (isset($request['bill_details'])) {
            $prepared_item['bill_details'] = $request['bill_details'];
        }

        if (isset($request['billing_address'])) {
            $prepared_item['billing_address'] = $request['billing_address'];
        }

        if (isset($request['particulars'])) {
            $prepared_item['particulars'] = $request['particulars'];
        }

        if (isset($request['status'])) {
            $prepared_item['status'] = $request['status'];
        }

        if (isset($request['attachments'])) {
            $prepared_item['attachments'] = $request['attachments'];
        }

        if (isset($request['name'])) {
            $prepared_item['name'] = $request['name'];
        }

        if (isset($request['pay_to'])) {
            $prepared_item['pay_to'] = $request['pay_to'];
        }

        if (isset($request['type'])) {
            $prepared_item['voucher_type'] = $request['type'];
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
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'id'                 => (int) $item->id,
            'voucher_no'         => (int) $item->voucher_no,
            'people_id'          => (int) $item->people_id,
            'people_name'        => $item->people_name,
            'date'               => $item->trn_date,
            'address'            => $item->address,
            'bill_details'       => $item->bill_details,
            'pdf_link'           => $item->pdf_link,
            'total'              => (float) $item->amount,
            'ref'                => !empty($item->ref) ? $item->ref : '',
            'check_no'           => $item->check_no,
            'particulars'        => $item->particulars,
            'status'             => $item->status,
            'attachments'        => maybe_unserialize($item->attachments),
            'trn_by'             => $item->trn_by,
            'transaction_charge' => $item->transaction_charge,
            'created_at'         => $item->created_at,
            'deposit_to'         => $item->trn_by_ledger_id,
            'check_data'         => !empty($item->check_data) ? $item->check_data : [],
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
            'title'      => 'expense',
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
                ],
                'people_id'       => [
                    'description' => __('People id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'ref'       => [
                    'description' => __('Reference for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
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
                'trn_by'        => [
                    'description' => __('Trans by for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                ],
                'billing_address' => [
                    'description' => __('Billing address for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
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
                            'required'    => true,
                        ],
                        'particulars' => [
                            'description' => __('Bill Particulars.', 'erp'),
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
                            'required'    => true,
                        ],
                    ],
                ],
                'particulars'     => [
                    'description' => __('Particulars for the resource.'),
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
                'type'            => [
                    'description' => __('Item Type.', 'erp'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'check_no'        => [
                    'description' => __('Payment method for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'deposit_to'      => [
                    'description' => __('Account for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
            ],
        ];

        return $schema;
    }
}
