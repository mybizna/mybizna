<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\People;

use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\OpeningBalance;

class PeopleController extends Controller
{

    /**
     * Get all people
     *
     * @return array
     */
    public function getAllPeople(Request $request)
    {
        $people = new People();

        $input = $request->all();
        $args = [
            'number' => !empty($input['per_page']) ? $input['per_page'] : 20,
            'offset' => ($input['per_page'] * ($input['page'] - 1)),
            'type'   => !empty($input['type']) ? $input['type'] : ['customer', 'employee', 'vendor'],
            's'      => !empty($input['search']) ? $input['search'] : '',
        ];

        $items       = $people->getPeoples($args);
        $total_items = $people->getPeoples(
            [
                'type'  => $args['type'],
                'count' => true,
            ]
        );
        $total_items = is_array($total_items) ? count($total_items) : $total_items;

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        foreach ($items as $item) {
            if (isset($input['include'])) {
                $include_params = explode(',', str_replace(' ', '', $input['include']));

                if (in_array('owner', $include_params, true)) {
                    $customer_owner_id = ($item->user_id) ? get_user_meta($item->user_id, 'contact_owner', true) : $people->peopleGetMeta($item->id, 'contact_owner', true);

                    $item->owner       = $this->get_user($customer_owner_id);
                    $additional_fields = ['owner' => $item->owner];
                }
            }

            $formatted_items[]              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Return formatted data of a people
     *
     * @param $id
     *
     * @return string
     */
    public function getPeople(Request $request)
    {

        $people = new People();
        $common = new CommonFunc();

        $input = $request->all();
        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_people_invalid_id', __('Invalid resource id.'));
            return;
        }

        $people = $people->getPeople($id);

        $people->{'state'}   = $common->getStateName($people->country, $people->state);
        $people->{'country'} = $common->getCountryName($people->country);

        return $people;
    }

    /**
     * Return formatted address of a people
     *
     * @param $id
     *
     * @return string
     */
    public function getPeopleAddress(Request $request)
    {

        $people = new People();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_people_invalid_id', __('Invalid resource id.'));
            return;
        }

        $row = DB::select("SELECT street_1, street_2, city, state, postal_code, country FROM partner WHERE id = %d", [$id]);
        $row = (!empty($row)) ? $row[0] : null;

        return response()->json($people->formatPeopleAddress($row));
    }

    /**
     * Get opening balance of a people in a date range
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getOpeningBalance(Request $request)
    {
        $opening_balance = new OpeningBalance();

        $input = $request->all();

        $id                = (int) $input['id'];
        $args['people_id'] = $id;

        $transactions = $opening_balance->getPeopleOpeningBalance($args);

        return response()->json($transactions);
    }

    /**
     * Check people email existance
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function checkPeopleEmail(Request $request)
    {
        $common = new CommonFunc();

        $input = $request->all();
        $res      = $common->existPeople($input['email'], ['customer', 'vendor', 'contact', 'company']);

        return response()->json($res);
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

        if (isset($input['state'])) {
            $prepared_item['state'] = $input['state']['id'];
        }

        if (isset($input['postal_code'])) {
            $prepared_item['postal_code'] = $input['postal_code'];
        }

        if (isset($input['country'])) {
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

        $prepared_item['type'] = 'customer';

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
        $item = (object) $item;

        $data = [
            'id'         => (int) $item->id,
            'first_name' => $item->first_name,
            'last_name'  => $item->last_name,
            'name'       => $item->first_name . ' ' . $item->last_name,
            'email'      => $item->email,
            'phone'      => $item->phone,
            'mobile'     => $item->mobile,
            'fax'        => $item->fax,
            'website'    => $item->website,
            'notes'      => $item->notes,
            'other'      => $item->other,
            'company'    => $item->company,
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
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'last_name'  => [
                    'description' => __('Last name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'email'      => [
                    'description' => __('The email address for the resource.'),
                    'type'        => 'string',
                    'format'      => 'email',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'phone'      => [
                    'description' => __('Phone for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'other'      => [
                    'description' => __('Other for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'website'    => [
                    'description' => __('Website of the resource.'),
                    'type'        => 'string',
                    'format'      => 'uri',
                    'context'     => ['embed', 'view', 'edit'],
                ],
                'notes'      => [
                    'description' => __('Notes of the resource.'),
                    'type'        => 'string',
                    'context'     => ['embed', 'view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'billing'    => [
                    'description' => __('List of billing address data.'),
                    'type'        => 'object',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'first_name'  => [
                            'description' => __('First name.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'last_name'   => [
                            'description' => __('Last name.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'street_1'    => [
                            'description' => __('Address line 1'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'street_2'    => [
                            'description' => __('Address line 2'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'city'        => [
                            'description' => __('City name.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'state'       => [
                            'description' => __('ISO code or name of the state, province or district.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'postal_code' => [
                            'description' => __('Postal code.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'country'     => [
                            'description' => __('ISO code of the country.'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                        ],
                        'email'       => [
                            'description' => __('The email address for the resource.'),
                            'type'        => 'string',
                            'format'      => 'email',
                            'context'     => ['edit'],
                        ],
                        'phone'       => [
                            'description' => __('Phone for the resource.'),
                            'type'        => 'string',
                            'context'     => ['edit'],
                        ],
                    ],
                ],
            ],
        ];

        return $schema;
    }
}
