<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\People;

use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{


    /**
     * Get a collection of customers
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_customers(Request $request)
    {
        $people = new People();
        $args = [
            'number' => $request['per_page'],
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
            'type'   => 'customer',
            's'      => !empty($request['search']) ? $request['search'] : '',
        ];

        $items       = $people->getAccountingPeople($args);
        $total_items = $people->getAccountingPeople(
            ['type' => 'customer', 's' => $args['s'], 'count' => true]
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
                    $customer_owner_id = ($item->user_id) ? get_user_meta($item->user_id, 'contact_owner', true) : $people->peopleGetMeta($item->id, 'contact_owner', true);

                    $item->owner       = $this->get_user($customer_owner_id);
                    $additional_fields = ['owner' => $item->owner];
                }
            }

            $data              = $this->prepare_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        return response()->json($formatted_items);

        

        
    }

    /**
     * Get a specific customer
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function get_customer(Request $request)
    {
        $people = new People();

        $id   = (int) $request['id'];
        $item = $people->getPeople($id);
        $item = (array) $item;

        if (empty($id) || empty($item['id'])) {
            messageBag()->add('rest_customer_invalid_id', __('Invalid resource id.'), ['status' => 404]);
            return ;
        }

        $photo_id = $people->peopleGetMeta($id, 'photo_id', true);

        $item['photo_id'] = $photo_id;
        $item['photo']    = wp_get_attachment_thumb_url($photo_id);

        $additional_fields = [];

        if (isset($request['include'])) {
            $include_params = explode(',', str_replace(' ', '', $request['include']));

            if (in_array('owner', $include_params, true)) {
                $customer_owner_id = ($item->user_id) ? get_user_meta($item->user_id, 'contact_owner', true) : $people->peopleGetMeta($item->id, 'contact_owner', true);

                $item->owner       = $this->get_user($customer_owner_id);
                $additional_fields = ['owner' => $item->owner];
            }
        }

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;
        $item                           = $this->prepare_item_for_response($item, $request, $additional_fields);
        
        return response()->json($item);

        

    }

    /**
     * Create a customer
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function create_customer(Request $request)
    {
        $people = new People();
        $common = new CommonFunc();
        if ($common->existPeople($request['email'])) {
            messageBag()->add('rest_customer_invalid_id', __('Email already exists!'), ['status' => 400]);
            return ;
        }

        $item = $this->prepare_item_for_database($request);
        $id   = $people->insertPeople($item);

        $customer       = (array) $people->getPeople($id);
        $customer['id'] = $id;

        $this->add_log($customer, 'add');

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = $this->prepare_item_for_response($customer, $request, $additional_fields);
        return response()->json($response);

        
    }

    /**
     * Update a customer
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function update_customer(Request $request)
    {
        $people = new People();
        $id = (int) $request['id'];

        $item = $people->getPeople($id);

        if (!$item) {
            messageBag()->add('rest_customer_invalid_id', __('Invalid resource id.'), ['status' => 400]);
            return ;
        }

        $item = $this->prepare_item_for_database($request);

        $id = $people->insertPeople($item);

        $customer       = (array) $people->getPeople($id);
        $customer['id'] = $id;

        $this->add_log((array) $item, 'edit', $customer);

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = $this->prepare_item_for_response($customer, $request, $additional_fields);
        return response()->json($response);
        

        
    }

    /**
     * Delete a customer
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function delete_customer(Request $request)
    {
        $people = new People();
        $id = (int) $request['id'];

        $exist = $people->checkAssociatedTranasaction($id);

        if ($exist) {
             messageBag()->add('rest_customer_has_trans', __('Can not remove! Customer has transactions.'));

            return false;
        }

        $data = [
            'id'   => $id,
            'hard' => true,
            'type' => 'customer',
        ];

        $customer = (array) $people->getPeople($id);


        $people->deletePeople($data);

        $this->add_log($customer, 'delete');

        return new WP_REST_Response(true, 204);
    }

    /**
     * Bulk Delete customers
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return messageBag()->add|\Illuminate\Http\Request
     */
    public function bulk_delete_customers(Request $request)
    {
        $people = new People();
        $ids = (string) $request['ids'];

        $data = [
            'id'   => explode(',', $ids),
            'hard' => true,
            'type' => 'customer',
        ];

        foreach ($data['id'] as $id) {
            $exist = $people->checkAssociatedTranasaction($id);

            if ($exist) {
                 messageBag()->add('rest_customer_has_trans', __('Can not remove! Customer has transactions.'));

                return false;
            }

            $customers[] = (array) $people->getPeople((int) $id);
        }


        $people->deletePeople($data);

        foreach ($customers as $customer) {
            $this->add_log($customer, 'delete');
        }

        return new WP_REST_Response(true, 204);
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
        $id = (int) $request['id'];

        $args['people_id'] = $id;

        $transactions = $this->getPeopleTransactions($args);

        return new WP_REST_Response($transactions, 200);
    }

    /**
     * Get countries
     *
     * @return object
     */
    public function get_countries(Request $request)
    {
        $country  = \WeDevs\ERP\Countries::instance();
        $c        = $country->get_countries();
        $state    = $country->get_states();
        $response = [
            'country' => $c,
            'state'   => $state,
        ];
        return response()->json($response);

        
    }

    /**
     * Get transaction by date
     *
     * @param object $request
     *
     * @return array
     */
    public function filter_transactions($request)
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
     * Log for customer related actions
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
    protected function prepare_item_for_database(Request $request)
    {
        $prepared_item = [];
        // required arguments.
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

        if (isset($request['phone'])) {
            $prepared_item['phone'] = $request['phone'];
        }

        if (isset($request['website'])) {
            $prepared_item['website'] = $request['website'];
        }

        if (isset($request['other'])) {
            $prepared_item['other'] = $request['other'];
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

        if (isset($request['company'])) {
            $prepared_item['company'] = $request['company'];
        }

        if (isset($request['mobile'])) {
            $prepared_item['mobile'] = $request['mobile'];
        }

        if ($request['fax']) {
            $prepared_item['fax'] = $request['fax'];
        }

        $prepared_item['raw_data'] = json_decode($request->get_body(), true);
        $prepared_item['type']     = 'customer';

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
    public function prepare_item_for_response($item, Request $request, $additional_fields = [])
    {
        $common = new CommonFunc();
        $item = (object) $item;

        $data = [
            'id'         => (int) $item->id,
            'first_name' => $item->first_name,
            'last_name'  => $item->last_name,
            'email'      => $item->email,
            'phone'      => $item->phone,
            'mobile'     => $item->mobile,
            'fax'        => $item->fax,
            'website'    => $item->website,
            'notes'      => $item->notes,
            'other'      => $item->other,
            'company'    => $item->company,
            'photo_id'   => !empty($item->photo_id) ? $item->photo_id : null,
            'photo'      => !empty($item->photo) ? $item->photo : null,
            'billing'    => [
                'first_name'   => $item->first_name,
                'last_name'    => $item->last_name,
                'street_1'     => $item->street_1,
                'street_2'     => $item->street_2,
                'city'         => $item->city,
                'state'        => $item->state,
                'state_name'   => !empty($item->state) && !empty($item->country) ? $common->getStateName($item->country, $item->state) : '',
                'postal_code'  => $item->postal_code,
                'country'      => $item->country,
                'country_name' => !empty($item->country) ? $common->getCountryName($item->country) : '',
                'email'        => $item->email,
                'phone'        => $item->phone,
            ],
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
            'title'      => 'customer',
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
                            'type'        => 'integer',
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
                            'type'        => 'string',
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
