<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;

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
    public function get_tax_cats(Request $request)
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

        $tax_data    = $this->getAllTaxCats($args);
        $total_items = $this->getAllTaxCats(
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
    public function get_tax_cat(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $item = $taxcats->getTaxCat($id);

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
    public function create_tax_cat(Request $request)
    {
        $tax_data = $this->prepare_item_for_database($request);

        $tax_id = $taxcats->insertTaxCat($tax_data);

        $tax_data['id'] = $tax_id;

        $this->add_log($tax_data, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_item_for_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        $response->set_status(201);

        
    }

    /**
     * Update an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function update_tax_cat(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $tax_data = $this->prepare_item_for_database($request);

        $items = $request['tax_components'];

        foreach ($items as $key => $item) {
            $item_rates[$key] = $item['tax_rate'];
        }

        $tax_data['total_rate'] = array_sum($item_rates);

        $old_data = $taxcats->getTaxCat($id);
        $tax_id   = $taxcats->updateTaxCat($tax_data, $id);

        $this->add_log($tax_data, 'edit', $old_data);

        $tax_data['id']                 = $tax_id;
        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $tax_data = $this->prepare_item_for_response($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
        $response->set_status(201);

        
    }

    /**
     * Delete an tax
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_tax_cat(Request $request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_tax_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $item = $taxcats->getTaxCat($id);

        $taxcats->deleteTaxCat($id);

        $this->add_log($item, 'delete');

        return new WP_REST_Response(true, 204);
    }

    /**
     * Bulk delete action
     *
     * @param object $request
     *
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(Request $request)
    {
        $ids = $request['ids'];
        $ids = explode(',', $ids);

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $item = $taxcats->getTaxCat($id);

            $taxcats->deleteTaxCat($id);

            $this->add_log($item, 'delete');
        }

        return new WP_REST_Response(true, 204);
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

        if (isset($request['name'])) {
            $prepared_item['name'] = $request['name'];
        }

        if (isset($request['description'])) {
            $prepared_item['description'] = $request['description'];
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
    public function prepare_item_for_response($item, Request $request, $additional_fields = [])
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
    public function get_item_schema()
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
