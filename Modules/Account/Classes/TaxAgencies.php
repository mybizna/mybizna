<?php

namespace Modules\Account\Classes;

class Bank
{
    /**
     * Get all tax agencies
     *
     * @return mixed
     */
    function getAllTaxAgencies($args = [])
    {
        global $wpdb;

        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'ASC',
            'count'   => false,
            's'       => '',
        ];

        $args = wp_parse_args($args, $defaults);

        $last_changed = erp_cache_get_last_changed('accounting', 'tax_agencies', 'erp-accounting');
        $cache_key    = 'erp-get-tax-agencies-' . md5(serialize($args)) . ": $last_changed";
        $tax_agencies = wp_cache_get($cache_key, 'erp-accounting');

        $cache_key_count     = 'erp-get-tax-agencies-count-' . md5(serialize($args)) . " : $last_changed";
        $tax_agencies_count  = wp_cache_get($cache_key_count, 'erp-accounting');

        if (false === $tax_agencies) {

            $limit = '';

            if (-1 !== $args['number']) {
                $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
            }

            $sql  = 'SELECT';
            $sql .= $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';
            $sql .= "FROM {$wpdb->prefix}erp_acct_tax_agencies ORDER BY {$args['orderby']} {$args['order']} {$limit}";

            if ($args['count']) {
                $tax_agencies_count = $wpdb->get_var($sql);

                wp_cache_set($cache_key_count, $tax_agencies_count, 'erp-accounting');
            } else {
                $tax_agencies = $wpdb->get_results($sql, ARRAY_A);

                wp_cache_set($cache_key, $tax_agencies, 'erp-accounting');
            }
        }

        if ($args['count']) {
            return $tax_agencies_count;
        }

        return $tax_agencies;
    }

    /**
     * Get an single tax agency
     *
     * @param $tax_no
     *
     * @return mixed
     */
    function getTaxAgency($tax_no)
    {
        global $wpdb;

        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}erp_acct_tax_agencies WHERE id = %d LIMIT 1", $tax_no), ARRAY_A);

        return $row;
    }

    /**
     * Insert tax agency
     *
     * @param $data
     *
     * @return int
     */
    function insertTaxAgency($data)
    {
        global $wpdb;

        $created_by         = get_current_user_id();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        $wpdb->insert(
            $wpdb->prefix . 'erp_acct_tax_agencies',
            [
                'name'       => $tax_data['agency_name'],
                'created_at' => $tax_data['created_at'],
                'created_by' => $tax_data['created_by'],
                'updated_at' => $tax_data['updated_at'],
                'updated_by' => $tax_data['updated_by'],
            ]
        );

        $tax_id = $wpdb->insert_id;


        return $tax_id;
    }

    /**
     * Update tax agency
     *
     * @param $data
     *
     * @return int
     */
    function updateTaxAgency($data, $id)
    {
        global $wpdb;

        $updated_by         = get_current_user_id();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        $wpdb->update(
            $wpdb->prefix . 'erp_acct_tax_agencies',
            [
                'name'       => $tax_data['agency_name'],
                'updated_at' => $tax_data['updated_at'],
                'updated_by' => $tax_data['updated_by'],
            ],
            [
                'id' => $id,
            ]
        );


        return $id;
    }

    /**
     * Delete an tax agency
     *
     * @param $tax_no
     *
     * @return int
     */
    function deleteTaxAgency($id)
    {
        global $wpdb;

        $wpdb->delete($wpdb->prefix . 'erp_acct_tax_agencies', ['id' => $id]);


        return $id;
    }

    /**
     * Get an single tax agency name
     *
     * @param $tax_no
     *
     * @return mixed
     */
    function getTaxAgencyNameById($agency_id)
    {
        global $wpdb;

        $row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT name FROM {$wpdb->prefix}erp_acct_tax_agencies WHERE id = %d LIMIT 1",
                $agency_id
            ),
            ARRAY_A
        );

        return $row['name'];
    }

    /**
     * Get agency due amount
     *
     * @param int $agency_id
     *
     * @return mixed
     */
    function erp_acct_get_agency_due($agency_id)
    {
        global $wpdb;

        return $wpdb->get_var($wpdb->prepare("SELECT SUM( credit - debit ) as tax_due From {$wpdb->prefix}erp_acct_tax_agency_details WHERE agency_id = %d", $agency_id));
    }
}
