<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\Taxes;

use Illuminate\Support\Facades\DB;

class TaxCats
{

    /**
     * Get all tax categories
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getAllTaxCats($args = [])
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
        $sql .= "FROM account_tax_category ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            $tax_cats_count = DB::scalar($sql);
        } else {
            $tax_cats = DB::select($sql);
        }


        if ($args['count']) {
            return $tax_cats_count;
        }

        return $tax_cats;
    }

    /**
     * Get an single tax category
     *
     * @param int $tax_no Tax No
     *
     * @return mixed
     */
    public function getTaxCat($tax_no)
    {


        $row = DB::select("SELECT * FROM account_tax_category WHERE id = ? LIMIT 1", [$tax_no]);
$row = (!empty($row)) ? $row[0] : null;
        return $row;
    }

    /**
     * Get an single tax category
     *
     * @param int $id Tax No
     *
     * @return mixed
     */
    public function getTaxCategoryById($id)
    {


        $row = DB::select("SELECT * FROM account_tax_category WHERE id = ? LIMIT 1", [$id]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row;
    }

    /**
     * Insert tax category data
     *
     * @param array $data Data Filter
     *
     * @return int
     */
    public function insertTaxCat($data)
    {
        $taxes = new Taxes();

        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        $tax_id =  DB::table('account_tax_category')
            ->insertGetId(
                [
                    'name'        => $tax_data['name'],
                    'description' => $tax_data['description'],
                    'created_at'  => $tax_data['created_at'],
                    'created_by'  => $tax_data['created_by'],
                    'updated_at'  => $tax_data['updated_at'],
                    'updated_by'  => $tax_data['updated_by'],
                ]
            );



        return $tax_id;
    }

    /**
     * Update tax category
     *
     * @param array $data Data Filter
     * @param int   $id   Id
     *
     * @return int
     */
    public function updateTaxCat($data, $id)
    {
        $taxes = new Taxes();

        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $taxes->getFormattedTaxData($data);

        DB::table('account_tax_category')
            ->where('id', $id)
            ->update(
                [
                    'name'        => $tax_data['name'],
                    'description' => $tax_data['description'],
                    'updated_at'  => $tax_data['updated_at'],
                    'updated_by'  => $tax_data['updated_by'],
                ]
            );


        return $id;
    }

    /**
     * Delete a tax category
     *
     * @param int $id Tax Category ID
     *
     * @return int
     */
    public function deleteTaxCat($id)
    {


        DB::table('account_tax_category')->where([['id' => $id]])->delete();


        return $id;
    }
}
