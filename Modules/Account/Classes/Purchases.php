<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;

use Modules\Account\Classes\People;

use Illuminate\Support\Facades\DB;

class Purchases
{

    /**
     * Get all purchases
     *
     * @param array $args
     *
     * @return mixed
     */
    function getPurchases($args = [])
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
        $sql .= "FROM erp_acct_purchase ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            return DB::scalar($sql);
        }

        return DB::select($sql, ARRAY_A);
    }

    /**
     * Get a purchase
     *
     * @param $purchase_no
     *
     * @return mixed
     */
    function getPurchase($purchase_no)
    {


        $sql = $wpdb->prepare(
            "SELECT

            voucher.editable,
            purchase.id,
            purchase.voucher_no,
            purchase.vendor_id,
            purchase.trn_date,
            purchase.due_date,
            purchase.amount,
            purchase.vendor_name,
            purchase.ref,
            purchase.status,
            purchase.purchase_order,
            purchase.attachments,
            purchase.particulars,
            purchase.created_at,
            purchase.tax,
            purchase.tax_zone_id,

            purchase_acc_detail.purchase_no,
            purchase_acc_detail.debit,
            purchase_acc_detail.credit

        FROM erp_acct_purchase AS purchase
        LEFT JOIN erp_acct_voucher_no as voucher ON purchase.voucher_no = voucher.id
        LEFT JOIN erp_acct_purchase_account_details AS purchase_acc_detail ON purchase.voucher_no = purchase_acc_detail.trn_no
        WHERE purchase.voucher_no = %d",
            $purchase_no
        );

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row                = DB::select($sql, ARRAY_A);
        $row = (!empty($row)) ? $row[0] : null;
        $row['line_items']  = $this->formatPurchaseLineItems($purchase_no);
        $row['attachments'] = unserialize($row['attachments']);
        $row['total_due']   = $row['credit'] - $row['debit'];
        $row['pdf_link']    = $this->pdfAbsPathToUrl($purchase_no);

        return $row;
    }

    /**
     * Purchase items detail
     *
     * @param $voucher_no
     *
     * @return array|object|null
     */
    function formatPurchaseLineItems($voucher_no)
    {


        $sql = $wpdb->prepare(
            "SELECT
            purchase_detail.product_id,
            purchase_detail.qty,
            purchase_detail.price,
            purchase_detail.amount,

            product.name,
            product.product_type_id,
            product.category_id,
            product.vendor,
            product.cost_price,
            product.sale_price as unit_price

        FROM erp_acct_purchase AS purchase
        LEFT JOIN erp_acct_purchase_details AS purchase_detail ON purchase.voucher_no = purchase_detail.trn_no
        LEFT JOIN erp_acct_products AS product ON purchase_detail.product_id = product.id
        WHERE purchase.voucher_no = %d",
            $voucher_no
        );

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $results = DB::select($sql, ARRAY_A);

        // calculate every line total
        foreach ($results as $key => $value) {
            $results[$key]['line_total'] = $value['amount'];
        }

        return $results;
    }

    /**
     * Insert a purchase
     *
     * @param $data
     *
     * @return mixed
     */
    function insertPurchase($data)
    {

        $common = new CommonFunc();
        $people = new People();
        $trans = new Transactions();

        $created_by         = auth()->user()->id;
        $voucher_no         = null;
        $data['created_at'] = date('Y-m-d');
        $data['created_by'] = $created_by;
        $data['updated_at'] = date('Y-m-d');
        $data['updated_by'] = $created_by;

        $purchase_type_order = 1;
        $draft               = 1;
        $currency            = $common->getCurrency(true);

        try {
            $wpdb->query('START TRANSACTION');

            $voucher_no    = DB::table('erp_acct_voucher_no')
                ->insertGetId(
                    [
                        'type'       => 'purchase',
                        'currency'   => $currency,
                        'editable'   => 1,
                        'created_at' => $data['created_at'],
                        'created_by' => $created_by,
                        'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : '',
                        'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : '',
                    ]
                );

            $purchase_no   = $voucher_no;
            $purchase_data = $this->getFormattedPurchaseData($data, $voucher_no);

            DB::table('erp_acct_purchase')
                ->insert(
                    [
                        'voucher_no'      => $voucher_no,
                        'vendor_id'       => $purchase_data['vendor_id'],
                        'vendor_name'     => $purchase_data['vendor_name'],
                        'billing_address' => $purchase_data['billing_address'],
                        'trn_date'        => $purchase_data['trn_date'],
                        'due_date'        => $purchase_data['due_date'],
                        'amount'          => $purchase_data['amount'],
                        'tax'             => $purchase_data['tax'],
                        'tax_zone_id'     => isset($purchase_data['tax_rate']['id']) ? $purchase_data['tax_rate']['id'] : null,
                        'ref'             => $purchase_data['ref'],
                        'status'          => $purchase_data['status'],
                        'purchase_order'  => $purchase_data['purchase_order'],
                        'attachments'     => $purchase_data['attachments'],
                        'particulars'     => $purchase_data['particulars'],
                        'created_at'      => $purchase_data['created_at'],
                        'created_by'      => $created_by,
                        'updated_at'      => $purchase_data['updated_at'],
                        'updated_by'      => $purchase_data['updated_by'],
                    ]
                );

            $items = $data['line_items'];

            foreach ($items as $item) {
                $details_id = DB::table('erp_acct_purchase_details')
                    ->insertGetId(
                        [
                            'trn_no'     => $voucher_no,
                            'product_id' => $item['product_id'],
                            'qty'        => $item['qty'],
                            'price'      => $item['unit_price'],
                            'tax'        => isset($item['tax_amount']) ? $item['tax_amount'] : 0,
                            'tax_cat_id' => isset($item['tax_cat_id']) ? $item['tax_cat_id'] : null,
                            'amount'     => $item['item_total'],
                            'created_at' => $purchase_data['created_at'],
                            'created_by' => $created_by,
                            'updated_at' => $purchase_data['updated_at'],
                            'updated_by' => $purchase_data['updated_by'],
                        ]
                    );


                if (isset($purchase_data['tax_rate'])) {
                    $tax_rate_agency = $common->getTaxRateWithAgency($purchase_data['tax_rate']['id'], $item['tax_cat_id']);

                    foreach ($tax_rate_agency as $tra) {
                        DB::table('erp_acct_purchase_details_tax')
                            ->insert(
                                [
                                    'invoice_details_id' => $details_id,
                                    'agency_id'          => $tra['agency_id'],
                                    'tax_rate'           => $tra['tax_rate'],
                                    'created_at'         => $purchase_data['created_at'],
                                    'created_by'         => $created_by,
                                    'updated_at'         => $purchase_data['updated_at'],
                                    'updated_by'         => $purchase_data['updated_by'],
                                ]
                            );
                    }
                }
            }

            do_action('erp_acct_after_purchase_create', $data, $voucher_no);

            $email = $people->getPeopleEmail($purchase_data['vendor_id']);

            if ($purchase_type_order === $purchase_data['purchase_order'] || $draft === $purchase_data['status']) {
                $wpdb->query('COMMIT');
                $purchase_order          = $this->getPurchases($voucher_no);
                $purchase_order['email'] = $email;
                do_action('erp_acct_new_transaction_purchase_order', $voucher_no, $purchase_order);

                return $purchase_order;
            }

            DB::table('erp_acct_purchase_account_details')
                ->insert(
                    [
                        'purchase_no' => $purchase_no,
                        'trn_no'      => $voucher_no,
                        'trn_date'    => $purchase_data['trn_date'],
                        'particulars' => $purchase_data['particulars'],
                        'debit'       => 0,
                        'credit'      => $purchase_data['amount'],
                        'created_at'  => $purchase_data['created_at'],
                        'created_by'  => $created_by,
                        'updated_at'  => $purchase_data['updated_at'],
                        'updated_by'  => $purchase_data['updated_by'],
                    ]
                );

            $this->insertPurchaseDataIntoLedger($purchase_data);

            $data['dr']          = 0;
            $data['cr']          = $purchase_data['amount'];
            $data['particulars'] = __('Purchase Total', 'erp');

            $trans->insertDataIntoPeopleTrnDetails($data, $voucher_no);

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('purchase-exception', $e->getMessage());
        }

        $purchase = $this->getPurchases($purchase_no);

        $purchase['email'] = $email;

        do_action('erp_acct_new_transaction_purchase', $voucher_no, $purchase);


        return $purchase;
    }

    /**
     * Update a purchase
     *
     * @param $purchase_data
     * @param $purchase_id
     *
     * @return mixed
     */
    function updatePurchase($purchase_data, $purchase_id)
    {

        $common = new CommonFunc();
        $trans = new Transactions();

        if (1 === $purchase_data['purchase_order'] && $purchase_data['convert']) {
            $this->convertOrderToPurchase($purchase_data, $purchase_id);
            return;
        }

        $user_id             = auth()->user()->id;
        $purchase_type_order = 1;
        $draft               = 1;
        $voucher_no          = null;

        $data['created_at'] = date('Y-m-d');
        $data['created_by'] = $user_id;
        $data['updated_at'] = date('Y-m-d');
        $data['updated_by'] = $user_id;
        $currency           = $common->getCurrency(true);

        try {
            $wpdb->query('START TRANSACTION');

            if ($purchase_type_order === $purchase_data['purchase_order'] || $draft === $purchase_data['status']) {
                $purchase_data = $this->getFormattedPurchaseData($purchase_data, $purchase_id);

                DB::table('erp_acct_purchase')
                    ->where('voucher_no', $purchase_id)
                    ->update(
                        [
                            'vendor_id'      => $purchase_data['vendor_id'],
                            'vendor_name'    => $purchase_data['vendor_name'],
                            'trn_date'       => $purchase_data['trn_date'],
                            'due_date'       => $purchase_data['due_date'],
                            'amount'         => $purchase_data['amount'] + $purchase_data['tax'],
                            'tax'            => $purchase_data['tax'],
                            'tax_zone_id'    => isset($purchase_data['tax_rate']['id']) ? $purchase_data['tax_rate']['id'] : null,
                            'ref'            => $purchase_data['ref'],
                            'status'         => $purchase_data['status'],
                            'purchase_order' => $purchase_data['purchase_order'],
                            'attachments'    => $purchase_data['attachments'],
                            'particulars'    => $purchase_data['particulars'],
                            'created_at'     => $purchase_data['created_at'],
                            'created_by'     => $purchase_data['created_by'],
                            'updated_at'     => $purchase_data['updated_at'],
                            'updated_by'     => $purchase_data['updated_by'],
                        ]
                    );

                /**
                 *? We can't update `purchase_details` directly
                 *? suppose there were 5 detail rows previously
                 *? but on update there may be 2 detail rows
                 *? that's why we can't update because the foreach will iterate only 2 times, not 5 times
                 *? so, remove previous rows and insert new rows
                 */
                $prev_detail_ids = DB::select($wpdb->prepare("SELECT id FROM erp_acct_purchase_details WHERE trn_no = %s", $purchase_id), ARRAY_A);

                $prev_detail_ids = implode(',', array_map('absint', $prev_detail_ids));

                DB::table('erp_acct_purchase_details')->where([['trn_no' => $purchase_id]])->delete();

                $wpdb->query("DELETE FROM erp_acct_purchase_details_tax WHERE invoice_details_id IN($prev_detail_ids)"); // delete previous tax data

                $items = $purchase_data['purchase_details'];

                foreach ($items as $key => $item) {
                    DB::table('erp_acct_purchase_details')
                        ->where('trn_no', $purchase_id)
                        ->update(
                            [
                                'product_id' => $item['product_id'],
                                'qty'        => $item['qty'],
                                'price'      => $item['unit_price'],
                                'amount'     => $item['item_total'],
                                'tax'        => $item['tax_amount'],
                                'created_at' => $purchase_data['created_at'],
                                'created_by' => $purchase_data['created_by'],
                                'updated_at' => $purchase_data['updated_at'],
                                'updated_by' => $purchase_data['updated_by'],
                            ]
                        );

                    $details_id = $wpdb->insert_id;

                    if (isset($purchase_data['tax_rate'])) {
                        $tax_rate_agency = $common->getTaxRateWithAgency($purchase_data['tax_rate']['id'], $item['tax_cat_id']);

                        foreach ($tax_rate_agency as $tra) {
                            DB::table('erp_acct_purchase_details_tax')
                                ->insert(
                                    [
                                        'invoice_details_id' => $details_id,
                                        'agency_id'          => $tra['agency_id'],
                                        'tax_rate'           => $tra['tax_rate'],
                                        'updated_at'         => $purchase_data['updated_at'],
                                        'updated_by'         => $purchase_data['updated_by'],
                                    ]
                                );
                        }
                    }
                }

                $wpdb->query('COMMIT');

                return $this->getPurchases($purchase_id);
            } else {
                // disable editing on old bill
                DB::table('erp_acct_voucher_no')
                    ->where('id', $purchase_id)
                    ->update(['editable' => 0]);
                // insert contra voucher
                $voucher_no =  DB::table('erp_acct_voucher_no')
                    ->insertGetId(
                        [
                            'type'       => 'purchase',
                            'currency'   => $currency,
                            'editable'   => 0,
                            'created_at' => $data['created_at'],
                            'created_by' => $data['created_by'],
                            'updated_at' => $data['updated_at'],
                            'updated_by' => $data['updated_by'],
                        ]
                    );


                $old_purchase = $this->getPurchases($purchase_id);

                // insert contra `erp_acct_purchase` (basically a duplication of row)
                $wpdb->query($wpdb->prepare("CREATE TEMPORARY TABLE acct_tmptable SELECT * FROM erp_acct_purchase WHERE voucher_no = %d", $purchase_id));
                $wpdb->query(
                    $wpdb->prepare(
                        "UPDATE acct_tmptable SET id = %d, voucher_no = %d, particulars = 'Contra entry for voucher no \#%d', created_at = '%s'",
                        0,
                        $voucher_no,
                        $purchase_id,
                        $data['created_at']
                    )
                );
                $wpdb->query("INSERT INTO erp_acct_purchase SELECT * FROM acct_tmptable");
                $wpdb->query('DROP TABLE acct_tmptable');

                // change purchase status and other things
                $status_closed = 7;
                $wpdb->query(
                    $wpdb->prepare(
                        "UPDATE erp_acct_purchase SET status = %d, updated_at ='%s', updated_by = %d WHERE voucher_no IN (%d, %d)",
                        $status_closed,
                        $data['updated_at'],
                        $user_id,
                        $purchase_id,
                        $voucher_no
                    )
                );

                $items = $old_purchase['line_items'];

                foreach ($items as $key => $item) {
                    DB::table('erp_acct_purchase_details')
                        ->insert(
                            [
                                'trn_no'     => $voucher_no,
                                'product_id' => $item['product_id'],
                                'qty'        => $item['qty'],
                                'price'      => $item['unit_price'],
                                'amount'     => (float) $item['qty'] * (float) $item['unit_price'],
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => $user_id,
                            ]
                        );
                }

                DB::table('erp_acct_purchase_account_details')
                    ->insert(
                        [
                            'purchase_no' => $purchase_id,
                            'trn_no'      => $voucher_no,
                            'trn_date'    => $purchase_data['trn_date'],
                            'particulars' => $purchase_data['particulars'],
                            'debit'       => $old_purchase['amount'],
                            'updated_at'  => date('Y-m-d H:i:s'),
                            'updated_by'  => $user_id,
                        ]
                    );

                do_action('erp_acct_after_purchase_update', $purchase_data, $purchase_id);

                $this->updatePurchaseDataIntoLedger($items, $purchase_id);

                $new_purchase = $this->insertPurchase($purchase_data);

                $data['dr'] = 0;
                $data['cr'] = $purchase_data['amount'];
                $trans->updateDataIntoPeopleTrnDetails($data, $old_purchase['voucher_no']);
            }

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('purchase-exception', $e->getMessage());
        }


        return $this->getPurchases($new_purchase['voucher_no']);
    }

    /**
     * Convert order to purchase
     *
     * @param array $purchase_data
     * @param int   $purchase_id
     *
     * @return array
     */
    function convertOrderToPurchase($purchase_data, $purchase_id)
    {

        $people = new People();
        $trans = new Transactions();

        $user_id = auth()->user()->id;

        try {
            $wpdb->query('START TRANSACTION');

            $purchase_data = $this->getFormattedPurchaseData($purchase_data, $purchase_id);

            // purchase
            DB::table('erp_acct_purchase')
                ->where('voucher_no', $purchase_id)
                ->update(
                    [
                        'vendor_id'      => $purchase_data['vendor_id'],
                        'vendor_name'    => $purchase_data['vendor_name'],
                        'trn_date'       => $purchase_data['trn_date'],
                        'due_date'       => $purchase_data['due_date'],
                        'amount'         => $purchase_data['amount'] + $purchase_data['tax'],
                        'tax'            => $purchase_data['tax'],
                        'ref'            => $purchase_data['ref'],
                        'status'         => 2,
                        'purchase_order' => false,
                        'attachments'    => $purchase_data['attachments'],
                        'particulars'    => $purchase_data['particulars'],
                        'created_at'     => $purchase_data['created_at'],
                        'created_by'     => $purchase_data['created_by'],
                        'updated_at'     => $purchase_data['updated_at'],
                        'updated_by'     => $purchase_data['updated_by'],
                    ]
                );

            // remove data from purchase_details
            DB::table('erp_acct_purchase_details')->where([['trn_no' => $purchase_id]])->delete();

            foreach ($purchase_data['line_items'] as $item) {
                DB::table('erp_acct_purchase_details', [
                    'trn_no'     => $purchase_id,
                    'product_id' => $item['product_id'],
                    'qty'        => $item['qty'],
                    'price'      => $item['unit_price'],
                    'amount'     => (float) $item['qty'] * (float) $item['unit_price'],
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => $user_id,
                ]);
            }

            DB::table('erp_acct_purchase_account_details', [
                'purchase_no' => $purchase_id,
                'trn_no'      => $purchase_id,
                'trn_date'    => $purchase_data['trn_date'],
                'particulars' => $purchase_data['particulars'],
                'credit'      => $purchase_data['amount'],
                'updated_at'  => date('Y-m-d'),
                'updated_by'  => $user_id,
            ]);

            $this->insertPurchaseDataIntoLedger($purchase_data);

            $data['dr']        = 0;
            $data['cr']        = $purchase_data['amount'];
            $data['vendor_id'] = $purchase_data['vendor_id'];
            $trans->insertDataIntoPeopleTrnDetails($data, $purchase_id);

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('purchase-exception', $e->getMessage());
        }

        $purchase = $this->getPurchases($purchase_id);

        $purchase['email'] = $people->getPeopleEmail($purchase['vendor_id']);

        do_action('erp_acct_new_transaction_purchase', $purchase_id, $purchase);


        return $purchase;
    }

    /**
     * Void a purchase
     *
     * @param $id
     *
     * @return void
     */
    function voidPurchase($id)
    {


        if (!$id) {
            return;
        }

        DB::table('erp_acct_purchase')
            ->where('voucher_no', $id)
            ->update(
                [
                    'status' => 8,
                ]
            );

        DB::table('erp_acct_ledger_details')->where([['trn_no' => $id]])->delete();
        DB::table('erp_acct_purchase_account_details')->where([['purchase_no' => $id]])->delete();
    }

    /**
     * Get formatted purchase data
     *
     * @param $data
     * @param $voucher_no
     *
     * @return mixed
     */
    function getFormattedPurchaseData($data, $voucher_no)
    {
        $people = new People();
        $user_info = $people->getPeople($data['vendor_id']);

        $purchase_data['voucher_no']      = isset($data['voucher_no']) ? $data['voucher_no'] : $voucher_no;
        $purchase_data['vendor_id']       = isset($data['vendor_id']) ? $data['vendor_id'] : 0;
        $purchase_data['vendor_name']     = $user_info->first_name . ' ' . $user_info->last_name;
        $purchase_data['billing_address'] = isset($data['billing_address']) ? $data['billing_address'] : '';
        $purchase_data['trn_date']        = isset($data['trn_date']) ? $data['trn_date'] : date('Y-m-d');
        $purchase_data['due_date']        = isset($data['due_date']) ? $data['due_date'] : date('Y-m-d');
        $purchase_data['amount']          = isset($data['amount']) ? floatval($data['amount']) : 0;
        $purchase_data['tax']             = isset($data['tax']) ? floatval($data['tax']) : 0;
        $purchase_data['tax_rate']        = isset($data['tax_rate']) ?   $data['tax_rate']  : [];
        $purchase_data['attachments']     = isset($data['attachments']) ? $data['attachments'] : '';
        $purchase_data['status']          = isset($data['status']) ? intval($data['status']) : '';
        $purchase_data['line_items']      = isset($data['line_items']) ? $data['line_items'] : [];
        $purchase_data['purchase_order']  = isset($data['purchase_order']) ? intval($data['purchase_order']) : '';
        $purchase_data['ref']             = isset($data['ref']) ? $data['ref'] : '';
        // translators: %s: voucher_no
        $purchase_data['particulars'] = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Purchase created with voucher no %s', 'erp'), $voucher_no);
        $purchase_data['created_at']  = date('Y-m-d');
        $purchase_data['created_by']  = isset($data['created_by']) ? $data['created_by'] : '';
        $purchase_data['updated_at']  = isset($data['updated_at']) ? $data['updated_at'] : '';
        $purchase_data['updated_by']  = isset($data['updated_by']) ? $data['updated_by'] : '';

        if (!empty($data['purchase_order'])) {
            $purchase_data['status'] = 3;
        }

        return $purchase_data;
    }

    /**
     * Insert purchase/s data into ledger
     *
     * @param array $purchase_data
     *
     * @return mixed
     */
    function insertPurchaseDataIntoLedger($purchase_data)
    {


        $ledger_map = \WeDevs\ERP\Accounting\Includes\Classes\Ledger_Map::get_instance();
        $purchase_ledger_id  = $ledger_map->get_ledger_id_by_slug('purchase');

        if (!$purchase_ledger_id) {
            return new WP_Error(505, 'Ledger ID not found for purchase', $purchase_data);
        }

        $purchase_data['tax'] = $purchase_data['tax'] ? (int) $purchase_data['tax'] : 0;

        // Insert amount in ledger_details
        DB::table('erp_acct_ledger_details')
            ->insert(
                [
                    'ledger_id'   => $purchase_ledger_id,
                    'trn_no'      => $purchase_data['voucher_no'],
                    'particulars' => $purchase_data['particulars'],
                    'debit'       => $purchase_data['amount'] - $purchase_data['tax'],
                    'credit'      => 0,
                    'trn_date'    => $purchase_data['trn_date'],
                    'created_at'  => $purchase_data['created_at'],
                    'created_by'  => $purchase_data['created_by'],
                    'updated_at'  => $purchase_data['updated_at'],
                    'updated_by'  => $purchase_data['updated_by'],
                ]
            );

        if ($purchase_data['tax']) {

            $purchase_vat_ledger_id = $ledger_map->get_ledger_id_by_slug('purchase_vat');
            if (!$purchase_vat_ledger_id) {
                return new WP_Error(505, __('Ledger ID not found for purchase vat', 'erp'), $purchase_data);
            }

            // Insert amount in ledger_details
            DB::table('erp_acct_ledger_details')
                ->insert(
                    [
                        'ledger_id'   => $purchase_vat_ledger_id,
                        'trn_no'      => $purchase_data['voucher_no'],
                        'particulars' => sprintf(__('Purchase Vat of voucher no- %1$s', 'erp'), $purchase_data['voucher_no']),
                        'debit'       => $purchase_data['tax'],
                        'credit'      => 0,
                        'trn_date'    => $purchase_data['trn_date'],
                        'created_at'  => $purchase_data['created_at'],
                        'created_by'  => $purchase_data['created_by'],
                        'updated_at'  => $purchase_data['updated_at'],
                        'updated_by'  => $purchase_data['updated_by'],
                    ]
                );
        }
    }

    /**
     * Update purchase/s data into ledger
     *
     * @param array $purchase_data
     * @param array $purchase_no
     *
     * @return mixed
     */
    function updatePurchaseDataIntoLedger($purchase_data, $purchase_no)
    {


        $ledger_map = \WeDevs\ERP\Accounting\Includes\Classes\Ledger_Map::get_instance();
        $ledger_id  = $ledger_map->get_ledger_id_by_slug('purchase');

        if (!$ledger_id) {
            return new WP_Error(505, 'Ledger ID not found for purchase', $purchase_data);
        }

        // insert contra `erp_acct_ledger_details`
        DB::table('erp_acct_ledger_details')
            ->where('trn_no', $purchase_no)
            ->update(

                [
                    'ledger_id'   => $ledger_id,
                    'particulars' => !empty($purchase_data['particulars']) ? $purchase_data['particulars'] : '',
                    'credit'      => $purchase_data['amount'],
                    'trn_date'    => $purchase_data['trn_date'],
                    'created_at'  => $purchase_data['created_at'],
                    'created_by'  => $purchase_data['created_by'],
                    'updated_at'  => $purchase_data['updated_at'],
                    'updated_by'  => $purchase_data['updated_by'],
                ]
            );
    }

    /**
     * Get Purchases count
     *
     * @return int
     */
    function getPurchaseCount()
    {


        $row = DB::select('SELECT COUNT(*) as count FROM ' . 'erp_acct_purchase');
        $row = (!empty($row)) ? $row[0] : null;
        return $row->count;
    }

    /**
     * Get due purchases by vendor
     *
     * @return mixed
     */
    function getDuePurchasesByVendor($args)
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

        if ('-1' !== $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $purchases            = "erp_acct_purchase";
        $purchase_act_details = "erp_acct_purchase_account_details";
        $items                = $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';

        $query = $wpdb->prepare(
            "SELECT $items FROM $purchases as purchase INNER JOIN
        (
            SELECT purchase_no, SUM( pa.debit - pa.credit) as due
            FROM $purchase_act_details as pa
            GROUP BY pa.purchase_no
            HAVING due <> 0
        ) as ps
        ON purchase.voucher_no = ps.purchase_no
        WHERE purchase.vendor_id = %d AND purchase.status != 1 AND purchase.purchase_order != 1
        ORDER BY %s %s $limit",
            $args['vendor_id'],
            $args['orderby'],
            $args['order']
        );

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        if ($args['count']) {
            return DB::scalar($query);
        }

        return DB::select($query, ARRAY_A);
    }

    /**
     * Get due of a purchase
     *
     * @param $purchase_no
     *
     * @return int
     */
    function getPurchaseDue($purchase_no)
    {


        $result = DB::select($wpdb->prepare("SELECT purchase_no, SUM( debit - credit) as due FROM erp_acct_purchase_account_details WHERE purchase_no = %d GROUP BY purchase_no", $purchase_no), ARRAY_A);
        $result = (!empty($result)) ? $result[0] : null;

        return $result['due'];
    }
}
