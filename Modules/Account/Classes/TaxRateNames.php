<?php

namespace Modules\Account\Classes;


use Illuminate\Support\Facades\DB;

class TaxRateNames
{

    /**
     * Get all tax rate names
     *
     * @param array $args Tax Rate Name
     *
     * @return mixed
     */
    public function getAllTaxRateNames($args = [])
    {


        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'DESC',
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
        $sql .= "FROM account_tax ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            $tax_rates_count = DB::scalar($sql);
        } else {
            $tax_rates = DB::select($sql);
        }

        if ($args['count']) {
            return $tax_rates_count;
        }

        return $tax_rates;
    }

    /**
     * Get an single tax rate name
     *
     * @param int $tax_no Tax Number
     *
     * @return mixed
     */
    public function getTaxRateName($tax_no)
    {


        $row = DB::select("SELECT * FROM account_tax WHERE id = ? LIMIT 1", [$tax_no]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row;
    }

    /**
     * Insert tax rate name
     *
     * @param array $data Data
     *
     * @return int
     */
    public function insertTaxRateName($data)
    {

        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        if (!empty($data['default'])) {
            DB::update("UPDATE account_tax SET `default` = 0");
        }

        $tax_data = $this->getFormattedTaxRateNameData($data);

        return DB::table('account_tax')
            ->insertGetId(
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
    }

    /**
     * Update tax rate name
     *
     * @param array $data Data
     * @param array $id   ID
     *
     * @return int
     */
    public function updateTaxRateName($data, $id)
    {

        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $this->getFormattedTaxRateNameData($data);

        if (!empty($tax_data['default'])) {
            DB::update("UPDATE account_tax SET `default` = 0");
        }

        DB::table('account_tax')
            ->where('id', $id)
            ->update(
                [
                    'tax_rate_name' => $tax_data['tax_rate_name'],
                    'tax_number'    => $tax_data['tax_number'],
                    'default'       => $tax_data['default'],
                    'updated_at'    => $tax_data['updated_at'],
                    'updated_by'    => $tax_data['updated_by'],
                ]
            );


        return $id;
    }

    /**
     * Delete an tax rate name
     *
     * @param int $id Id
     *
     * @return int
     */
    public function deleteTaxRateName($id)
    {


        DB::table('account_tax')->where([['id' => $id]])->delete();


        return $id;
    }

    /**
     * Get formatted tax rate name data
     *
     * @param array $data Data
     *
     * @return mixed
     */
    public function getFormattedTaxRateNameData($data)
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
