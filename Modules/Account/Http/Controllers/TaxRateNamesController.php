<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\TaxRateNames;


use Illuminate\Support\Facades\DB;

class TaxRateNamesController extends Controller
{

    /**
     * Get a collection of taxes
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxRateNames(Request $request)
    {
        $taxratenames = new TaxRateNames();

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

        $tax_data    = $taxratenames->getAllTaxRateNames($args);
        $total_items = $taxratenames->getAllTaxRateNames(
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
    public function getTaxRateName(Request $request)
    {
        $taxratenames = new TaxRateNames();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $taxratenames->getTaxRateName($id);

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
    public function createTaxRateName(Request $request)
    {

        $taxratenames = new TaxRateNames();

        $tax_data = $this->prepareItemFDatabase($request);

        $tax_id = $taxratenames->insertTaxRateName($tax_data);

        $tax_data['id'] = $tax_id;

        $this->addLog($tax_data, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareItemForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Update an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTaxRateName(Request $request)
    {
        $taxratenames = new TaxRateNames();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $tax_data = $this->prepareItemFDatabase($request);
        $old_data = $taxratenames->getTaxRateName($id);
        $tax_id   = $taxratenames->updateTaxRateName($tax_data, $id);

        $this->addLog($tax_data, 'edit', $old_data);

        $tax_data['id']                 = $tax_id;
        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareItemForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Delete an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTaxRateName(Request $request)
    {
        $taxratenames = new TaxRateNames();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $taxratenames->getTaxRateName($id);

        $taxratenames->deleteTaxRateName($id);

        $this->addLog($item, 'delete');

        return response()->json(['status' => true]);
    }

    /**
     * Bulk delete action
     *
     * @param object $request
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $taxratenames = new TaxRateNames();

        $input = $request->all();

        $ids = $input['ids'];
        $ids = explode(',', $ids);

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $item = $taxratenames->getTaxRateName($id);

            $taxratenames->deleteTaxRateName($id);

            $this->addLog($item, 'delete');
        }

        return response()->json(['status' => true]);
    }

    /**
     * Log for tax zone related actions
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

        if (isset($input['tax_rate_name'])) {
            $prepared_item['tax_rate_name'] = $input['tax_rate_name'];
        }

        if (isset($input['tax_number'])) {
            $prepared_item['tax_number'] = $input['tax_number'];
        }

        if (isset($input['default'])) {
            $prepared_item['default'] = $input['default'];
        }

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param array           $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $data = array_merge($item, $additional_fields);


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
            'title'      => 'tax',
            'type'       => 'object',
            'properties' => [
                'id'   => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'tax_rate_name' => [
                    'description' => __('Tax rate name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'tax_number' => [
                    'description' => __('Tax number for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'default' => [
                    'description' => __('Tax default value for the resource.'),
                    'type'        => ['integer', 'string', 'boolean'],
                    'context'     => ['view', 'edit'],
                ],
            ],
        ];

        return $schema;
    }
}
