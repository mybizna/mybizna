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
    public function getAllProductCats()
    {

        $categories = DB::select('SELECT * FROM ' . 'product_category');


        return $categories;
    }

    /**
     * Get an single product
     *
     * @param int $product_cat_id Product Cat ID
     *
     * @return mixed
     */
    public function getProductCat($product_cat_id)
    {


        $row = DB::select("SELECT * FROM product_category WHERE id = %d GROUP BY parent", [$product_cat_id]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row;
    }

    /**
     * Insert product data
     *
     * @param array $data Data Filter
     *
     * @return int
     */
    public function insertProductCat($data)
    {


        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        try {
            DB::beginTransaction();
            $product_cat_data = $this->getFormattedProductCatData($data);

            $product_cat_id =  DB::table('product_category')
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


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            config('kernel.messageBag')->add('product-exception', $e->getMessage());
            return;
        }


        return $product_cat_id;
    }

    /**
     * Update product data
     *
     * @param array $data Data Filter
     * @param array $id   Id
     *
     * @return int
     */
    public function updateProductCat($data, $id)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            DB::beginTransaction();
            $product_cat_data = $this->getFormattedProductCatData($data);

            DB::table('product_category')
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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            config('kernel.messageBag')->add('product-exception', $e->getMessage());
            return;
        }


        return $id;
    }

    /**
     * Get formatted product data
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function getFormattedProductCatData($data)
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
     * @param int $product_cat_id Product Cat Id
     *
     * @return void
     */
    public function deleteProductCat($product_cat_id)
    {


        DB::table('product_category')->where([['id' => $product_cat_id]])->delete();
    }
}
