<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\LedgerAccounts;
use Modules\Account\Classes\Taxes;
use Modules\Account\Classes\TaxAgencies;

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
    public function getTaxRates(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $args = [
            'number'     => !empty($input['per_page']) ? (int) $input['per_page'] : 20,
            'offset'     => ($input['per_page'] * ($input['page'] - 1)),
            'start_date' => empty($input['start_date']) ? '' : $input['start_date'],
            'end_date'   => empty($input['end_date']) ? date('Y-m-d') : $input['end_date'],
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data    = $taxes->getAllTaxRates($args);
        $total_items = $taxes->getAllTaxRates(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($tax_data as $item) {
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
     * Get an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxRate(Request $request)
    {

        $taxes = new Taxes();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $taxes->getTaxRate($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $item     = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($item);
    }

    /**
     * Create an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function createTaxRate(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $item_rates = [];

        $tax_data = $this->prepareItemFDatabase($request);

        $items = $input['tax_components'];

        foreach ($items as $key => $item) {
            $item_rates[$key] = $item['tax_rate'];
        }

        $tax_data['tax_rate'] = array_sum($item_rates);

        $taxes->insertTaxRate($tax_data);

        $tax_data['id'] = $tax_data['tax_rate_name'];

        $this->addLog($tax_data, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareItemForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Update a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTaxRate(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $id         = (int) $input['id'];
        $item_rates = [];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $tax_data = $this->prepareItemFDatabase($request);

        $items = $tax_data['tax_components'];

        foreach ($items as $key => $item) {
            $item_rates[$key] = $item['tax_rate'];
        }

        $tax_data['tax_rate'] = array_sum($item_rates);

        $tax_id = $taxes->updateTaxRate($tax_data, $id);

        $tax_data['id'] = $tax_id;

        $this->addLog($tax_data, 'edit');

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareItemForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Quick Edit a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function quickEditTaxRate(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $id         = (int) $input['id'];
        $item_rates = [];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $tax_data = $this->prepareItemFDatabase($request);

        $tax_data['tax_rate'] = array_sum($item_rates);

        $tax_id = $taxes->quickEditTaxRate($tax_data, $id);

        $tax_data['id'] = $tax_id;

        $this->addLog($tax_data, 'edit');

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareItemForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Add component of a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function lineAddTaxRate(Request $request)
    {
         $taxes = new Taxes();

         $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $tax_data = $this->prepareLineItemForDatabase($request);

        $line_id = $taxes->addTaxRateLine($tax_data);

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareTaxLineForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Update component of a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function lineEditTaxRate(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $id         = (int) $input['id'];
        $item_rates = [];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $tax_data = $this->prepareLineItemForDatabase($request);

        $line_id = $taxes->editTaxRateLine($tax_data);

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareTaxLineForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Update component of a tax rate
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function lineDeleteTaxRate(Request $request)
    {

        $input = $request->all();
        $id = (int) $input['db_id'];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $this->deleteTaxRateLine($id);

        return response()->json(['status'=> true]);
    }

    /**
     * Delete an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function deleteTaxRate(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $taxes->getTaxRate($id);

        $taxes->deleteTaxRate($id);

        $this->addLog($item, 'delete');

        return response()->json(['status'=> true]);
    }

    /**
     * Get all tax payment records
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function getTaxRecords(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $args = [
            'number'     => !empty($input['per_page']) ? (int) $input['per_page'] : 20,
            'offset'     => ($input['per_page'] * ($input['page'] - 1)),
            'start_date' => empty($input['start_date']) ? '' : $input['start_date'],
            'end_date'   => empty($input['end_date']) ? date('Y-m-d') : $input['end_date'],
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data    = $taxes->getTaxPayRecords($args);
        $total_items = $taxes->getTaxPayRecords(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($tax_data as $item) {
            if (isset($input['include'])) {
                $include_params = explode(',', str_replace(' ', '', $input['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $formatted_items[]              = $this->prepareTaxPayResponse($item, $request, $additional_fields);
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
    public function getTaxPayRecord(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_tax_pay_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $taxes->getTaxPayRecord($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $item     = $this->prepareTaxPayResponse($item, $request, $additional_fields);
        return response()->json($item);
    }

    /**
     * Make a tax payment
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function payTax(Request $request)
    {
        $taxes = new Taxes();

        $tax_data = $this->prepareItemFDatabase($request);

        $tax_id = $taxes->payTax($tax_data);

        $tax_data['id'] = $tax_id;

        $tax_data['voucher_no'] = $tax_id; // do we need it?

        $this->addLog($tax_data, 'add', true);

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareTaxPayResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Tax summary
     */
    public function getTaxSummary(Request $request)
    {
        $taxes = new Taxes();

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $summary = $taxes->taxSummary();

        foreach ($summary as $item) {
            $formatted_items[]              = $this->prepareTaxSummaryResponse($item, $request, $additional_fields);
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
    public function bulkDelete(Request $request)
    {
        $taxes = new Taxes();

        $input = $request->all();

        $ids = $input['ids'];
        $ids = explode(',', $ids);

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $item = $taxes->getTaxRate($id);

            $taxes->deleteTaxRate($id);

            $this->addLog($item, 'delete');
        }

        return response()->json(['status'=> true]);
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
    public function addLog($data, $action, $is_payment = false)
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
            $sub_comp = __('Tax Rate');
            $message  = sprintf(__('A tax rate has been %s'), $operation);
        } else {
            $sub_comp = __('Tax Payment');
            $message  = sprintf(__('A tax payment of %1$s has been %2$s'), $data['amount'], $operation);
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

        if (isset($input['tax_rate_name'])) {
            $prepared_item['tax_rate_name'] = $input['tax_rate_name'];
        }

        if (isset($input['is_compound'])) {
            $prepared_item['is_compound'] = $input['is_compound'];
        }

        if (isset($input['tax_components'])) {
            $prepared_item['tax_components'] = $input['tax_components'];
        }

        if (isset($input['trn_date'])) {
            $prepared_item['trn_date'] = $input['trn_date'];
        }

        if (isset($input['trn_by'])) {
            $prepared_item['trn_by'] = $input['trn_by'];
        }

        if (isset($input['tax_category_id'])) {
            $prepared_item['tax_category_id'] = $input['tax_category_id'];
        }

        if (isset($input['particulars'])) {
            $prepared_item['particulars'] = $input['particulars'];
        }

        if (isset($input['amount'])) {
            $prepared_item['amount'] = $input['amount'];
        }

        if (isset($input['ledger_id'])) {
            $prepared_item['ledger_id'] = $input['ledger_id'];
        }

        if (isset($input['agency_id'])) {
            $prepared_item['agency_id'] = $input['agency_id'];
        }

        if (isset($input['voucher_type'])) {
            $prepared_item['voucher_type'] = $input['voucher_type'];
        }

        if (isset($input['tax_rate'])) {
            $prepared_item['tax_rate'] = $input['tax_rate'];
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
    protected function prepareLineItemForDatabase(Request $request)
    {
        $prepared_item = [];

        $input = $request->all();

        if (isset($input['tax_id'])) {
            $prepared_item['tax_id'] = $input['tax_id'];
        }

        if (isset($input['db_id'])) {
            $prepared_item['db_id'] = $input['db_id'];
        }

        if (isset($input['row_id'])) {
            $prepared_item['row_id'] = $input['row_id'];
        }

        if (isset($input['component_name'])) {
            $prepared_item['component_name'] = $input['component_name'];
        }

        if (isset($input['agency_id'])) {
            $prepared_item['agency_id'] = $input['agency_id'];
        }

        if (isset($input['tax_cat_id'])) {
            $prepared_item['tax_cat_id'] = $input['tax_cat_id'];
        }

        if (isset($input['tax_rate'])) {
            $prepared_item['tax_rate'] = $input['tax_rate'];
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
    public function prepareItemForResponse($item, Request $request,  $additional_fields = [])
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
    public function prepareTaxLineForResponse($item, Request $request, $additional_fields = [])
    {
        $data = array_merge($item, $additional_fields);

        // Wrap the data in a response object
        return response()->json($data);
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
    public function prepareTaxPayResponse($item, Request $request, $additional_fields = [])
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
    public function prepareTaxSummaryResponse($item, Request $request, $additional_fields = [])
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
                    'description' => __('Components for the resource.'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'component_name'   => [
                            'description' => __('Component name for the resource.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'agency_id' => [
                            'description' => __('Agency id for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'tax_category_id' => [
                            'description' => __('Tax category id for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'tax_rate' => [
                            'description' => __('Tax rate for the resource.'),
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
