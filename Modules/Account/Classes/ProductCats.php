<?php

namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;

class ProductCats
{

    /**
     * Get all product_cats
     *
     * @return mixed
     */
    function getAllProductCats()
    {

        $categories = DB::select('SELECT * FROM ' . 'erp_acct_product_categories', ARRAY_A);


        return $categories;
    }

    /**
     * Get an single product
     *
     * @param $product_cat_no
     *
     * @return mixed
     */
    function getProductCat($product_cat_id)
    {


        $row = DB::select("SELECT * FROM erp_acct_product_categories WHERE id = %d GROUP BY parent", [$product_cat_id]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row;
    }

    /**
     * Insert product data
     *
     * @param $data
     *
     * @return int
     */
    function insertProductCat($data)
    {


        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        try {
            $wpdb->query('START TRANSACTION');
            $product_cat_data = $this->getFormattedProductCatData($data);

            $product_cat_id =  DB::table('erp_acct_product_categories')
                ->insertGetId(
                    [
                        'name'       => $product_cat_data['name'],
                        'parent'     => isset($product_cat_data['parent']['id']) ? $product_cat_data['parent']['id'] : 0,
                        'created_at' => $product_cat_data['created_at'],
                        'created_by' => $product_cat_data['created_by'],
                        'updated_at' => $product_cat_data['updated_at'],
                        'updated_by' => $product_cat_data['updated_by'],
                    ]
                );


            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('product-exception', $e->getMessage());
        }


        return $product_cat_id;
    }

    /**
     * Update product data
     *
     * @param $data
     *
     * @return int
     */
    function updateProductCat($data, $id)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            $wpdb->query('START TRANSACTION');
            $product_cat_data = $this->getFormattedProductCatData($data);

            DB::table('erp_acct_product_categories')
                ->where('id', $id)
                ->update(
                    [
                        'name'       => $product_cat_data['name'],
                        'parent'     => $product_cat_data['parent'],
                        'created_at' => $product_cat_data['created_at'],
                        'created_by' => $product_cat_data['created_by'],
                        'updated_at' => $product_cat_data['updated_at'],
                        'updated_by' => $product_cat_data['updated_by'],
                    ]
                );

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('product-exception', $e->getMessage());
        }


        return $id;
    }

    /**
     * Get formatted product data
     *
     * @param $data
     * @param $voucher_no
     *
     * @return mixed
     */
    function getFormattedProductCatData($data)
    {
        $product_cat_data['name']       = isset($data['name']) ? $data['name'] : '';
        $product_cat_data['parent']     = isset($data['parent']) ? $data['parent'] : 0;
        $product_cat_data['created_at'] = isset($data['created_at']) ? $data['created_at'] : '';
        $product_cat_data['created_by'] = isset($data['created_by']) ? $data['created_by'] : '';
        $product_cat_data['updated_at'] = isset($data['updated_at']) ? $data['updated_at'] : '';
        $product_cat_data['updated_by'] = isset($data['updated_by']) ? $data['updated_by'] : '';

        return $product_cat_data;
    }

    /**
     * Delete an product
     *
     * @param $product_cat_no
     *
     * @return void
     */
    function deleteProductCat($product_cat_id)
    {


        DB::table('erp_acct_product_categories')->where([['id' => $product_cat_id]])->delete();
    }
}
