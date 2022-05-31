<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\People;
use Modules\Account\Classes\Countries;

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
    public function getCustomers(Request $request)
    {
        $people = new People();

        $input = $request->all();
        
        $args = [
            'number' => $input['per_page'],
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
            'type'   => 'customer',
            's'      => !empty($input['search']) ? $input['search'] : '',
        ];

        $items       = $people->getAccountingPeople($args);
        $total_items = $people->getAccountingPeople(
            ['type' => 'customer', 's' => $args['s'], 'count' => true]
        );
        $total_items = is_array($total_items) ? count($total_items) : $total_items;

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        foreach ($items as $item) {
            $photo_id = $people->peopleGetMeta($item->id, 'photo_id', true);

            $item->{'photo_id'} = $photo_id;
            $item->{'photo'}    = wp_get_attachment_image_src($photo_id);

            if (isset($input['include'])) {
                $include_params = explode(',', str_replace(' ', '', $input['include']));

                if (in_array('owner', $include_params, true)) {
                    $customer_owner_id = ($item->user_id) ? get_user_meta($item->user_id, 'contact_owner', true) : $people->peopleGetMeta($item->id, 'contact_owner', true);

                    $item->owner       = $this->get_user($customer_owner_id);
                    $additional_fields = ['owner' => $item->owner];
                }
            }

            $formatted_items[] = $this->prepareItemForResponse($item, $request, $additional_fields);
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
    public function getCustomer(Request $request)
    {
        $people = new People();

        $input = $request->all();

        $id   = (int) $input['id'];
        $item = $people->getPeople($id);
        $item = (array) $item;

        if (empty($id) || empty($item['id'])) {
            config('kernel.messageBag')->add('rest_customer_invalid_id', __('Invalid resource id.'));
            return;
        }

        $photo_id = $people->peopleGetMeta($id, 'photo_id', true);

        $item['photo_id'] = $photo_id;
        $item['photo']    = wp_get_attachment_image_src($photo_id);

        $additional_fields = [];

        if (isset($input['include'])) {
            $include_params = explode(',', str_replace(' ', '', $input['include']));

            if (in_array('owner', $include_params, true)) {
                $customer_owner_id = ($item->user_id) ? get_user_meta($item->user_id, 'contact_owner', true) : $people->peopleGetMeta($item->id, 'contact_owner', true);

                $item->owner       = $this->get_user($customer_owner_id);
                $additional_fields = ['owner' => $item->owner];
            }
        }

        $additional_fields['namespace'] = __NAMESPACE__;

        $item                           = $this->prepareItemForResponse($item, $request, $additional_fields);

        return response()->json($item);
    }

    /**
     * Create a customer
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function createCustomer(Request $request)
    {
        $people = new People();
        $common = new CommonFunc();
        $input = $request->all();
        if ($common->existPeople($input['email'])) {
            config('kernel.messageBag')->add('rest_customer_invalid_id', __('Email already exists!'));
            return;
        }

        $item = $this->prepareItemFDatabase($request);
        $id   = $people->insertPeople($item);

        $customer       = (array) $people->getPeople($id);
        $customer['id'] = $id;

        $this->addLog($customer, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $response = $this->prepareItemForResponse($customer, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Update a customer
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function updateCustomer(Request $request)
    {
        $people = new People();
        $input = $request->all();
        $id = (int) $input['id'];

        $item = $people->getPeople($id);

        if (!$item) {
            config('kernel.messageBag')->add('rest_customer_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item = $this->prepareItemFDatabase($request);

        $id = $people->insertPeople($item);

        $customer       = (array) $people->getPeople($id);
        $customer['id'] = $id;

        $this->addLog((array) $item, 'edit', $customer);

        $additional_fields['namespace'] = __NAMESPACE__;

        $response = $this->prepareItemForResponse($customer, $request, $additional_fields);
        return response()->json($response);
    }

    /**
     * Delete a customer
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function deleteCustomer(Request $request)
    {
        $people = new People();
        $input = $request->all();
        $id = (int) $input['id'];

        $exist = $people->checkAssociatedTranasaction($id);

        if ($exist) {
            config('kernel.messageBag')->add('rest_customer_has_trans', __('Can not remove! Customer has transactions.'));

            return false;
        }

        $data = [
            'id'   => $id,
            'hard' => true,
            'type' => 'customer',
        ];

        $customer = (array) $people->getPeople($id);


        $people->deletePeople($data);

        $this->addLog($customer, 'delete');

        return response()->json(['status' => true]);;
    }

    /**
     * Bulk Delete customers
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Request
     */
    public function bulkDeleteCustomers(Request $request)
    {
        $people = new People();
        $input = $request->all();
        $ids = (string) $input['ids'];

        $data = [
            'id'   => explode(',', $ids),
            'hard' => true,
            'type' => 'customer',
        ];

        foreach ($data['id'] as $id) {
            $exist = $people->checkAssociatedTranasaction($id);

            if ($exist) {
                config('kernel.messageBag')->add('rest_customer_has_trans', __('Can not remove! Customer has transactions.'));

                return false;
            }

            $customers[] = (array) $people->getPeople((int) $id);
        }


        $people->deletePeople($data);

        foreach ($customers as $customer) {
            $this->addLog($customer, 'delete');
        }

        return response()->json(['status' => true]);;
    }

    /**
     * Get a collection of transactions
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTransactions(Request $request)
    {
        $input = $request->all();

        $id = (int) $input['id'];

        $args['people_id'] = $id;

        $transactions = $this->getPeopleTransactions($args);

        return response()->json($transactions);
    }

    /**
     * Get countries
     *
     * @return object
     */
    public function getCountries(Request $request)
    {
        $countries  = new Countries();
        
        $c        = $countries->get_countries(); 
        $state    = $countries->get_states();
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
    public function filterTransactions($request)
    {
        $people = new People();
        $input = $request->all();
        $id           = $input['id'];
        $start_date   = $input['start_date'];
        $end_date     = $input['end_date'];
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

        $input = $request->all();

        // required arguments.
        if (isset($input['first_name'])) {
            $prepared_item['first_name'] = $input['first_name'];
        }

        if (isset($input['last_name'])) {
            $prepared_item['last_name'] = $input['last_name'];
        }

        if (isset($input['email'])) {
            $prepared_item['email'] = $input['email'];
        }

        // optional arguments.
        if (isset($input['id'])) {
            $prepared_item['id'] = absint($input['id']);
        }

        if (isset($input['photo_id'])) {
            $prepared_item['photo_id'] = $input['photo_id'];
        }

        if (isset($input['phone'])) {
            $prepared_item['phone'] = $input['phone'];
        }

        if (isset($input['website'])) {
            $prepared_item['website'] = $input['website'];
        }

        if (isset($input['other'])) {
            $prepared_item['other'] = $input['other'];
        }

        if (isset($input['notes'])) {
            $prepared_item['notes'] = $input['notes'];
        }

        if (isset($input['street_1'])) {
            $prepared_item['street_1'] = $input['street_1'];
        }

        if (isset($input['street_2'])) {
            $prepared_item['street_2'] = $input['street_2'];
        }

        if (isset($input['city'])) {
            $prepared_item['city'] = $input['city'];
        }

        if (!empty($input['state'])) {
            $prepared_item['state'] = $input['state']['id'];
        }

        if (isset($input['postal_code'])) {
            $prepared_item['postal_code'] = $input['postal_code'];
        }

        if (!empty($input['country'])) {
            $prepared_item['country'] = $input['country']['id'];
        }

        if (isset($input['company'])) {
            $prepared_item['company'] = $input['company'];
        }

        if (isset($input['mobile'])) {
            $prepared_item['mobile'] = $input['mobile'];
        }

        if ($input['fax']) {
            $prepared_item['fax'] = $input['fax'];
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
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
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
    public function getItemSchema()
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
                    'description' => __('List of countries data.'),
                    'type'        => ['array', 'object'],
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('Country name for the resource.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                    ],
                ],
                'state'    => [
                    'description' => __('State for the resource.'),
                    'type'        => ['array', 'object'],
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'id'   => [
                            'description' => __('Unique identifier for the resource.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'name' => [
                            'description' => __('State name for the resource.'),
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
