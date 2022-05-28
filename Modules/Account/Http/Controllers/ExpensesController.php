<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\Expenses;

use Illuminate\Support\Facades\DB;
use Modules\Expense\Entities\Expense;

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
        $expense = new Expenses();

        $input = $request->all();

        $args = [
            'number' => isset($input['per_page']) ? $input['per_page'] : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $expense_data = $expense->getExpenses($args);
        $total_items  =  $expense->getExpenses(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($expense_data as $item) {
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
     * Get a expense
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpense(Request $request)
    {
        $expense = new Expenses();
        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_expense_invalid_id', __('Invalid resource id.'));
            return;
        }

        $expense_data       = $expense->getExpense($id);
        $expense_data['id'] = $id;

        $expense_data['created_by'] = $this->get_user($expense_data['created_by']);

        $additional_fields['namespace'] = __NAMESPACE__;

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
        $expense = new Expenses();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_check_invalid_id', __('Invalid resource id.'));
            return;
        }

        $expense_data       = $expense->getCheck($id);
        $expense_data['id'] = $id;

        $expense_data['created_by'] = $this->get_user($expense_data['created_by']);

        $additional_fields['namespace'] = __NAMESPACE__;

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
        $expenses = new Expenses();

        $input = $request->all();

        $expense_data = $this->prepareItemFDatabase($request);

        $item_amount       = [];
        $item_total        = [];
        $additional_fields = [];

        $items = $input['bill_details'];

        foreach ($items as $key => $item) {
            $item_amount[$key] = $item['amount'];
            $item_total[$key]  = $item['amount'];
        }
        $expense_data['attachments'] = maybe_serialize($input['attachments']);
        $expense_data['amount']      = array_sum($item_total);

        $expense = $expenses->insertExpense($expense_data);
        $this->addLog((array) $expense, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

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
        $expense = new Expenses();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_expense_invalid_id', __('Invalid resource id.'));
            return;
        }

        $expense_data = $this->prepareItemFDatabase($request);

        $item_amount       = [];
        $item_total        = [];
        $additional_fields = [];

        $items = $input['bill_details'];

        foreach ($items as $key => $item) {
            $item_amount[$key] = $item['amount'];
            $item_total[$key]  = $item['amount'];
        }
        $expense_data['attachments'] = maybe_serialize($input['attachments']);
        $expense_data['amount']      = array_sum($item_total);

        $old_data   = $expense->getExpense($id);
        $expense_id = $this->updateExpense($expense_data, $id);

        $this->addLog($expense_data, 'edit', $old_data);

        $expense_data['id']             = $expense_id;
        $additional_fields['namespace'] = __NAMESPACE__;

        $expense_data = $this->prepareItemForResponse($expense_data, $request, $additional_fields);

        return response()->json($expense_data);
    }

    /**
     * Void a expense
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function voidExpense(Request $request)
    {
        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_expense_invalid_id', __('Invalid resource id.'));
            return;
        }

        $this->voidExpense($id);

        return response()->json(['status' => true]);;
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
        $input = $request->all();

        $prepared_item = [];

        if (isset($input['people_id'])) {
            $prepared_item['people_id'] = $input['people_id'];
        }

        if (isset($input['ref'])) {
            $prepared_item['ref'] = $input['ref'];
        }

        if (isset($input['bank'])) {
            $prepared_item['bank'] = $input['bank'];
        }

        if (isset($input['check_no'])) {
            $prepared_item['check_no'] = $input['check_no'];
        }

        if (isset($input['trn_date'])) {
            $prepared_item['trn_date'] = $input['trn_date'];
        }

        if (isset($input['due_date'])) {
            $prepared_item['due_date'] = $input['due_date'];
        }

        if (isset($input['amount'])) {
            $prepared_item['total'] = $input['amount'];
        }

        if (isset($input['trn_no'])) {
            $prepared_item['trn_no'] = $input['trn_no'];
        }

        if (isset($input['attachments'])) {
            $prepared_item['attachments'] = $input['attachments'];
        }

        if (isset($input['deposit_to'])) {
            $prepared_item['trn_by_ledger_id'] = $input['deposit_to'];
        }

        if (isset($input['trn_by'])) {
            $prepared_item['trn_by'] = $input['trn_by'];
        }

        if (isset($input['bank_trn_charge'])) {
            $prepared_item['bank_trn_charge'] = $input['bank_trn_charge'];
        }

        if (isset($input['bill_details'])) {
            $prepared_item['bill_details'] = $input['bill_details'];
        }

        if (isset($input['billing_address'])) {
            $prepared_item['billing_address'] = $input['billing_address'];
        }

        if (isset($input['particulars'])) {
            $prepared_item['particulars'] = $input['particulars'];
        }

        if (isset($input['status'])) {
            $prepared_item['status'] = $input['status'];
        }

        if (isset($input['attachments'])) {
            $prepared_item['attachments'] = $input['attachments'];
        }

        if (isset($input['name'])) {
            $prepared_item['name'] = $input['name'];
        }

        if (isset($input['pay_to'])) {
            $prepared_item['pay_to'] = $input['pay_to'];
        }

        if (isset($input['type'])) {
            $prepared_item['voucher_type'] = $input['type'];
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
                    'description' => __('List of line items data.'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'ledger_id'   => [
                            'description' => __('Ledger id.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                            'required'    => true,
                        ],
                        'particulars' => [
                            'description' => __('Bill Particulars.'),
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
                    'description' => __('Item Type.'),
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
