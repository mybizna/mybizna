<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Account\Classes\Currencies;

use Illuminate\Support\Facades\DB;

class CurrenciesController extends Controller
{

    /**
     * Get a collection of currencies
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrencies(Request $request)
    {
        $currencies = new Currencies();

        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $items       = $currencies->getAllCurrencies();
        $total_items = $currencies->getAllCurrencies(true);

        $formatted_items = [];

        foreach ($items as $item) {
            $data              = $this->prepareItemForResponse($item, $request, $additional_fields);
            $formatted_items[] = $this->prepareResponseForCollection($data);
        }

        return response()->json($formatted_items);
    }

    /**
     * Prepare output for response
     *
     * @param object          $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, Request $request, $additional_fields = [])
    {
        $item = (object) $item;

        $data = [
            'id'   => $item->id,
            'name' => $item->name,
            'sign' => $item->sign,
        ];

        $data = array_merge($data, $additional_fields);


        return $data;
    }

    /**
     * Get currency's schema, conforming to JSON Schema
     *
     * @return array
     */
    public function getItemSchema()
    {
        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'journal',
            'type'       => 'object',
            'properties' => [
                'id'   => [
                    'description' => __('Unique identifier for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['embed', 'view', 'edit'],
                    'readonly'    => true,
                ],
                'name' => [
                    'description' => __('Name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'sign' => [
                    'description' => __('Sign for the resource.'),
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
