<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\Products;
use Modules\Account\Classes\TaxCats;

use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Get a collection of inventory_products
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getInventoryProducts(Request $request)
    {

        $products = new Products();

        $input = $request->all();

        $args = [
            'number' => !empty($input['number']) ? (int) $input['number'] : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
            's'      => !empty($input['s']) ? $input['s'] : ''
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        $product_data = $products->getAllProducts($args);
        $total_items  = $products->getAllProducts(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($product_data as $item) {
            $formatted_items[]              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get a specific inventory product
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getInventoryProduct(Request $request)
    {
        $products = new Products();

        $input = $request->all();

        $id   = (int) $input['id'];
        $item = $products->getAllProducts($id);

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_inventory_product_invalid_id', __('Invalid resource id.'));
            return;
        }

        $additional_fields['namespace'] = __NAMESPACE__;
        $item                           = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($item);
    }

    /**
     * Create an inventory product
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function createInventoryProduct(Request $request)
    {
        $products = new Products();

        $item  = $this->prepareItemFDatabase($request);

        $id    = $products->insertProduct($item);

        if (!$id) {
            return $id;
        }

        $item['id'] = $id;

        $this->addLog($item, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $response = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Update an inventory product
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function updateInventoryProduct(Request $request)
    {
        $products = new Products();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_payment_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $this->prepareItemFDatabase($request);

        $old_data = $products->getAllProducts($id);

        $id = $products->updateProduct($item, $id);

        if (!$id) {
            return $id;
        }

        $this->addLog($item, 'edit', $old_data);

        $item['id'] = $id;

        $additional_fields['namespace'] = __NAMESPACE__;

        $response = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Delete an inventory product
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function deleteInventoryProduct(Request $request)
    {
        $products = new Products();

        $input = $request->all();

        $id = (int) $input['id'];

        $item = $products->getAllProducts($id);

        $products->deleteProduct($id);

        $this->addLog($item, 'delete');

        return response()->json(['status'=> true]);
    }

    /**
     * Validates csv file data for products
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCsvData(Request $request)
    {
        $products = new Products();

        $input = $request->all();

        $args = [
            'csv_file'        => !empty($_FILES['csv_file'])         ? $_FILES['csv_file']         : '',
            'type'            => !empty($input['type'])            ? $input['type']            : '',
            'category_id'     => !empty($input['category_id'])     ? $input['category_id']     : '',
            'product_type_id' => !empty($input['product_type_id']) ? $input['product_type_id'] : '',
            'tax_cat_id'      => !empty($input['tax_cat_id'])      ? $input['tax_cat_id']      : '',
            'vendor'          => !empty($input['vendor'])          ? $input['vendor']          : '',
            'update_existing' => !empty($input['update_existing']) ? $input['update_existing'] : '',
            'fields'          => !empty($input['fields'])          ? $input['fields']          : '',
        ];

        $data = $products->validateCsvData($args);

        if (!$data) {
            return $data;
        }

        return response()->json($data);
    }

    /**
     * Import products from csv
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function importProducts(Request $request)
    {
        $products = new Products();

        $input = $request->all();

        $args = [
            'items'  => !empty($input['items'])  ? $input['items']   : '',
            'update' => !empty($input['update']) ? $input['update']  : '',
            'total'  => !empty($input['total'])  ? $input['total']   : '',
        ];

        $imported = $products->importProducts($args);

        if (!$imported) {
            return $imported;
        }

        return response()->json($imported);
    }

    /**
     * Log for inventory product related actions
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
        // required arguments.
        if (isset($input['name'])) {
            $prepared_item['name'] = $input['name'];
        }

        if (isset($input['product_type_id'])) {
            $prepared_item['product_type_id'] = $input['product_type_id']['id'];
        }

        if (isset($input['category_id'])) {
            $prepared_item['category_id'] = $input['category_id']['id'];
        }

        if (isset($input['tax_cat_id'])) {
            $prepared_item['tax_cat_id'] = $input['tax_cat_id']['id'];
        }

        if (isset($input['vendor'])) {
            $prepared_item['vendor'] = $input['vendor']['id'];
        }

        if (isset($input['cost_price'])) {
            $prepared_item['cost_price'] = $input['cost_price'];
        }

        if (isset($input['sale_price'])) {
            $prepared_item['sale_price'] = $input['sale_price'];
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
        $tax_cats = new TaxCats();

        $item = (object) $item;

        $data = [
            'id'                => $item->id,
            'name'              => $item->name,
            'product_type_id'   => $item->product_type_id,
            'product_type_name' => !empty($item->product_type_name) ? $item->product_type_name : '',
            'category_id'       => $item->category_id,
            'tax_cat_id'        => $item->tax_cat_id,
            'vendor'            => !empty($item->vendor) ? $item->vendor : '',
            'cost_price'        => $item->cost_price,
            'sale_price'        => $item->sale_price,
            'vendor_name'       => !empty($item->vendor_name) ? $item->vendor_name : '',
            'cat_name'          => !empty($item->cat_name) ? $item->cat_name : '',
            'tax_cat_name'      => $tax_cats->getTaxCategoryById($item->tax_cat_id),
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
            'title'      => 'inv_product',
            'type'       => 'object',
            'properties' => [
                'id'              => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'name'            => [
                    'description' => __('Name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'product_type_id'    => [
                    'description' => __('State for the resource.'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                            'required'    => true,
                        ],
                        'name' => [
                            'description' => __('Type name for the resource.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                            'arg_options' => [
                                'sanitize_callback' => 'sanitize_text_field',
                            ],
                        ],
                    ],
                ],
                'category_id'    => [
                    'description' => __('Category id for the resource.'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('Type name for the resource.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'parent' => [
                            'description' => __('Parent category for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'tax_cat_id'    => [
                    'description' => __('Tax category id for the resource.'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('Tax category name for the resource.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'description' => [
                            'description' => __('Description for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'vendor'    => [
                    'description' => __('Vendor for the resource.'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                            'required'    => false,
                        ],
                        'name' => [
                            'description' => __('Name for the resource.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                            'arg_options' => [
                                'sanitize_callback' => 'sanitize_text_field',
                            ],
                        ],
                    ],
                ],
                'cost_price'      => [
                    'description' => __('Cost price for the resource.'),
                    'type'        => 'number',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'sale_price'      => [
                    'description' => __('Sale price for the resource.'),
                    'type'        => 'number',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
            ],
        ];

        return $schema;
    }

    /**
     * Get product type
     *
     * @return object
     */
    public function get_product_types()
    {
        $products = new Products();

        $types    = $products->getProductTypes();
        return response()->json($types);
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
        $products = new Products();

        $input = $request->all();

        $ids = $input['ids'];
        $ids = explode(',', $ids);

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $products->deleteProduct($id);
        }

        return response()->json(['status'=> true]);
    }
}
