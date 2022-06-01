<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\Taxes;

use Illuminate\Support\Facades\DB;

class TaxAgencies
{
    /**
     * Get all tax agencies
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getAllTaxAgencies($args = [])
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
        $sql .= "FROM account_tax_agency ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            $tax_agencies_count = DB::scalar($sql);
        } else {
            $tax_agencies = DB::select($sql);
        }

        if ($args['count']) {
            return $tax_agencies_count;
        }

        return $tax_agencies;
    }

    /**
     * Get an single tax agency
     *
     * @param int $tax_no Tax Number Filter
     *
     * @return mixed
     */
    public function getTaxAgency($tax_no)
    {


        $row = DB::select("SELECT * FROM account_tax_agency WHERE id = ? LIMIT 1", [$tax_no]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row;
    }
    /**
     * Get an single tax agency
     *
     * @param int $id ID
     *
     * @return mixed
     */
    public function getTaxAgencyById($id)
    {


        $row = DB::select("SELECT * FROM account_tax_agency WHERE id = ? LIMIT 1", [$id]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row;
    }


    /**
     * Insert tax agency
     *
     * @param array $data Data Filter
     *
     * @return int
     */
    public function insertTaxAgency($data)
    {

        $taxes = new Taxes();

        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        $tax_id = DB::table('account_tax_agency')
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
     * @param array $data Data
     * @param int   $id   ID
     *
     * @return int
     */
    public function updateTaxAgency($data, $id)
    {
        $taxes = new Taxes();

        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        DB::table('account_tax_agency')
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
     * @param int $id Tax Agency Id
     *
     * @return int
     */
    public function deleteTaxAgency($id)
    {


        DB::table('account_tax_agency')->where([['id' => $id]])->delete();


        return $id;
    }

    /**
     * Get an single tax agency name
     *
     * @param int $agency_id Agency Id
     *
     * @return mixed
     */
    public function getTaxAgencyNameById($agency_id)
    {


        $row = DB::select(
            "SELECT name FROM account_tax_agency WHERE id = ? LIMIT 1",
            [$agency_id]
        );
        $row = (!empty($row)) ? $row[0] : null;

        return $row['name'];
    }

    /**
     * Get agency due amount
     *
     * @param int $agency_id Agency Id
     *
     * @return mixed
     */
    public function getAgencyDue($agency_id)
    {
        return DB::scalar("SELECT SUM( credit - debit ) as tax_due From account_tax_agency_detail WHERE agency_id = ?", [$agency_id]);
    }
}
