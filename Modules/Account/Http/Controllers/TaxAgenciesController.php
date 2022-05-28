<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\TaxAgencies;

use Illuminate\Support\Facades\DB;

class TaxAgenciesController extends Controller
{

    /**
     * Get a collection of taxes
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxAgencies(Request $request)
    {
        $tax_agencies = new TaxAgencies();

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

        $tax_data    = $tax_agencies->getAllTaxAgencies($args);
        $total_items = $tax_agencies->getAllTaxAgencies(
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

            $data              = $this->prepareItemForResponse($item, $request, $additional_fields);
        }

        return response()->json($data);
    }

    /**
     * Get an tax
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxAgency(Request $request)
    {

        $tax_agencies = new TaxAgencies();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_tax_invalid_id', __('Invalid resource id.'));
            return response()->json(['status' => true]);
        }

        $item = $tax_agencies->getTaxAgency($id);

        $additional_fields['namespace'] = __NAMESPACE__;

        $item     = $this->prepareItemForResponse($item, $request, $additional_fields);

        return response()->json($item);
    }

    /**
     * Create an tax
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function createTaxAgency(Request $request)
    {
        $tax_agencies = new TaxAgencies();

        $tax_data = $this->prepare_item_for_database($request);

        $tax_id = $tax_agencies->insertTaxAgency($tax_data);

        $tax_data['id'] = $tax_id;

        $this->add_log($tax_data, 'add');

        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareItemForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Update an tax
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTaxAgency(Request $request)
    {

        $tax_agencies = new TaxAgencies();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_tax_invalid_id', __('Invalid resource id.'));
            return response()->json(['status' => true]);
        }

        $tax_data = $this->prepare_item_for_database($request);
        $old_data = $tax_agencies->getTaxAgency($id);
        $tax_id   = $tax_agencies->updateTaxAgency($tax_data, $id);

        $this->add_log($tax_data, 'edit', $old_data);

        $tax_data['id']                 = $tax_id;
        $additional_fields['namespace'] = __NAMESPACE__;

        $tax_data = $this->prepareItemForResponse($tax_data, $request, $additional_fields);

        return response()->json($tax_data);
    }

    /**
     * Get agency due amount by id
     *
     * @param array $request
     *
     * @return void
     */
    public function getAgencyDue(Request $request)
    {

        $tax_agencies = new TaxAgencies();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_tax_invalid_id', __('Invalid resource id.'));
            return response()->json(['status' => true]);
        }

        $item = $tax_agencies->getAgencyDue($id);

        return response()->json($item);
    }

    /**
     * Delete an tax
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTaxAgency(Request $request)
    {
        $tax_agencies = new TaxAgencies();

        $input = $request->all();

        $id = (int) $input['id'];

        if (empty($id)) {
            config('kernel.messageBag')->add('rest_tax_invalid_id', __('Invalid resource id.'));
            return response()->json(['status' => true]);
        }

        $item = $tax_agencies->getTaxAgency($id);

        $tax_agencies->deleteTaxAgency($id);

        return response()->json($item);
    }

    /**
     * Bulk delete action
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {

        $tax_agencies = new TaxAgencies();

        $input = $request->all();

        $ids = $input['ids'];
        $ids = explode(',', $ids);

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $item = $tax_agencies->getTaxAgency($id);

            $tax_agencies->deleteTaxAgency($id);

            $this->add_log($item, 'delete');
        }

        return response()->json($item);
    }

    /**
     * Log for tax agency related actions
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

        config('kernel.messageBag')->add('Accounting', __('Tax'));
    }

    /**
     * Prepare a single item for create or update
     *
     * @param \Illuminate\Http\Request $request request object
     *
     * @return array $prepared_item
     */
    protected function prepareItemForDatabase(Request $request)
    {
        $prepared_item = [];

        $input = $request->all();

        if (isset($input['agency_name'])) {
            $prepared_item['agency_name'] = $input['agency_name'];
        }

        return response()->json($prepared_item);
    }

    /**
     * Prepare a single user output for response
     *
     * @param array           $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return WP_REST_Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'id'   => (int) $item->id,
            'name' => !empty($item->name) ? $item->name : $item->agency_name,
        ];

        $data = array_merge($data, $additional_fields);

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
            'title'      => 'tax_agency',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'agency_name' => [
                    'description' => __('Tax agency name for the resource.'),
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
