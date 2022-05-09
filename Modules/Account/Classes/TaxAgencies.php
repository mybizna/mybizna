<?php

namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;

class TaxAgencies
{
    /**
     * Get all tax agencies
     *
     * @return mixed
     */
    function getAllTaxAgencies($args = [])
    {


        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'ASC',
            'count'   => false,
            's'       => '',
        ];

        $args = array_merge($defaults, $args);

        $limit = '';

        if (-1 !== $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $sql  = 'SELECT';
        $sql .= $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';
        $sql .= "FROM erp_acct_tax_agencies ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            $tax_agencies_count = DB::scalar($sql);
        } else {
            $tax_agencies = DB::select($sql, ARRAY_A);
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


        $row = DB::select("SELECT * FROM erp_acct_tax_agencies WHERE id = %d LIMIT 1", [$tax_no]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row;
    }
    /**
     * Get an single tax agency
     *
     * @param $tax_no
     *
     * @return mixed
     */
    function getTaxAgencyById($id)
    {


        $row = DB::select("SELECT * FROM erp_acct_tax_agencies WHERE id = %d LIMIT 1", [$id]);
        $row = (!empty($row)) ? $row[0] : null;
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


        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        $tax_id = DB::table('erp_acct_tax_agencies')
            ->insert(
                [
                    'name'       => $tax_data['agency_name'],
                    'created_at' => $tax_data['created_at'],
                    'created_by' => $tax_data['created_by'],
                    'updated_at' => $tax_data['updated_at'],
                    'updated_by' => $tax_data['updated_by'],
                ]
            );



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


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        DB::table('erp_acct_tax_agencies')
            ->where('id', $id)
            ->update(
                [
                    'name'       => $tax_data['agency_name'],
                    'updated_at' => $tax_data['updated_at'],
                    'updated_by' => $tax_data['updated_by'],
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


        DB::table('erp_acct_tax_agencies')->where([['id' => $id]])->delete();


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


        $row = DB::select(
                "SELECT name FROM erp_acct_tax_agencies WHERE id = %d LIMIT 1",
                [$agency_id]
        );
        $row = (!empty($row)) ? $row[0] : null;

        return $row['name'];
    }

    /**
     * Get agency due amount
     *
     * @param int $agency_id
     *
     * @return mixed
     */
    function getAgencyDue($agency_id)
    {


        return DB::scalar("SELECT SUM( credit - debit ) as tax_due From erp_acct_tax_agency_details WHERE agency_id = %d", [$agency_id]);
    }
}
