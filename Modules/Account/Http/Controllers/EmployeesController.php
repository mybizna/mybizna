<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Account\Classes\People;
use Modules\Account\Classes\Company;
use Modules\Account\Classes\Hr;

use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    /**
     * Get a collection of employees
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return mixed|object|\Illuminate\Http\Response
     */
    public function getEmployees(Request $request)
    {
        $hr = new Hr();
        $input = $request->all();
        $args = [
            'number'      => $input['per_page'],
            'offset'      => ($input['per_page'] * ($input['page'] - 1)),
            'status'      => ($input['status']) ? $input['status'] : 'active',
            'department'  => ($input['department']) ? $input['department'] : '-1',
            'designation' => ($input['designation']) ? $input['designation'] : '-1',
            'location'    => ($input['location']) ? $input['location'] : '-1',
            's'           => ($input['s']) ? $input['s'] : '',
        ];

        $items = $hr->hrGetEmployees($args);

        $args['count'] = true;
        $total_items   = $hr->hrGetEmployees($args);
        $total_items   = is_array($total_items) ? count($total_items) : $total_items;

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = __NAMESPACE__;

        foreach ($items as $item) {
            $additional_fields['id'] = $item->user_id;

            $formatted_items[]              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($formatted_items);
    }

    /**
     * Get a specific employee
     *
     * @param \\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployee(Request $request)
    {

        $people = new People();
        $input = $request->all();
        $people_id = (int) $input['id'];
        $user_id   = $people->getUserIdByPeopleId($people_id);

        $employee = DB::table('hrm_employee')->where('user_id', $user_id)->first();
        $item     = (array) $people->getPeople($people_id);

        if (empty($item['id'])) {
            config('kernel.messageBag')->add('rest_employee_invalid_id', __('Invalid resource id.'));
            return;
        }

        $item['designation']  = $employee->get_designation('view');
        $item['department']   = $employee->get_department('view');
        $item['reporting_to'] = $employee->get_reporting_to('view');
        $item['avatar']       = $employee->get_avatar();

        $additional_fields['namespace'] = __NAMESPACE__;

        $item     = $this->prepare_employee_item_for_response($item, $request, $additional_fields);
        return response()->json($item);
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
        $people = new People();
        $input = $request->all();
        $args['people_id'] = (int) $input['id'];

        $transactions = $people->getPeopleTransactions($args);

        return response()->json($transactions);
    }

    /**
     * Prepare a single user output for response
     *
     * @param array|object          $item
     * @param \\Illuminate\Http\Request|null $request
     * @param array                 $additional_fields
     *
     * @return mixed|object|\Illuminate\Http\Response
     */
    public function prepareItemForResponse($item, Request $request = null, $additional_fields = [])
    {
        $item     = $item->data;
        $employee = DB::table('hrm_employee')->where('user_id', $item['user_id'])->first();

        $data                = array_merge($item['work'], $item['personal'], $additional_fields);
        $data['user_id']     = $item['user_id'];
        $data['email']       = $item['user_email'];
        $data['people_id']   = $this->getPeopleIdByUserId($item['user_id']);
        $data['department']  = $employee->get_department('view');
        $data['designation'] = $employee->get_designation('view');


        return $data;
    }

    /**
     * Prepare a single employee output for response
     *
     * @param array|object          $item
     * @param \\Illuminate\Http\Request|null $request
     * @param array                 $additional_fields
     *
     * @return mixed|object|\Illuminate\Http\Response
     */
    public function prepareEmployeeItemForResponse($item, Request $request = null, $additional_fields = [])
    {
        // Wrap the data in a response object
        return response()->json($item);
    }

    /**
     * Prepare a single item for create or update
     *
     * @param \\Illuminate\Http\Request $request request object
     *
     * @return array $prepared_item
     */
    public function prepareItemFDatabase(Request $request)
    {
        $prepared_item = [];
        $company       = new Company();

        $input = $request->all();

        if (isset($input['id'])) {
            $prepared_item['id'] = $input['id'];
        }

        // required arguments.
        if (isset($input['first_name'])) {
            $prepared_item['personal']['first_name'] = $input['first_name'];
        }

        if (isset($input['last_name'])) {
            $prepared_item['personal']['last_name'] = $input['last_name'];
        }

        if (isset($input['employee_id'])) {
            $prepared_item['work']['employee_id'] = $input['employee_id'];
        }

        if (isset($input['email'])) {
            $prepared_item['user_email'] = $input['email'];
        }

        // optional arguments.
        if (isset($input['company'])) {
            $prepared_item['company'] = isset($input['company']) ? $input['company'] : $company->name;
        }

        if (isset($input['user_id'])) {
            $prepared_item['user_id'] = absint($input['user_id']);
        }

        if (isset($input['middle_name'])) {
            $prepared_item['personal']['middle_name'] = $input['middle_name'];
        }

        if (isset($input['designation'])) {
            $prepared_item['work']['designation'] = $input['designation'];
        }

        if (isset($input['department'])) {
            $prepared_item['work']['department'] = $input['department'];
        }

        if (isset($input['reporting_to'])) {
            $prepared_item['work']['reporting_to'] = $input['reporting_to'];
        }

        if (isset($input['location'])) {
            $prepared_item['work']['location'] = $input['location'];
        }

        if (isset($input['hiring_source'])) {
            $prepared_item['work']['hiring_source'] = $input['hiring_source'];
        }

        if (isset($input['hiring_date'])) {
            $prepared_item['work']['hiring_date'] = $input['hiring_date'];
        }

        if (isset($input['date_of_birth'])) {
            $prepared_item['work']['date_of_birth'] = $input['date_of_birth'];
        }

        if (isset($input['pay_rate'])) {
            $prepared_item['work']['pay_rate'] = $input['pay_rate'];
        }

        if (isset($input['pay_type'])) {
            $prepared_item['work']['pay_type'] = $input['pay_type'];
        }

        if (isset($input['type'])) {
            $prepared_item['work']['type'] = $input['type'];
        }

        if (isset($input['status'])) {
            $prepared_item['work']['status'] = $input['status'];
        }

        if (isset($input['other_email'])) {
            $prepared_item['personal']['other_email'] = $input['other_email'];
        }

        if (isset($input['phone'])) {
            $prepared_item['personal']['phone'] = $input['phone'];
        }

        if (isset($input['work_phone'])) {
            $prepared_item['personal']['work_phone'] = $input['work_phone'];
        }

        if (isset($input['mobile'])) {
            $prepared_item['personal']['mobile'] = $input['mobile'];
        }

        if (isset($input['address'])) {
            $prepared_item['personal']['address'] = $input['address'];
        }

        if (isset($input['gender'])) {
            $prepared_item['personal']['gender'] = $input['gender'];
        }

        if (isset($input['marital_status'])) {
            $prepared_item['personal']['marital_status'] = $input['marital_status'];
        }

        if (isset($input['nationality'])) {
            $prepared_item['personal']['nationality'] = $input['nationality'];
        }

        if (isset($input['driving_license'])) {
            $prepared_item['personal']['driving_license'] = $input['driving_license'];
        }

        if (isset($input['hobbies'])) {
            $prepared_item['personal']['hobbies'] = $input['hobbies'];
        }

        if (isset($input['user_url'])) {
            $prepared_item['personal']['user_url'] = $input['user_url'];
        }

        if (isset($input['description'])) {
            $prepared_item['personal']['description'] = $input['description'];
        }

        if (isset($input['street_1'])) {
            $prepared_item['personal']['street_1'] = $input['street_1'];
        }

        if (isset($input['street_2'])) {
            $prepared_item['personal']['street_2'] = $input['street_2'];
        }

        if (isset($input['city'])) {
            $prepared_item['personal']['city'] = $input['city'];
        }

        if (isset($input['country'])) {
            $prepared_item['personal']['country'] = $input['country'];
        }

        if (isset($input['state'])) {
            $prepared_item['personal']['state'] = $input['state'];
        }

        if (isset($input['postal_code'])) {
            $prepared_item['personal']['postal_code'] = $input['postal_code'];
        }

        if (isset($input['photo_id'])) {
            $prepared_item['personal']['photo_id'] = $input['photo_id'];
        }

        return $prepared_item;
    }

    /**
     * Get the query params for collections.
     *
     * @return array
     */
    public function getCollectionParams()
    {
        return [
            'context'  => $this->get_context_param(),
            'page'     => [
                'description'       => __('Current page of the collection.'),
                'type'              => 'integer',
                'default'           => 1,
                'sanitize_callback' => 'absint',
                'validate_callback' => 'rest_validate_request_arg',
                'minimum'           => 1,
            ],
            'per_page' => [
                'description'       => __('Maximum number of items to be returned in result set.'),
                'type'              => 'integer',
                'default'           => 20,
                'minimum'           => 1,
                'maximum'           => 100,
                'sanitize_callback' => 'absint',
                'validate_callback' => 'rest_validate_request_arg',
            ],
            'search'   => [
                'description'       => __('Limit results to those matching a string.'),
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => 'rest_validate_request_arg',
            ],
        ];
    }
}
