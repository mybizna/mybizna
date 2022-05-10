<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\LedgerAccounts;

use Illuminate\Support\Facades\DB;

class TaxesController extends Controller
{

    /**
     * Get a collection of taxes
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_tax_rates(Request $request)
    {
        $args = [
            'number'     => !empty($request['per_page']) ? (int) $request['per_page'] : 20,
            'offset'     => ($request['per_page'] * ($request['page'] - 1)),
            'start_date' => empty($request['start_date']) ? '' : $request['start_date'],
            'end_date'   => empty($request['end_date']) ? date('Y-m-d') : $request['end_date'],
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data    = $taxes->getAllTaxRates($args);
        $total_items = $taxes->getAllTaxRates(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($tax_data as $item) {
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
     * Get an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_tax_rate(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $item = $taxes->getTaxRate($id);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $item     = $this->prepare_item_for_response($item, $request, $additional_fields);
        return response()->json($item);

        

        
    }

    /**
     * Create an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function create_tax_rate(Request $request)
    {
        $item_rates = [];

        $tax_data = $this->prepare_item_for_database($request);

        $items = $request['tax_components'];

        foreach ($items as $key => $item) {
            $item_rates[$key] = $item['tax_rate'];
        }

        $tax_data['tax_rate'] = array_sum($item_rates);

        $taxes->insertTaxRate($tax_data);

        $tax_data['id'] = $tax_data['tax_rate_name'];

        $this->add_log($tax_data, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_item_for_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        $response->set_status(201);

        
    }

    /**
     * Update a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function update_tax_rate(Request $request)
    {
        $id         = (int) $request['id'];
        $item_rates = [];

        if (empty($id)) {
            return new WP_Error('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $tax_data = $this->prepare_item_for_database($request);

        $items = $tax_data['tax_components'];

        foreach ($items as $key => $item) {
            $item_rates[$key] = $item['tax_rate'];
        }

        $tax_data['tax_rate'] = array_sum($item_rates);

        $tax_id = $taxes->updateTaxRate($tax_data, $id);

        $tax_data['id'] = $tax_id;

        $this->add_log($tax_data, 'edit');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_item_for_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        $response->set_status(201);

        
    }

    /**
     * Quick Edit a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function quick_edit_tax_rate(Request $request)
    {
        $id         = (int) $request['id'];
        $item_rates = [];

        if (empty($id)) {
            return new WP_Error('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $tax_data = $this->prepare_item_for_database($request);

        $tax_data['tax_rate'] = array_sum($item_rates);

        $tax_id = $taxes->quickEditTaxRate($tax_data, $id);

        $tax_data['id'] = $tax_id;

        $this->add_log($tax_data, 'edit');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_item_for_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        $response->set_status(201);

        
    }

    /**
     * Add component of a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function line_add_tax_rate(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $tax_data = $this->prepare_line_item_for_database($request);

        $line_id = $taxes->addTaxRateLine($tax_data);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_tax_line_for_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        

        
    }

    /**
     * Update component of a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function line_edit_tax_rate(Request $request)
    {
        $id         = (int) $request['id'];
        $item_rates = [];

        if (empty($id)) {
            return new WP_Error('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $tax_data = $this->prepare_line_item_for_database($request);

        $line_id = $taxes->editTaxRateLine($tax_data);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_tax_line_for_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        $response->set_status(201);

        
    }

    /**
     * Update component of a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function line_delete_tax_rate(Request $request)
    {
        $id = (int) $request['db_id'];

        if (empty($id)) {
            return new WP_Error('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $this->deleteTaxRateLine($id);

        return new WP_REST_Response(true, 204);
    }

    /**
     * Delete an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return WP_Error|\Illuminate\Http\Request
     */
    public function delete_tax_rate(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $item = $taxes->getTaxRate($id);

        $taxes->deleteTaxRate($id);

        $this->add_log($item, 'delete');

        return new WP_REST_Response(true, 204);
    }

    /**
     * Get all tax payment records
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return WP_Error|\Illuminate\Http\Request
     */
    public function get_tax_records(Request $request)
    {
        $args = [
            'number'     => !empty($request['per_page']) ? (int) $request['per_page'] : 20,
            'offset'     => ($request['per_page'] * ($request['page'] - 1)),
            'start_date' => empty($request['start_date']) ? '' : $request['start_date'],
            'end_date'   => empty($request['end_date']) ? date('Y-m-d') : $request['end_date'],
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data    = $taxes->getTaxPayRecords($args);
        $total_items = $taxes->getTaxPayRecords(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($tax_data as $item) {
            if (isset($request['include'])) {
                $include_params = explode(',', str_replace(' ', '', $request['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $data              = $this->prepare_tax_pay_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        return response()->json($formatted_items);

        

        
    }

    /**
     * Get a tax payment
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_tax_pay_record(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_tax_pay_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $item = $taxes->getTaxPayRecord($id);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $item     = $this->prepare_tax_pay_response($item, $request, $additional_fields);
        return response()->json($item);

        

        
    }

    /**
     * Make a tax payment
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return WP_Error|\Illuminate\Http\Request
     */
    public function pay_tax(Request $request)
    {
        $tax_data = $this->prepare_item_for_database($request);

        $tax_id = $taxes->payTax($tax_data);

        $tax_data['id'] = $tax_id;

        $tax_data['voucher_no'] = $tax_id; // do we need it?

        $this->add_log($tax_data, 'add', true);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_tax_pay_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        $response->set_status(201);

        
    }

    /**
     * Tax summary
     */
    public function get_tax_summary(Request $request)
    {
        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $summary = $taxes->taxSummary();

        foreach ($summary as $item) {
            $data              = $this->prepare_tax_summary_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        return response()->json($formatted_items);

        

        
    }

    /**
     * Bulk delete action
     *
     * @param object $request
     *
     * @return object
     */
    public function bulk_delete(Request $request)
    {
        $ids = $request['ids'];
        $ids = explode(',', $ids);

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $item = $taxes->getTaxRate($id);

            $taxes->deleteTaxRate($id);

            $this->add_log($item, 'delete');
        }

        return new WP_REST_Response(true, 204);
    }

    /**
     * Log tax related actions
     *
     * @param array $data
     * @param string $action
     * @param bool $is_payment
     *
     * @return void
     */
    public function add_log($data, $action, $is_payment = false)
    {
        switch ($action) {
            case 'edit':
                $operation = 'updated';
                break;
            case 'delete':
                $operation = 'deleted';
                break;
            default:
                $operation = 'created';
        }

        if (!$is_payment) {
            $sub_comp = __('Tax Rate', 'erp');
            $message  = sprintf(__('A tax rate has been %s', 'erp'), $operation);
        } else {
            $sub_comp = __('Tax Payment', 'erp');
            $message  = sprintf(__('A tax payment of %1$s has been %2$s', 'erp'), $data['amount'], $operation);
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

        if (isset($request['tax_rate_name'])) {
            $prepared_item['tax_rate_name'] = $request['tax_rate_name'];
        }

        if (isset($request['is_compound'])) {
            $prepared_item['is_compound'] = $request['is_compound'];
        }

        if (isset($request['tax_components'])) {
            $prepared_item['tax_components'] = $request['tax_components'];
        }

        if (isset($request['trn_date'])) {
            $prepared_item['trn_date'] = $request['trn_date'];
        }

        if (isset($request['trn_by'])) {
            $prepared_item['trn_by'] = $request['trn_by'];
        }

        if (isset($request['tax_category_id'])) {
            $prepared_item['tax_category_id'] = $request['tax_category_id'];
        }

        if (isset($request['particulars'])) {
            $prepared_item['particulars'] = $request['particulars'];
        }

        if (isset($request['amount'])) {
            $prepared_item['amount'] = $request['amount'];
        }

        if (isset($request['ledger_id'])) {
            $prepared_item['ledger_id'] = $request['ledger_id'];
        }

        if (isset($request['agency_id'])) {
            $prepared_item['agency_id'] = $request['agency_id'];
        }

        if (isset($request['voucher_type'])) {
            $prepared_item['voucher_type'] = $request['voucher_type'];
        }

        if (isset($request['tax_rate'])) {
            $prepared_item['tax_rate'] = $request['tax_rate'];
        }

        return $prepared_item;
    }

    /**
     * Prepare a line item of a single tax rate create or update
     *
     * @param \Illuminate\Http\Request $request request object
     *
     * @return array $prepared_item
     */
    protected function prepare_line_item_for_database(Request $request)
    {
        $prepared_item = [];

        if (isset($request['tax_id'])) {
            $prepared_item['tax_id'] = $request['tax_id'];
        }

        if (isset($request['db_id'])) {
            $prepared_item['db_id'] = $request['db_id'];
        }

        if (isset($request['row_id'])) {
            $prepared_item['row_id'] = $request['row_id'];
        }

        if (isset($request['component_name'])) {
            $prepared_item['component_name'] = $request['component_name'];
        }

        if (isset($request['agency_id'])) {
            $prepared_item['agency_id'] = $request['agency_id'];
        }

        if (isset($request['tax_cat_id'])) {
            $prepared_item['tax_cat_id'] = $request['tax_cat_id'];
        }

        if (isset($request['tax_rate'])) {
            $prepared_item['tax_rate'] = $request['tax_rate'];
        }

        return $prepared_item;
    }

    /**
     * Prepare a single tax rate output for response
     *
     * @param array           $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepare_item_for_response($item, Request $request,  $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'id'             => (int) $item->id,
            'tax_rate_name'  => $item->tax_rate_name,
            'tax_rate'       => !empty($item->tax_rate) ? $item->tax_rate : '',
            'tax_components' => !empty($item->tax_components) ? $item->tax_components : '',
        ];

        $data = array_merge($data, $additional_fields);


        return $data;
    }

    /**
     * Prepare a tax rate line item output for response
     *
     * @param array           $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepare_tax_line_for_response($item, Request $request, $additional_fields = [])
    {
        $data = array_merge($item, $additional_fields);

        // Wrap the data in a response object
        return response()->json($data);

        $response = $this->add_links($response, $item, $additional_fields);

        
    }

    /**
     * Prepare a single tax payment output for response
     *
     * @param array           $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepare_tax_pay_response($item, Request $request, $additional_fields = [])
    {

        $taxagencies = new TaxAgencies();
        $ledger = new LedgerAccounts();
        $item = (object) $item;

        $data = [
            'id'           => (int) $item->id,
            'voucher_no'   => $item->voucher_no,
            'agency_id'    => $taxagencies->getTaxAgencyNameById($item->agency_id),
            'trn_date'     => $item->trn_date,
            'particulars'  => $item->particulars,
            'amount'       => $item->amount,
            'trn_by'       => $item->trn_by,
            'ledger_id'    => $ledger->getLedgerNameById($item->ledger_id),
            'voucher_type' => $item->voucher_type,
            'created_at'   => $item->created_at,
        ];

        $data = array_merge($data, $additional_fields);

        // Wrap the data in a response object
        return response()->json($data);

        $response = $this->add_links($response, $item, $additional_fields);

        
    }

    /**
     * Prepare tax summary output for response
     *
     * @param array           $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepare_tax_summary_response($item, Request $request, $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'tax_zone_id'           => (int) $item->tax_zone_id,
            'agency_id'             => (int) $item->agency_id,
            'tax_rate_id'           => (int) $item->tax_rate_id,
            'tax_rate_name'         => $item->tax_rate_name,
            'default'               => (int) $item->default,
            'sales_tax_category_id' => $item->tax_cat_id,
            'tax_rate'              => !empty($item->tax_rate) ? $item->tax_rate : null,
        ];

        $data = array_merge($data, $additional_fields);

        // Wrap the data in a response object
        return response()->json($data);

        $response = $this->add_links($response, $item, $additional_fields);

        
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
            'title'      => 'tax',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'tax_rate_name'       => [
                    'description' => __('Tax rate name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'readonly'    => true,
                ],
                'is_compound' => [
                    'description' => __('Tax type for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                ],
                'tax_components'    => [
                    'description' => __('Components for the resource.', 'erp'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'component_name'   => [
                            'description' => __('Component name for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'agency_id' => [
                            'description' => __('Agency id for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'tax_category_id' => [
                            'description' => __('Tax category id for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'tax_rate' => [
                            'description' => __('Tax rate for the resource.', 'erp'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
            ],
        ];

        return $schema;
    }
}
