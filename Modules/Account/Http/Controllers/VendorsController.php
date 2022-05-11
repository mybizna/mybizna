<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\People;
use Modules\Account\Classes\Products;
use Modules\Account\Classes\OpenBalances;


use Illuminate\Support\Facades\DB;

class VendorsController extends Controller
{

    /**
     * Get a collection of vendors
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendors(Request $request)
    {
        $people = new People();
        $args = [
            'number' => $request['per_page'],
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
            'type'   => 'vendor',
            's'      => !empty($request['search']) ? $request['search'] : '',
        ];

        $items       = $people->getAccountingPeople($args);
        $total_items = $people->getAccountingPeople(
            ['type' => 'vendor', 's' => $args['s'], 'count' => true]
        );
        $total_items = is_array($total_items) ? count($total_items) : $total_items;

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        foreach ($items as $item) {
            $photo_id = $people->peopleGetMeta($item->id, 'photo_id', true);

            $item->{'photo_id'} = $photo_id;
            $item->{'photo'}    = wp_get_attachment_thumb_url($photo_id);

            if (isset($request['include'])) {
                $include_params = explode(',', str_replace(' ', '', $request['include']));

                if (in_array('owner', $include_params, true)) {
                    $vendor_owner_id = ($item->user_id) ? get_user_meta($item->user_id, 'contact_owner', true) : $people->peopleGetMeta($item->id, 'contact_owner', true);

                    $item->owner       = $this->get_user($vendor_owner_id);
                    $additional_fields = ['owner' => $item->owner];
                }
            }

            $data              = $this->prepareItemForResponse($item, $request, $additional_fields);
            $formatted_items[] = $this->prepareResponseForCollection($data);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get a specific vendor
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendor(Request $request)
    {

        $people = new People();
        $id   = (int) $request['id'];
        $item = $people->getPeople($id);
        $item = (array) $item;

        if (empty($id) || empty($item['id'])) {
            messageBag()->add('rest_vendor_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $photo_id = $people->peopleGetMeta($id, 'photo_id', true);

        $item['photo_id'] = $photo_id;
        $item['photo']    = wp_get_attachment_thumb_url($photo_id);

        $additional_fields = [];

        if (isset($request['include'])) {
            $include_params = explode(',', str_replace(' ', '', $request['include']));

            if (in_array('owner', $include_params, true)) {
                $vendor_owner_id = ($item->user_id) ? get_user_meta($item->user_id, 'contact_owner', true) : $people->peopleGetMeta($item->id, 'contact_owner', true);

                $item->owner       = $this->get_user($vendor_owner_id);
                $additional_fields = ['owner' => $item->owner];
            }
        }

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;
        $item                           = $this->prepareItemForResponse($item, $request, $additional_fields);
        return response()->json($item);
    }

    /**
     * Create a vendor
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function createVendor(Request $request)
    {
        $people = new People();
        $common = new CommonFunc();
        if ($common->existPeople($request['email'])) {
            messageBag()->add('rest_customer_invalid_id', __('Email already exists!'), ['status' => 400]);
        }

        $item = $this->prepareItemFDatabase($request);

        $id   = $people->insertPeople($item);

        $vendor       = (array) $people->getPeople($id);
        $vendor['id'] = $id;

        $this->addLog($vendor, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = $this->prepareItemForResponse($vendor, $request, $additional_fields);
        return response()->json($response);
        
    }

    /**
     * Update a vendor
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function updateVendor(Request $request)
    {
        $people = new People();
        $id = (int) $request['id'];

        $item = $people->getPeople($id);

        if (!$item) {
            messageBag()->add('rest_vendor_invalid_id', __('Invalid resource id.'), ['status' => 400]);
        }

        $old_data = (array) $item;

        $item = $this->prepareItemFDatabase($request);

        $id   = $people->insertPeople($item);

        $vendor       = (array) $people->getPeople($id);
        $vendor['id'] = $id;

        $this->addLog((array) $item, 'edit', $vendor);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $vendor   = $people->getPeople($id);
        $response = $this->prepareItemForResponse($vendor, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Delete a vendor
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function deleteVendor(Request $request)
    {

        $people = new People();
        $id = (int) $request['id'];

        $exist = $people->checkAssociatedTranasaction($id);

        if ($exist) {
             messageBag()->add('rest_customer_has_trans', __('Can not remove! Customer has transactions.'));

        }

        $data = [
            'id'   => $id,
            'hard' => true,
            'type' => 'vendor',
        ];

        $vendor = (array) $people->getPeople((int) $id);


        $people->deletePeople($data);

        $this->addLog($vendor, 'delete');

        return response()->json({'status': true});
    }

    /**
     * Delete Selected vendors
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function bulkDeleteVendors(Request $request)
    {

        $people = new People();
        $ids = (string) $request['ids'];

        $data = [
            'id'   => explode(',', $ids),
            'hard' => true,
            'type' => 'vendor',
        ];

        foreach ($data['id'] as $id) {
            $exist = $people->checkAssociatedTranasaction($id);

            if ($exist) {
                 messageBag()->add('rest_customer_has_trans', __('Can not remove! Customer has transactions.'));

               return false;
            }

            $vendors[] = (array) $people->getPeople((int) $id);
        }


        $people->deletePeople($data);

        foreach ($vendors as $vendor) {
            $this->addLog($vendor, 'delete');
        }

        return response()->json({'status': true});
    }

    /**
     * Get a collection of transactions
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_transactions(Request $request)
    {

        $people = new People();
        $id                = (int) $request['id'];
        $args['people_id'] = $id;

        $transactions = $people->getPeopleTransactions($args);

        return response()->json($transactions);

    }

    /**
     * Get transaction by date
     *
     * @param object $request
     *
     * @return array
     */
    public function filterTransactions(Request $request)
    {

        $people = new People();
        $id           = $request['id'];
        $start_date   = $request['start_date'];
        $end_date     = $request['end_date'];
        $args         = [
            'people_id'  => $id,
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ];
        $transactions = $people->getPeopleTransactions($args);

        return response()->json($transactions);
    }

    /**
     * Get products of a vendor
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendorProducts(Request $request)
    {

        $people = new People();
        $products = new Products();
        
        $args = [
            'number' => !empty($request['number']) ? (int) $request['number'] : 20,
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
            'vendor' => !empty($request['id']) ? $request['id'] : 0,
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $product_data = $products->getVendorProducts($args);
        $total_items  = $products->getVendorProducts(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($product_data as $item) {
            $data              = $this->prepareProductItemForResponse($item, $request, $additional_fields);
            $formatted_items[] = $this->prepareResponseForCollection($data);
        }

        return response()->json($formatted_items);
    }

    /**
     * Log for vendor related actions
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
                unset($data['photo_id'], $data['raw_data'], $data['type']);
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

        if (isset($request['first_name'])) {
            $prepared_item['first_name'] = $request['first_name'];
        }

        if (isset($request['last_name'])) {
            $prepared_item['last_name'] = $request['last_name'];
        }

        if (isset($request['email'])) {
            $prepared_item['email'] = $request['email'];
        }

        // optional arguments.
        if (isset($request['id'])) {
            $prepared_item['id'] = absint($request['id']);
        }

        if (isset($request['photo_id'])) {
            $prepared_item['photo_id'] = $request['photo_id'];
        }

        if (isset($request['company'])) {
            $prepared_item['company'] = $request['company'];
        }

        if (isset($request['phone'])) {
            $prepared_item['phone'] = $request['phone'];
        }

        if (isset($request['mobile'])) {
            $prepared_item['mobile'] = $request['mobile'];
        }

        if (isset($request['other'])) {
            $prepared_item['other'] = $request['other'];
        }

        if (isset($request['website'])) {
            $prepared_item['website'] = $request['website'];
        }

        if (isset($request['fax'])) {
            $prepared_item['fax'] = $request['fax'];
        }

        if (isset($request['notes'])) {
            $prepared_item['notes'] = $request['notes'];
        }

        if (isset($request['street_1'])) {
            $prepared_item['street_1'] = $request['street_1'];
        }

        if (isset($request['street_2'])) {
            $prepared_item['street_2'] = $request['street_2'];
        }

        if (isset($request['city'])) {
            $prepared_item['city'] = $request['city'];
        }

        if (!empty($request['state'])) {
            $prepared_item['state'] = $request['state']['id'];
        }

        if (isset($request['postal_code'])) {
            $prepared_item['postal_code'] = $request['postal_code'];
        }

        if (!empty($request['country'])) {
            $prepared_item['country'] = $request['country']['id'];
        }

        if (isset($request['currency'])) {
            $prepared_item['currency'] = $request['currency'];
        }

        $prepared_item['raw_data'] = json_decode($request->get_body(), true);
        $prepared_item['type']     = 'vendor';

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param array | object  $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'id'         => (int) $item->id,
            'first_name' => $item->first_name,
            'last_name'  => $item->last_name,
            'email'      => $item->email,
            'company'    => $item->company,
            'phone'      => $item->phone,
            'website'    => $item->website,
            'notes'      => $item->notes,
            'mobile'     => $item->mobile,
            'fax'        => $item->fax,
            'other'      => $item->other,
            'photo_id'   => !empty($item->photo_id) ? $item->photo_id : null,
            'photo'      => !empty($item->photo) ? $item->photo : null,
            'billing'    => [
                'first_name'  => $item->first_name,
                'last_name'   => $item->last_name,
                'street_1'    => $item->street_1,
                'street_2'    => $item->street_2,
                'city'        => $item->city,
                'state'       => $item->state,
                'postal_code' => $item->postal_code,
                'country'     => $item->country,
                'email'       => $item->email,
                'phone'       => $item->phone,
            ],
        ];

        $data = array_merge($data, $additional_fields);


        return $data;
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
    public function prepareProductItemForResponse($item, Request $request, $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'id'                => $item->id,
            'name'              => $item->name,
            'product_type_id'   => $item->product_type_id,
            'product_type_name' => $item->product_type_name,
            'category_id'       => $item->category_id,
            'tax_cat_id'        => $item->tax_cat_id,
            'vendor'            => $item->vendor,
            'cost_price'        => $item->cost_price,
            'sale_price'        => $item->sale_price,
            'vendor_name'       => $item->vendor_name,
            'cat_name'          => $item->cat_name,
            'tax_cat_name'      => $tax_cats->getTaxCategoryById($item->tax_cat_id),
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
            'title'      => 'vendor',
            'type'       => 'object',
            'properties' => [
                'id'         => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'first_name' => [
                    'description' => __('First name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'last_name'  => [
                    'description' => __('Last name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'email'      => [
                    'description' => __('The email address for the resource.'),
                    'type'        => 'string',
                    'format'      => 'email',
                    'context'     => ['view', 'edit'],
                    'required'    => true,
                ],
                'mobile'     => [
                    'description' => __('Mobile number for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'company'     => [
                    'description' => __('Company name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'phone'      => [
                    'description' => __('Phone number for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'website'    => [
                    'description' => __('Website link of the resource.'),
                    'type'        => 'string',
                    'format'      => 'uri',
                    'context'     => ['embed', 'view', 'edit'],
                ],
                'notes'      => [
                    'description' => __('Notes of the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'fax'      => [
                    'description' => __('Fax of the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'street_1'      => [
                    'description' => __('Stree 1 for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'street_2'      => [
                    'description' => __('Stree 2 for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'city'      => [
                    'description' => __('City for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'postal_code'      => [
                    'description' => __('Zip code for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'photo_id'      => [
                    'description' => __('Photo ID for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['view', 'edit'],
                ],
                'photo'      => [
                    'description' => __('Photo for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'country'    => [
                    'description' => __('List of countries data.', 'erp'),
                    'type'        => ['array', 'object'],
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('Country name for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'state'    => [
                    'description' => __('State for the resource.', 'erp'),
                    'type'        => ['array', 'object'],
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('State name for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
            ],
        ];

        return $schema;
    }
}
