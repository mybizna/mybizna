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
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompany()
    {
        $company = new Company();

        $logo_id = (int) $company->logo;

        if (!$logo_id) {
            $url = $company->placeholder_logo();
        } else {
            $image = wp_get_attachment_image_src($logo_id, 'medium');
            $url   = $image[0];
        }

        return response()->json(
            [
                'logo'    => $url,
                'name'    => $company->name,
                'address' => $company->address,
            ]
        );

        

        
    }

    /**
     * Get the schema, conforming to JSON Schema
     *
     * @return array
     */
    public function getItemSchema()
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
