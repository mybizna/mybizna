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
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getPurchases($args = [])
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
        $sql .= "FROM purchase ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            return DB::scalar($sql);
        }

        return DB::select($sql);
    }

    /**
     * Get a purchase
     *
     * @param int $purchase_no Purchase Number
     *
     * @return mixed
     */
    public function getPurchase($purchase_no)
    {

        $common = new CommonFunc();

        $sql =
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

        FROM purchase AS purchase
        LEFT JOIN purchase_voucher_no as voucher ON purchase.voucher_no = voucher.id
        LEFT JOIN purchase_account_details AS purchase_acc_detail ON purchase.voucher_no = purchase_acc_detail.trn_no
        WHERE purchase.voucher_no = " + $purchase_no;

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row                = DB::select($sql);
        $row = (!empty($row)) ? $row[0] : null;
        $row['line_items']  = $this->formatPurchaseLineItems($purchase_no);
        $row['attachments'] = unserialize($row['attachments']);
        $row['total_due']   = $row['credit'] - $row['debit'];
        $row['pdf_link']    = $common->pdfAbsPathToUrl($purchase_no);

        return $row;
    }

    /**
     * Purchase items detail
     *
     * @param int $voucher_no Voucher Number
     *
     * @return array|object|null
     */
    public function formatPurchaseLineItems($voucher_no)
    {


        $sql =
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

        FROM purchase AS purchase
        LEFT JOIN purchase_details AS purchase_detail ON purchase.voucher_no = purchase_detail.trn_no
        LEFT JOIN product AS product ON purchase_detail.product_id = product.id
        WHERE purchase.voucher_no = " + $voucher_no;

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $results = DB::select($sql);

        // calculate every line total
        foreach ($results as $key => $value) {
            $results[$key]['line_total'] = $value['amount'];
        }

        return $results;
    }

    /**
     * Insert a purchase
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function insertPurchase($data)
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
            DB::beginTransaction();

            $voucher_no    = DB::table('purchase_voucher_no')
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

            DB::table('purchase')
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
                $details_id = DB::table('purchase_details')
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
                        DB::table('purchase_details_tax')
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

            do_action('after_purchase_create', $data, $voucher_no);

            $email = $people->getPeopleEmail($purchase_data['vendor_id']);

            if ($purchase_type_order === $purchase_data['purchase_order'] || $draft === $purchase_data['status']) {
                DB::commit();
                $purchase_order          = $this->getPurchases($voucher_no);
                $purchase_order['email'] = $email;
                do_action('new_transaction_purchase_order', $voucher_no, $purchase_order);

                return $purchase_order;
            }

            DB::table('purchase_account_details')
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
            $data['particulars'] = __('Purchase Total');

            $trans->insertDataIntoPeopleTrnDetails($data, $voucher_no);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag('purchase-exception', $e->getMessage());
            return;
        }

        $purchase = $this->getPurchases($purchase_no);

        $purchase['email'] = $email;

        do_action('new_transaction_purchase', $voucher_no, $purchase);


        return $purchase;
    }

    /**
     * Update a purchase
     *
     * @param array $purchase_data Purchase Data
     * @param int   $purchase_id   Purchase ID
     *
     * @return mixed
     */
    public function updatePurchase($purchase_data, $purchase_id)
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
            DB::beginTransaction();

            if ($purchase_type_order === $purchase_data['purchase_order'] || $draft === $purchase_data['status']) {
                $purchase_data = $this->getFormattedPurchaseData($purchase_data, $purchase_id);

                DB::table('purchase')
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
                $prev_detail_ids = DB::select("SELECT id FROM purchase_details WHERE trn_no = ?", [$purchase_id]);

                $prev_detail_ids = implode(',', array_map('absint', $prev_detail_ids));

                DB::table('purchase_details')->where([['trn_no' => $purchase_id]])->delete();

                DB::delete("DELETE FROM purchase_details_tax WHERE invoice_details_id IN($prev_detail_ids)"); // delete previous tax data

                $items = $purchase_data['purchase_details'];

                foreach ($items as $key => $item) {
                    $tmp_purchase_details = DB::table('purchase_details')
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

                    $details_id = $tmp_purchase_details;

                    if (isset($purchase_data['tax_rate'])) {
                        $tax_rate_agency = $common->getTaxRateWithAgency($purchase_data['tax_rate']['id'], $item['tax_cat_id']);

                        foreach ($tax_rate_agency as $tra) {
                            DB::table('purchase_details_tax')
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

                DB::commit();

                return $this->getPurchases($purchase_id);
            } else {
                // disable editing on old bill
                DB::table('purchase_voucher_no')
                    ->where('id', $purchase_id)
                    ->update(['editable' => 0]);
                // insert contra voucher
                $voucher_no =  DB::table('purchase_voucher_no')
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

                // insert contra `purchase` (basically a duplication of row)
                DB::statement("CREATE TEMPORARY TABLE acct_tmptable SELECT * FROM purchase WHERE voucher_no = ?", [$purchase_id]);
                DB::update(
                    "UPDATE acct_tmptable SET id = ?, voucher_no = ?, particulars = ?, created_at = ?",
                    [
                        0,
                        $voucher_no,
                        'Contra entry for voucher no \#' . $purchase_id,
                        $data['created_at']
                    ]
                );
                DB::insert("INSERT INTO purchase SELECT * FROM acct_tmptable");
                DB::statement('DROP TABLE acct_tmptable');

                // change purchase status and other things
                $status_closed = 7;
                DB::update(
                    "UPDATE purchase SET status = ?, updated_at =?, updated_by = ? WHERE voucher_no IN (?, ?)",
                    [
                        $status_closed,
                        $data['updated_at'],
                        $user_id,
                        $purchase_id,
                        $voucher_no
                    ]
                );

                $items = $old_purchase['line_items'];

                foreach ($items as $key => $item) {
                    DB::table('purchase_details')
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

                DB::table('purchase_account_details')
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

                do_action('after_purchase_update', $purchase_data, $purchase_id);

                $this->updatePurchaseDataIntoLedger($items, $purchase_id);

                $new_purchase = $this->insertPurchase($purchase_data);

                $data['dr'] = 0;
                $data['cr'] = $purchase_data['amount'];
                $trans->updateDataIntoPeopleTrnDetails($data, $old_purchase['voucher_no']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag('purchase-exception', $e->getMessage());
            return;
        }


        return $this->getPurchases($new_purchase['voucher_no']);
    }

    /**
     * Convert order to purchase
     *
     * @param array $purchase_data Purchase Data
     * @param int   $purchase_id   Purchase Id
     *
     * @return array
     */
    public function convertOrderToPurchase($purchase_data, $purchase_id)
    {

        $people = new People();
        $trans = new Transactions();

        $user_id = auth()->user()->id;

        try {
            DB::beginTransaction();

            $purchase_data = $this->getFormattedPurchaseData($purchase_data, $purchase_id);

            // purchase
            DB::table('purchase')
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
            DB::table('purchase_details')->where([['trn_no' => $purchase_id]])->delete();

            foreach ($purchase_data['line_items'] as $item) {
                DB::table('purchase_details', [
                    'trn_no'     => $purchase_id,
                    'product_id' => $item['product_id'],
                    'qty'        => $item['qty'],
                    'price'      => $item['unit_price'],
                    'amount'     => (float) $item['qty'] * (float) $item['unit_price'],
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => $user_id,
                ]);
            }

            DB::table('purchase_account_details', [
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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag('purchase-exception', $e->getMessage());
            return;
        }

        $purchase = $this->getPurchases($purchase_id);

        $purchase['email'] = $people->getPeopleEmail($purchase['vendor_id']);

        do_action('new_transaction_purchase', $purchase_id, $purchase);


        return $purchase;
    }

    /**
     * Void a purchase
     *
     * @param int $id Id
     *
     * @return void
     */
    public function voidPurchase($id)
    {


        if (!$id) {
            return;
        }

        DB::table('purchase')
            ->where('voucher_no', $id)
            ->update(
                [
                    'status' => 8,
                ]
            );

        DB::table('account_ledger_detail')->where([['trn_no' => $id]])->delete();
        DB::table('purchase_account_details')->where([['purchase_no' => $id]])->delete();
    }

    /**
     * Get formatted purchase data
     *
     * @param array $data       Data Filter
     * @param int   $voucher_no Voucher Number
     *
     * @return mixed
     */
    public function getFormattedPurchaseData($data, $voucher_no)
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
        $purchase_data['particulars'] = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Purchase created with voucher no %s'), $voucher_no);
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
     * @param array $purchase_data Purchase Data Filter
     *
     * @return mixed
     */
    public function insertPurchaseDataIntoLedger($purchase_data)
    {


        $purchase_ledger_id  = get_ledger_id_by_slug('purchase');

        if (!$purchase_ledger_id) {
            messageBag('Ledger ID not found for purchase', $purchase_data);
            return;
        }

        $purchase_data['tax'] = $purchase_data['tax'] ? (int) $purchase_data['tax'] : 0;

        // Insert amount in ledger_details
        DB::table('account_ledger_detail')
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
            $purchase_vat_ledger_id = get_ledger_id_by_slug('purchase_vat');
            if (!$purchase_vat_ledger_id) {
                messageBag('500', __('Ledger ID not found for purchase vat'), $purchase_data);
                return;
            }

            // Insert amount in ledger_details
            DB::table('account_ledger_detail')
                ->insert(
                    [
                        'ledger_id'   => $purchase_vat_ledger_id,
                        'trn_no'      => $purchase_data['voucher_no'],
                        'particulars' => sprintf(__('Purchase Vat of voucher no- %1$s'), $purchase_data['voucher_no']),
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
     * @param array $purchase_data Purchase Data Filter
     * @param array $purchase_no   Purchase Number
     *
     * @return mixed
     */
    public function updatePurchaseDataIntoLedger($purchase_data, $purchase_no)
    {


        $ledger_id  = get_ledger_id_by_slug('purchase');

        if (!$ledger_id) {
            messageBag('505', 'Ledger ID not found for purchase', $purchase_data);
        }

        // insert contra `account_ledger_detail`
        DB::table('account_ledger_detail')
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
    public function getPurchaseCount()
    {


        $row = DB::select('SELECT COUNT(*) as count FROM ' . 'purchase');
        $row = (!empty($row)) ? $row[0] : null;
        return $row->count;
    }

    /**
     * Get due purchases by vendor
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getDuePurchasesByVendor($args)
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

        $purchases            = "purchase";
        $purchase_act_details = "purchase_account_details";
        $items                = $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';

        $query =
            "SELECT $items FROM $purchases as purchase INNER JOIN
        (
            SELECT purchase_no, SUM( pa.debit - pa.credit) as due
            FROM $purchase_act_details as pa
            GROUP BY pa.purchase_no
            HAVING due <> 0
        ) as ps
        ON purchase.voucher_no = ps.purchase_no
        WHERE purchase.vendor_id = {$args['vendor_id']} AND purchase.status != 1 AND purchase.purchase_order != 1
        ORDER BY {$args['orderby']} {$args['order']} $limit";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        if ($args['count']) {
            return DB::scalar($query);
        }

        return DB::select($query);
    }

    /**
     * Get due of a purchase
     *
     * @param int $purchase_no Purchase Number
     *
     * @return int
     */
    public function getPurchaseDue($purchase_no)
    {


        $result = DB::select("SELECT purchase_no, SUM( debit - credit) as due FROM purchase_account_details WHERE purchase_no = ? GROUP BY purchase_no", [$purchase_no]);
        $result = (!empty($result)) ? $result[0] : null;

        return $result['due'];
    }
}
