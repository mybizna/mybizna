<?php

namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;

class TaxRateNames
{

    /**
     * Get all tax rate names
     *
     * @return mixed
     */
    function getAllTaxRateNames($args = [])
    {


        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'DESC',
            'count'   => false,
            's'       => '',
        ];

        $args = wp_parse_args($args, $defaults);

        $tax_rates_count  = $tax_rates    =  false;

        if (false === $tax_rates) {
            $limit = '';

            if (-1 !== $args['number']) {
                $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
            }

            $sql  = 'SELECT';
            $sql .= $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';
            $sql .= "FROM {$wpdb->prefix}erp_acct_taxes ORDER BY {$args['orderby']} {$args['order']} {$limit}";

            if ($args['count']) {
                $tax_rates_count = $wpdb->get_var($sql);

                wp_cache_set($cache_key_count, $tax_rates_count, 'erp-accounting');
            } else {
                $tax_rates = $wpdb->get_results($sql, ARRAY_A);

                wp_cache_set($cache_key, $tax_rates, 'erp-accounting');
            }
        }

        if ($args['count']) {
            return $tax_rates_count;
        }

        return $tax_rates;
    }

    /**
     * Get an single tax rate name
     *
     * @param $tax_no
     *
     * @return mixed
     */
    function getTaxRateName($tax_no)
    {


        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}erp_acct_taxes WHERE id = %d LIMIT 1", $tax_no), ARRAY_A);

        return $row;
    }

    /**
     * Insert tax rate name
     *
     * @param $data
     *
     * @return int
     */
    function insertTaxRateName($data)
    {


        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        if (!empty($data['default'])) {
            $wpdb->query("UPDATE {$wpdb->prefix}erp_acct_taxes SET `default` = 0");
        }

        $tax_data = $taxratenames->getFormattedTaxRateNameData($data);

        DB::table('erp_acct_taxes')
            ->insert(
                [
                    'tax_rate_name' => $tax_data['tax_rate_name'],
                    'tax_number'    => $tax_data['tax_number'],
                    'default'       => $tax_data['default'],
                    'created_at'    => $tax_data['created_at'],
                    'created_by'    => $tax_data['created_by'],
                    'updated_at'    => $tax_data['updated_at'],
                    'updated_by'    => $tax_data['updated_by'],
                ]
            );


        return $wpdb->insert_id;
    }

    /**
     * Update tax rate name
     *
     * @param $data
     *
     * @return int
     */
    function updateTaxRateName($data, $id)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $taxratenames->getFormattedTaxRateNameData($data);

        if (!empty($tax_data['default'])) {
            $wpdb->query("UPDATE {$wpdb->prefix}erp_acct_taxes SET `default` = 0");
        }

        $wpdb->update(
            'erp_acct_taxes',
            [
                'tax_rate_name' => $tax_data['tax_rate_name'],
                'tax_number'    => $tax_data['tax_number'],
                'default'       => $tax_data['default'],
                'updated_at'    => $tax_data['updated_at'],
                'updated_by'    => $tax_data['updated_by'],
            ],
            [
                'id' => $id,
            ]
        );


        return $id;
    }

    /**
     * Delete an tax rate name
     *
     * @param $tax_no
     *
     * @return int
     */
    function deleteTaxRateName($id)
    {


        $wpdb->delete('erp_acct_taxes', ['id' => $id]);


        return $id;
    }

    /**
     * Get formatted tax rate name data
     *
     * @param $data
     *
     * @return mixed
     */
    function getFormattedTaxRateNameData($data)
    {
        $tax_data = [];

        $tax_data['tax_rate_name'] = isset($data['tax_rate_name']) ? $data['tax_rate_name'] : '';
        $tax_data['tax_number']    = isset($data['tax_number']) ? $data['tax_number'] : '';
        $tax_data['default']       = isset($data['default']) ? $data['default'] : '';
        $tax_data['created_at']    = date('Y-m-d');
        $tax_data['created_by']    = isset($data['created_by']) ? $data['created_by'] : '';
        $tax_data['updated_at']    = isset($data['updated_at']) ? $data['updated_at'] : null;
        $tax_data['updated_by']    = isset($data['updated_by']) ? $data['updated_by'] : '';

        return $tax_data;
    }
}
