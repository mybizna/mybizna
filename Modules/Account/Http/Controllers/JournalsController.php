<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\Invoices;
use Modules\Account\Classes\Journals;


use Illuminate\Support\Facades\DB;

class JournalsController extends Controller
{

    /**
     * Get a collection of journals
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getJournals(Request $request)
    {
        $journals = new Journals();
        $input = $request->all();

        $args['number'] = !empty($input['per_page']) ? $input['per_page'] : 20;
        $args['offset'] = ($input['per_page'] * ($input['page'] - 1));

        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $items       = $journals->getAllJournals($args);
        $total_items = $journals->getAllJournals(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        $formatted_items = [];

        foreach ($items as $item) {
            $formatted_items[]              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items)
            ->withHeaders([
                'x-wp-total' => $total_items,
                'x-wp-totalpages' => $total_items ? floor($total_items / $args['number']) : 1
            ]);
    }

    /**
     * Get a specific journal
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getJournal(Request $request)
    {
        $invoices = new Invoices();

        $input = $request->all();

        $id                = (int) $input['id'];
        $additional_fields = [];

        if (empty($id)) {
            messageBag('rest_journal_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $invoices->updateInvoice($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $item = $this->prepareItemForResponse($item, $request, $additional_fields);

        return response()->json($item);
    }

    /**
     * Get a next journal id
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getNextJournalId(Request $request)
    {


        $count      = DB::select('SELECT count(*) FROM ' . 'account_journal');
        $count = (!empty($count)) ? $count[0] : null;

        $item['id'] = $count['0'] + 1;

        return response()->json($item);
    }

    /**
     * Create a journal
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function createJournal(Request $request)
    {
        $trans_data = $this->prepareItemFDatabase($request);

        $items            = $trans_data['line_items'];
        $vocher_amount_dr = [];
        $vocher_amount_cr = [];

        foreach ($items as $key => $item) {
            $vocher_amount_dr[$key] = (float) $item['debit'];
            $vocher_amount_cr[$key] = (float) $item['credit'];
        }

        $total_dr = array_sum($vocher_amount_dr);
        $total_cr = array_sum($vocher_amount_cr);

        $trans_data['voucher_amount'] = $total_dr;

        $journal = $this->insertJournal($trans_data);

        $this->addLog($journal, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $response = $this->prepareItemForResponse($journal, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Log when journal is created
     *
     * @param $data
     * @param $action
     */
    public function addLog($data, $action)
    {
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

        if (isset($input['type'])) {
            $prepared_item['type'] = $input['type'];
        }

        if (isset($input['trn_date'])) {
            $prepared_item['date'] = $input['trn_date'];
        }

        if (isset($input['attachments'])) {
            $prepared_item['attachments'] = maybe_serialize($input['attachments']);
        }

        if (isset($input['particulars'])) {
            $prepared_item['particulars'] = $input['particulars'];
        }

        if (isset($input['line_items'])) {
            $prepared_item['line_items'] = $input['line_items'];
        }

        if (isset($input['ref'])) {
            $prepared_item['ref'] = $input['ref'];
        }

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param object          $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $input = $request->all();

        $item = (object) $item;

        $data = [
            'id'          => $item->id,
            'voucher_no'  => $item->voucher_no,
            'particulars' => $item->particulars,
            'ref'         => $item->ref,
            'trn_date'    => $item->trn_date,
            'line_items'  => !empty($item->line_items) ? $item->line_items : [],
            'attachments' => maybe_unserialize($item->attachments),
            'total'       => (float) $item->voucher_amount,
            'created_at'  => $item->created_at,
        ];

        if (isset($input['include'])) {
            $include_params = explode(',', str_replace(' ', '', $input['include']));

            if (in_array('created_by', $include_params, true)) {
                $data['created_by'] = $this->get_user(intval($item->created_by));
            }
        }

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
            'title'      => 'journal',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'trn_date' => [
                    'description' => __('Transaction date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'ref' => [
                    'description' => __('Reference for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'type' => [
                    'description' => __('Type for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'line_items'      => [
                    'description' => __('List of line items data.'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'ledger_id'   => [
                            'description' => __('Ledger id.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'particulars' => [
                            'description' => __('Line particulars.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                            'arg_options' => [
                                'sanitize_callback' => 'sanitize_text_field',
                            ],
                        ],
                        'debit' => [
                            'description' => __('Debit balance.'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                        'credit'          => [
                            'description' => __('Credit balance.'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'particulars' => [
                    'description' => __('Particulars for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'attachments' => [
                    'description' => __('Attachments for the resource.'),
                    'type'        => 'object',
                    'context'     => ['edit'],
                ],
            ],
        ];

        return $schema;
    }
}
