<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    /**
     * Get a company logo
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_company($request)
    {
        $company = new \WeDevs\ERP\Company();

        $logo_id = (int) $company->logo;

        if (!$logo_id) {
            $url = $company->placeholder_logo();
        } else {
            $image = wp_get_attachment_image_src($logo_id, 'medium');
            $url   = $image[0];
        }

        $response = rest_ensure_response(
            [
                'logo'    => $url,
                'name'    => $company->name,
                'address' => $company->address,
            ]
        );

        $response->set_status(200);

        return $response;
    }

    /**
     * Get the schema, conforming to JSON Schema
     *
     * @return array
     */
    public function get_item_schema()
    {
        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'company',
            'type'       => 'object',
            'properties' => [
                'logo'         => [
                    'description' => __('Company logo for the resource.'),
                    'type'        => 'string',
                    'context'     => ['embed', 'view'],
                ],
                'name' => [
                    'description' => __('Company name for the resource.'),
                    'type'        => 'string',
                    'context'     => ['view'],
                ],
                'address'    => [
                    'description' => __('Address data.', 'erp'),
                    'type'        => 'object',
                    'context'     => ['view'],
                    'properties'  => [
                        'address_1'   => [
                            'description' => __('Company address 1 for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view'],
                        ],
                        'address_2' => [
                            'description' => __('Company address 2 for the resource.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view'],
                        ],
                    ],
                ],
            ],
        ];

        return $schema;
    }
}
