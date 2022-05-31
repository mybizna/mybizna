<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\TaxCats;


use Illuminate\Support\Facades\DB;

class TaxCategoriesController extends Controller
{

    /**
     * Get a collection of taxes
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxCats(Request $request)
    {

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

        $tax_data    = $this->getAllTaxCats($args);
        $total_items = $this->getAllTaxCats(
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
    public function getTaxCat(Request $request)
    {
        $taxcats = new TaxCats();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $taxcats->getTaxCat($id);

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
    public function createTaxCat(Request $request)
    {
        $taxcats = new TaxCats();

        $tax_data = $this->prepareItemFDatabase($request);

        $tax_id = $taxcats->insertTaxCat($tax_data);

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
    public function updateTaxCat(Request $request)
    {

        $taxcats = new TaxCats();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $tax_data = $this->prepareItemFDatabase($request);

        $items = $input['tax_components'];

        foreach ($items as $key => $item) {
            $item_rates[$key] = $item['tax_rate'];
        }

        $tax_data['total_rate'] = array_sum($item_rates);

        $old_data = $taxcats->getTaxCat($id);
        $tax_id   = $taxcats->updateTaxCat($tax_data, $id);

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
    public function deleteTaxCat(Request $request)
    {

        $taxcats = new TaxCats();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            messageBag('rest_tax_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $taxcats->getTaxCat($id);

        $taxcats->deleteTaxCat($id);

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

        $taxcats = new TaxCats();

        $input = $request->all();

        $ids = $input['ids'];
        $ids = explode(',', $ids);

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $item = $taxcats->getTaxCat($id);

            $taxcats->deleteTaxCat($id);

            $this->addLog($item, 'delete');
        }

        return response()->json(['status' => true]);
    }

    /**
     * Log for tax category related actions
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

        if (isset($input['name'])) {
            $prepared_item['name'] = $input['name'];
        }

        if (isset($input['description'])) {
            $prepared_item['description'] = $input['description'];
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
        $item = (object) $item;

        $data = [
            'id'          => (int) $item->id,
            'name'        => $item->name,
            'description' => !empty($item->description) ? $item->description : '',
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
            'title'      => 'tax_category',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'name'        => [
                    'description' => __('Tax Category name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'description' => [
                    'description' => __('Tax Category Description for the resource.'),
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
