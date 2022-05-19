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

        $args = [
            'number' => !empty($request['number']) ? (int) $request['number'] : 20,
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
            's'      => !empty($request['s']) ? $request['s'] : ''
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $product_data = $products->getAllProducts($args);
        $total_items  = $products->getAllProducts(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($product_data as $item) {
            $data              = $this->prepareItemForResponse($item, $request, $additional_fields);
            $formatted_items[] = $this->prepareResponseForCollection($data);
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

        $id   = (int) $request['id'];
        $item = $products->getAllProducts($id);

        if (empty($id)) {
            messageBag()->add('rest_inventory_product_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return;
        }

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;
        $item                           = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($item);
    }

    /**
     * Create an inventory product
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
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

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Update an inventory product
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function updateInventoryProduct(Request $request)
    {
        $products = new Products();

        $id = (int) $request['id'];

        if (empty($id)) {
            messageBag()->add('rest_payment_invalid_id', __('Invalid resource id.'), ['status' => 404]);
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

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Delete an inventory product
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function deleteInventoryProduct(Request $request)
    {
        $products = new Products();

        $id = (int) $request['id'];

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

        $args = [
            'csv_file'        => !empty($_FILES['csv_file'])         ? $_FILES['csv_file']         : '',
            'type'            => !empty($request['type'])            ? $request['type']            : '',
            'category_id'     => !empty($request['category_id'])     ? $request['category_id']     : '',
            'product_type_id' => !empty($request['product_type_id']) ? $request['product_type_id'] : '',
            'tax_cat_id'      => !empty($request['tax_cat_id'])      ? $request['tax_cat_id']      : '',
            'vendor'          => !empty($request['vendor'])          ? $request['vendor']          : '',
            'update_existing' => !empty($request['update_existing']) ? $request['update_existing'] : '',
            'fields'          => !empty($request['fields'])          ? $request['fields']          : '',
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

        $args = [
            'items'  => !empty($request['items'])  ? $request['items']   : '',
            'update' => !empty($request['update']) ? $request['update']  : '',
            'total'  => !empty($request['total'])  ? $request['total']   : '',
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
        $prepared_item = [];
        // required arguments.
        if (isset($request['name'])) {
            $prepared_item['name'] = $request['name'];
        }

        if (isset($request['product_type_id'])) {
            $prepared_item['product_type_id'] = $request['product_type_id']['id'];
        }

        if (isset($request['category_id'])) {
            $prepared_item['category_id'] = $request['category_id']['id'];
        }

        if (isset($request['tax_cat_id'])) {
            $prepared_item['tax_cat_id'] = $request['tax_cat_id']['id'];
        }

        if (isset($request['vendor'])) {
            $prepared_item['vendor'] = $request['vendor']['id'];
        }

        if (isset($request['cost_price'])) {
            $prepared_item['cost_price'] = $request['cost_price'];
        }

        if (isset($request['sale_price'])) {
            $prepared_item['sale_price'] = $request['sale_price'];
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
                    'description' => __('State for the resource.', 'erp'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                            'required'    => true,
                        ],
                        'name' => [
                            'description' => __('Type name for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                            'arg_options' => [
                                'sanitize_callback' => 'sanitize_text_field',
                            ],
                        ],
                    ],
                ],
                'category_id'    => [
                    'description' => __('Category id for the resource.', 'erp'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('Type name for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'parent' => [
                            'description' => __('Parent category for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'tax_cat_id'    => [
                    'description' => __('Tax category id for the resource.', 'erp'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('Tax category name for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'description' => [
                            'description' => __('Description for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'vendor'    => [
                    'description' => __('Vendor for the resource.', 'erp'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                            'required'    => false,
                        ],
                        'name' => [
                            'description' => __('Name for the resource.', 'erp'),
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

        $ids = $request['ids'];
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
