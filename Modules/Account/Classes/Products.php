<?php

namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;
use ParseCsv/Csv;

class Products
{

    /**
     * Get all products
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */

    public function getAllProducts($args = [])
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

        $sql = 'SELECT';

        if ($args['count']) {
            $sql .= ' COUNT( product.id ) as total_number';
        } else {
            $sql .= " product.id,
                    product.name,
                    product.product_type_id,
                    product.cost_price,
                    product.sale_price,
                    product.tax_cat_id,
                    people.id AS vendor,
                    CONCAT(people.first_name, ' ',  people.last_name) AS vendor_name,
                    cat.id AS category_id,
                    cat.name AS cat_name,
                    product_type.name AS product_type_name";
        }

        $sql .= " FROM product AS product
            LEFT JOIN partner AS people ON product.vendor = people.id
            LEFT JOIN product_category AS cat ON product.category_id = cat.id
            LEFT JOIN product_type AS product_type ON product.product_type_id = product_type.id
            WHERE product.product_type_id<>3";

        if (!empty($args['s'])) {
            $sql .= " AND product.name LIKE '%{$args['s']}%'";
        }

        $sql .= " ORDER BY product.{$args['orderby']} {$args['order']} {$limit}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        if ($args['count']) {
            $products_count = DB::scalar($sql);
        } else {
            $products = DB::select($sql);
        }


        if ($args['count']) {
            return $products_count;
        }

        return $products;
    }

    /**
     * Get an single product
     *
     * @param int $product_id Product Id
     *
     * @return mixed
     */
    public function getProduct($product_id)
    {


        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select(
            "SELECT
            product.id,
            product.name,
            product.product_type_id,
            product.cost_price,
            product.sale_price,
            product.tax_cat_id,
            people.id AS vendor,
            CONCAT(people.first_name, ' ',  people.last_name) AS vendor_name,
            cat.id AS category_id,
            cat.name AS cat_name,
            product_type.name AS product_type_name

		FROM product AS product
		LEFT JOIN partner AS people ON product.vendor = people.id
		LEFT JOIN product_category AS cat ON product.category_id = cat.id
        LEFT JOIN product_type AS product_type ON product.product_type_id = product_type.id WHERE product.id = {$product_id} LIMIT 1"
        );

        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Insert product data
     *
     * @param array $data Data Filter
     *
     * @return config('kernel.messageBag')->add( | integer
     */
    public function insertProduct($data)
    {

        $products = new Products();

        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;
        $product_id         = null;

        try {
            DB::beginTransaction();
            $product_data = $products->getFormattedProductData($data);

            $product_check =  DB::select(

                "SELECT * FROM product where name = %s",
                [$product_data['name']]
            );


            $product_check = (!empty($product_check)) ? $product_check[0] : null;

            if ($product_check) {
                throw new \Exception($product_data['name'] . ' ' . __('product already exists!'));
            }

            $product_id = DB::table('product')
                ->insertGetId(
                    [
                        'name'            => $product_data['name'],
                        'product_type_id' => $product_data['product_type_id'],
                        'category_id'     => $product_data['category_id'],
                        'tax_cat_id'      => $product_data['tax_cat_id'],
                        'vendor'          => $product_data['vendor'],
                        'cost_price'      => $product_data['cost_price'],
                        'sale_price'      => $product_data['sale_price'],
                        'created_at'      => $product_data['created_at'],
                        'created_by'      => $product_data['created_by'],
                        'updated_at'      => $product_data['updated_at'],
                        'updated_by'      => $product_data['updated_by'],
                    ]
                );


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
             config('kernel.messageBag')->add('duplicate-product', $e->getMessage());
             return;
            }


        do_action('after_change_product_list');

        return $this->getAllProducts($product_id);
    }

    /**
     * Update product data
     *
     * @param array $data Data Filter
     *
     * @return config('kernel.messageBag')->add( | Object
     */
    public function updateProduct($data, $id)
    {

        $products = new Products();

        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            DB::beginTransaction();
            $product_data = $products->getFormattedProductData($data);

            $product_name_check =  DB::select(
                "SELECT * FROM product where name = %s AND id NOT IN(%d)",
                [
                    $product_data['name'],
                    $id
                ]
            );

            $product_name_check = (!empty($product_name_check)) ? $product_name_check[0] : null;


            if ($product_name_check) {
                throw new \Exception($product_data['name'] . ' ' . __("Product name already exists!", "erp"));
            }

            DB::table('product')
                ->where('id', $id)
                ->update(
                    [
                        'name'            => $product_data['name'],
                        'product_type_id' => $product_data['product_type_id'],
                        'category_id'     => $product_data['category_id'],
                        'tax_cat_id'      => $product_data['tax_cat_id'],
                        'vendor'          => $product_data['vendor'],
                        'cost_price'      => $product_data['cost_price'],
                        'sale_price'      => $product_data['sale_price'],
                        'created_at'      => $product_data['updated_at'],
                        'created_by'      => $product_data['updated_by'],
                        'updated_at'      => $product_data['updated_at'],
                        'updated_by'      => $product_data['updated_by'],
                    ]
                );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

             config('kernel.messageBag')->add('duplicate-product', $e->getMessage());
        }


        do_action('after_change_product_list');

        return $this->getAllProducts($id);
    }

    /**
     * Get formatted product data
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function getFormattedProductData($data)
    {
        $product_data['name']            = !empty($data['name']) ? $data['name'] : 1;
        $product_data['product_type_id'] = !empty($data['product_type_id']) ? $data['product_type_id'] : 1;
        $product_data['category_id']     = !empty($data['category_id']) ? $data['category_id'] : 0;
        $product_data['tax_cat_id']      = !empty($data['tax_cat_id']) ? $data['tax_cat_id'] : 0;
        $product_data['vendor']          = !empty($data['vendor']) ? $data['vendor'] : '';
        $product_data['cost_price']      = !empty($data['cost_price']) ? $data['cost_price'] : '';
        $product_data['sale_price']      = !empty($data['sale_price']) ? $data['sale_price'] : '';
        $product_data['created_at']      = !empty($data['created_at']) ? $data['created_at'] : '';
        $product_data['created_by']      = !empty($data['created_by']) ? $data['created_by'] : '';
        $product_data['updated_at']      = !empty($data['updated_at']) ? $data['updated_at'] : '';
        $product_data['updated_by']      = !empty($data['updated_by']) ? $data['updated_by'] : '';

        return $product_data;
    }

    /**
     * Delete an product
     *
     * @param int $product_id Product Id
     *
     * @return int
     */
    public function deleteProduct($product_id)
    {


        DB::table('product')->where([['id' => $product_id]])->delete();
        DB::table('product_detail')->where([['product_id' => $product_id]])->delete();


        do_action('after_change_product_list');

        return $product_id;
    }

    /**
     * Get product types
     *
     * @return int
     */
    public function getProductTypes()
    {


        $types = DB::select("SELECT * FROM product_type");

        return apply_filters('product_type', $types);
    }

    /**
     * Get product type id by product id
     *
     * @param Int $product_id Product Id
     *
     * @return int
     */
    public function getProductTypeIdByProductId($product_id)
    {


        $type_id = DB::scalar("SELECT product_type_id FROM product WHERE id = %d", [$product_id]);

        return $type_id;
    }

    /**
     * Get all products of a vendor
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getVendorProducts($args = [])
    {


        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'DESC',
            'count'   => false,
            's'       => '',
            'vendor'  => 0,
        ];

        $args = array_merge($defaults, $args);

        $limit = '';

        if (-1 !== $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $sql = 'SELECT';

        if ($args['count']) {
            $sql .= ' COUNT( product.id ) as total_number';
        } else {
            $sql .= " product.id,
                product.name,
                product.product_type_id,
                product.cost_price,
                product.sale_price,
                product.tax_cat_id,
                product.vendor,
                CONCAT(people.first_name, ' ',  people.last_name) AS vendor_name,
                cat.id AS category_id,
                cat.name AS cat_name,
                product_type.name AS product_type_name";
        }

        $sql .= " FROM product AS product
            LEFT JOIN partner AS people ON product.vendor = people.id
            LEFT JOIN product_category AS cat ON product.category_id = cat.id
            LEFT JOIN product_type AS product_type ON product.product_type_id = product_type.id
            WHERE people.id={$args['vendor']} AND product.product_type_id<>3 ORDER BY product.{$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            $products_vendor_count = DB::scalar($sql);
        } else {
            $products_vendor = DB::select($sql);
        }


        if ($args['count']) {
            return $products_vendor_count;
        }

        return $products_vendor;
    }

    /**
     * Validates csv data for importing
     *
     * @param array $data Data Filter
     *
     * @return array|config('kernel.messageBag')->add(
     */
    public function validateCsvData($data)
    {
        $files = wp_check_filetype_and_ext($data['csv_file']['tmp_name'], $data['csv_file']['name']);

        if ('csv' !== $files['ext'] && 'text/csv' !== $files['type']) {
             config('kernel.messageBag')->add('invalid-file-type', __('The file is not a valid CSV file! Please provide a valid one.'));
            return;
        }

        $csv = new Csv();
        $csv->encoding(null, 'UTF-8');
        $csv->parse($data['csv_file']['tmp_name']);

        if (empty($csv->data)) {
             config('kernel.messageBag')->add('no-data', __('No data found to import!'));
             return;
            }

        $csv_data   = [];
        $csv_data[] = array_keys($csv->data[0]);

        foreach ($csv->data as $data_item) {
            $csv_data[] = array_values($data_item);
        }

        if (empty($csv_data)) {
             config('kernel.messageBag')->add('no-data', __('No data found to import!'));
            return;
        }

        $count           = 0;
        $errors          = [];
        $product_data    = [];
        $to_be_updated   = [];
        $processed_data  = '';
        $temp_type       = $data['type'];
        $update_existing = (int) $data['update_existing'] ? true : false;
        $curr_date       = date('Y-m-d');
        $user            = auth()->user()->id;

        if ($update_existing) {
            $temp_type = 'product_non_unique';
        }

        $errors = apply_filters('validate_csv_data', $csv_data, $data['fields'], $temp_type);

        if (!empty($errors)) {
             config('kernel.messageBag')->add('import-error', $errors);
             return;
        }

        unset($csv_data[0]);

        foreach ($csv_data as $index => $line) {
            if (empty($line)) {
                continue;
            }

            if (is_array($data['fields']) && !empty($data['fields'])) {
                $product_data[$index] = '';
                $product_exists_id      = '';
                $product_checked        = false;



                foreach ($data['fields'] as $key => $value) {
                    switch ($key) {
                        case 'category_id':
                            if (!empty($line[$value])) {
                                $valid_value = DB::scalar(
                                    "SELECT id
                                FROM product_category
                                WHERE id = {$line[$value]}"
                                );
                            }

                            break;

                        case 'product_type_id':
                            if (!empty($line[$value])) {
                                $valid_value = DB::scalar(
                                    "SELECT id
                                FROM product_type
                                WHERE id = {$line[$value]}"
                                );
                            }

                            break;

                        case 'tax_cat_id':
                            if (!empty($line[$value])) {
                                $valid_value = DB::scalar(
                                    "SELECT id
                                FROM account_tax_category
                                WHERE id = {$line[$value]}"
                                );
                            }

                            break;

                        case 'vendor':
                            if (!empty($line[$value])) {
                                $valid_value = DB::scalar(
                                    "SELECT people.id
                                FROM partner AS people
                                LEFT JOIN partner_type_relation AS rel
                                ON people.id = rel.people_id
                                WHERE people.id = {$line[$value]}
                                AND rel.people_types_id = 4"
                                );
                            }

                            break;

                        default:
                            $valid_value = true;
                    }

                    $value = !empty($line[$value]) &&
                        !empty($valid_value)
                        ? $line[$value]
                        : (!empty($data[$key])
                            ? $data[$key]
                            : ''
                        );

                    if ($update_existing && !$product_checked && 'name' === $key) {
                        $product_exists_id =  DB::scalar(
                            "SELECT id FROM product where name = %s",
                            [$value]
                        );

                        $product_checked = true;
                    }

                    if (empty($product_exists_id)) {
                        $product_data[$index] .= "'{$value}',";
                    } else {
                        $to_be_updated[$product_exists_id][$key] = $value;
                    }
                }

                if (empty($product_exists_id)) {
                    $product_data[$index] .= "'{$user}','{$curr_date}'";
                } else {
                    unset($product_data[$index]);
                }

                ++$count;
            }
        }

        if (!empty($product_data)) {
            $processed_data = '(' . implode('),(', $product_data) . ')';
        }

        return [
            'data'   => $processed_data,
            'update' => $to_be_updated,
            'total'  => $count
        ];
    }

    /**
     * Imports products from csv
     *
     * @param array $data Data Filter
     *
     * @return int|config('kernel.messageBag')->add(
     */
    public function importProducts($data)
    {


        if (!empty($data['items'])) {
            $inserted = DB::delete(
                "INSERT INTO product
            (name, product_type_id, category_id, cost_price, sale_price, vendor, tax_cat_id, created_by, created_at)
            VALUES {$data['items']}"
            );

            if (!$inserted) {
                 config('kernel.messageBag')->add('import-db-error', __('Something went wrong'));
                return;
            }
        }

        if (!empty($data['update'])) {
            $curr_date = date('Y-m-d');
            $user      = auth()->user()->id;

            foreach ($data['update'] as $id => $field_data) {
                $field_data['updated_at'] = $curr_date;
                $field_data['updated_by'] = $user;

                DB::table("product")->where('id', $id)->update($field_data);
            }
        }

        if (0 >= (int) $data['total']) {
             config('kernel.messageBag')->add('import-error', __('No data imported'));
            return;
        }

        return $data['total'];
    }
}
