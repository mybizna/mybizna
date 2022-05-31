<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\Transactions;
use Modules\Account\Classes\People;
use Modules\Account\Classes\Taxes;

use Illuminate\Support\Facades\DB;

class Invoices
{
    /**
     * Get all invoices
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getAllInvoices($args = [])
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

        $where = '';
        $limit = '';

        if (!empty($args['start_date'])) {
            $where .= "WHERE invoice.trn_date BETWEEN '{$args['start_date']}' AND '{$args['end_date']}'";
        }

        if ('-1' === $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $sql = 'SELECT';

        if ($args['count']) {
            $sql .= ' COUNT( DISTINCT invoice.id ) as total_number';
        } else {
            $sql .= ' invoice.*, SUM(ledger_detail.credit) - SUM(ledger_detail.debit) as due';
        }

        $sql .= " FROM invoice AS invoice LEFT JOIN account_ledger_detail AS ledger_detail";
        $sql .= " ON invoice.voucher_no = ledger_detail.trn_no {$where} GROUP BY invoice.voucher_no ORDER BY invoice.{$args['orderby']} {$args['order']} {$limit}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        if ($args['count']) {
            return DB::scalar($sql);
        }

        return DB::select($sql);
    }

    /**
     * Get an single invoice
     *
     * @param int $invoice_no Invoices Number
     *
     * @return mixed
     */
    public function getInvoice($invoice_no)
    {
        $taxes = new Taxes();
        $common = new CommonFunc();

        $sql =
            "SELECT

            voucher.editable,
            voucher.currency,

            invoice.id,
            invoice.voucher_no,
            invoice.customer_id,
            invoice.customer_name,
            invoice.trn_date,
            invoice.due_date,
            invoice.billing_address,
            invoice.amount,
            invoice.discount,
            invoice.discount_type,
            invoice.shipping,
            invoice.shipping_tax,
            invoice.tax,
            invoice.tax_zone_id,
            invoice.estimate,
            invoice.attachments,
            invoice.status,
            invoice.particulars,
            invoice.created_at,

            inv_acc_detail.debit,
            inv_acc_detail.credit

        FROM invoice as invoice
        LEFT JOIN purchase_voucher_no as voucher ON invoice.voucher_no = voucher.id
        LEFT JOIN invoice_account_detail as inv_acc_detail ON invoice.voucher_no = inv_acc_detail.trn_no
        WHERE invoice.voucher_no = {$invoice_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select($sql);

        $row = (!empty($row)) ? $row[0] : null;


        $row['line_items']  = $this->formatInvoiceLineItems($invoice_no);

        $row['tax_rate_id'] = empty($row['tax_zone_id']) ? $taxes->getDefaultTaxRateNameId() : (int) $row['tax_zone_id'];

        // calculate every line total
        foreach ($row['line_items'] as $key => $value) {
            $total                                   = ($value['item_total'] + $value['tax']) - $value['discount'];
            $row['line_items'][$key]['line_total'] = $total;
        }

        $row['attachments'] = isset($row['attachments']) ? maybe_unserialize($row['attachments']) : null;
        $row['total_due']   = $this->getInvoiceDue($invoice_no);
        $row['pdf_link']    = $common->pdfAbsPathToUrl($invoice_no);

        return $row;
    }

    /**
     * Get formatted line items
     *
     * @param array $voucher_no Voucher Number
     *
     * @return array
     */
    public function formatInvoiceLineItems($voucher_no)
    {


        $sql =
            "SELECT
        inv_detail.product_id,
        inv_detail.qty,
        inv_detail.unit_price,
        inv_detail.discount,
        inv_detail.tax,
        inv_detail.item_total,
        inv_detail.ecommerce_type,

        SUM(inv_detail_tax.tax_rate) as tax_rate,

        product.name,
        product.product_type_id,
        product.category_id,
        product.vendor,
        product.cost_price,
        product.sale_price,
        product.tax_cat_id

        FROM invoice as invoice
        LEFT JOIN invoice_detail as inv_detail ON invoice.voucher_no = inv_detail.trn_no
        LEFT JOIN invoice_detail_tax as inv_detail_tax ON inv_detail.id = inv_detail_tax.invoice_details_id
        LEFT JOIN product as product ON inv_detail.product_id = product.id
        WHERE invoice.voucher_no = {$voucher_no} GROUP BY inv_detail.id";

        $results = DB::select($sql);

        if (!empty(reset($results)['ecommerce_type'])) {
            // product name should not fetch form `product`
            $results = array_map(
                function ($result) {
                    $result['name'] = get_the_title($result['product_id']);

                    return $result;
                },
                $results
            );
        }

        return $results;
    }

    /**
     * Insert invoice data
     *
     * @param arrray $data Data Filter
     *
     * @return int
     */
    public function insertInvoice($data)
    {

        $people = new People();
        $common = new CommonFunc();
        $trans = new Transactions();

        $user_id = auth()->user()->id;

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $user_id;

        $voucher_no    = null;
        $estimate_type = 1;
        $draft         = 1;
        $currency      = $common->getCurrency(true);
        $email         = $people->getPeopleEmail($data['customer_id']);

        try {
            DB::beginTransaction();

            $voucher_no =  DB::table('purchase_voucher_no')
                ->insertGetId(
                    [
                        'type'       => 'invoice',
                        'currency'   => $currency,
                        'editable'   => 1,
                        'created_at' => $data['created_at'],
                        'created_by' => $data['created_by'],
                    ]
                );


            $invoice_data = $this->getFormattedInvoiceData($data, $voucher_no);

            DB::table('invoice')
                ->insert(
                    [
                        'voucher_no'      => $invoice_data['voucher_no'],
                        'customer_id'     => $invoice_data['customer_id'],
                        'customer_name'   => $invoice_data['customer_name'],
                        'trn_date'        => $invoice_data['trn_date'],
                        'due_date'        => $invoice_data['due_date'],
                        'billing_address' => $invoice_data['billing_address'],
                        'amount'          => $invoice_data['amount'],
                        'discount'        => $invoice_data['discount'],
                        'discount_type'   => $invoice_data['discount_type'],
                        'shipping'        => $invoice_data['shipping'],
                        'shipping_tax'    => $invoice_data['shipping_tax'],
                        'tax'             => $invoice_data['tax'],
                        'tax_zone_id'     => $invoice_data['tax_rate_id'],
                        'estimate'        => $invoice_data['estimate'],
                        'attachments'     => $invoice_data['attachments'],
                        'status'          => $invoice_data['status'],
                        'particulars'     => $invoice_data['particulars'],
                        'created_at'      => $invoice_data['created_at'],
                        'created_by'      => $invoice_data['created_by'],
                    ]
                );

            $this->insertInvoiceDetailsAndTax($invoice_data, $voucher_no);

            if ($estimate_type === $invoice_data['estimate'] || $draft === $invoice_data['status']) {
                DB::commit();
                $estimate          = $this->getInvoice($voucher_no);
                $estimate['email'] = $email;
                do_action('new_transaction_estimate', $voucher_no, $estimate);

                return $estimate;
            }

            $this->insertInvoiceAccountDetails($invoice_data, $voucher_no);
            $this->insertInvoiceDataIntoLedger($invoice_data);

            do_action('after_sales_create', $data, $voucher_no);

            $data['dr'] = $invoice_data['amount'];
            $data['cr'] = 0;
            $trans->insertDataIntoPeopleTrnDetails($data, $voucher_no);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag('invoice-exception', $e->getMessage());
            return;
        }

        $invoice = $this->getInvoice($voucher_no);

        $invoice['email'] = $people->getPeopleEmail($data['customer_id']);

        do_action('new_transaction_sales', $voucher_no, $invoice);

        return $invoice;
    }

    /**
     * Insert line items and details on invoice create
     *
     * @param array   $invoice_data Data Filter
     * @param int     $voucher_no   Voucher Number
     * @param boolean $contra       Contra
     *
     * @return void
     */
    public function insertInvoiceDetailsAndTax($invoice_data, $voucher_no, $contra = false)
    {

        $common = new CommonFunc();

        $user_id = auth()->user()->id;

        $invoice_data['created_at'] = date('Y-m-d');
        $invoice_data['created_by'] = $user_id;
        $invoice_data['updated_at'] = date('Y-m-d');
        $invoice_data['updated_by'] = $user_id;

        $estimate_type      = 1;
        $draft              = 1;
        $tax_agency_details = [];

        $items = $invoice_data['line_items'];

        foreach ($items as $item) {
            $sub_total = $item['qty'] * $item['unit_price'];

            // insert into invoice details
            $details_id =   DB::table('invoice_detail')
                ->insertGetId(
                    [
                        'trn_no'         => $voucher_no,
                        'product_id'     => $item['product_id'],
                        'qty'            => $item['qty'],
                        'unit_price'     => $item['unit_price'],
                        'discount'       => $item['discount'],
                        'tax'            => $item['tax'],
                        'tax_cat_id'     => !empty($item['tax_cat_id']) ? $item['tax_cat_id'] : null,
                        'item_total'     => $sub_total,
                        'ecommerce_type' => !empty($item['ecommerce_type']) ? $item['ecommerce_type'] : null,
                        'created_at'     => $invoice_data['created_at'],
                        'created_by'     => $invoice_data['created_by'],
                    ]
                );


            if ($estimate_type === $invoice_data['estimate'] || $draft === $invoice_data['status']) {
                continue;
            }

            if (empty($invoice_data['tax_rate_id']) && empty($item['tax_cat_id'])) {
                $tax_rate_agency = !empty($item['tax_rate_agency']) ? $item['tax_rate_agency'] : null;
            } else {
                // calculate tax for every related agency
                $tax_rate_agency = $common->getTaxRateWithAgency($invoice_data['tax_rate_id'], $item['tax_cat_id']);
            }

            if (!empty($tax_rate_agency)) {
                foreach ($tax_rate_agency as $rate_agency) {
                    /*==== calculate tax amount ====*/
                    $tax_amount = ((float) $item['tax'] * (float) $rate_agency['tax_rate']) / (float) $item['tax_rate'];

                    if (array_key_exists($rate_agency['agency_id'], $tax_agency_details)) {
                        $tax_agency_details[$rate_agency['agency_id']] += $tax_amount;
                    } else {
                        $tax_agency_details[$rate_agency['agency_id']] = $tax_amount;
                    }

                    /*==== insert into invoice details tax ====*/
                    DB::table('invoice_detail_tax')
                        ->insert(
                            [
                                'invoice_details_id' => $details_id,
                                'agency_id'          => $rate_agency['agency_id'],
                                'tax_rate'           => $rate_agency['tax_rate'],
                                'tax_amount'         => $tax_amount,
                                'created_at'         => $invoice_data['created_at'],
                                'created_by'         => $invoice_data['created_by'],
                            ]
                        );
                }
            }
        }

        if (!empty($tax_agency_details)) {
            foreach ($tax_agency_details as $agency_id => $tax_agency_detail) {
                $debit = 0;
                $credit = 0;

                if ($contra) {
                    $debit = $tax_agency_detail;
                } else {
                    $credit = $tax_agency_detail;
                }

                DB::table('account_tax_agency_detail')
                    ->insert(
                        [
                            'agency_id'   => $agency_id,
                            'trn_no'      => $voucher_no,
                            'trn_date'    => $invoice_data['trn_date'],
                            'particulars' => 'sales',
                            'debit'       => $debit,
                            'credit'      => $credit,
                            'created_at'  => $invoice_data['created_at'],
                            'created_by'  => $invoice_data['created_by'],
                        ]
                    );
            }
        }
    }

    /**
     * Insert invoice account details
     *
     * @param array   $invoice_data Invoice Data
     * @param int     $voucher_no   Voucher Number
     * @param boolean $contra       Contra
     *
     * @return void
     */
    public function insertInvoiceAccountDetails($invoice_data, $voucher_no, $contra = false)
    {


        $user_id = auth()->user()->id;

        $invoice_data['created_at'] = date('Y-m-d H:i:s');
        $invoice_data['created_by'] = $user_id;
        $invoice_data['updated_at'] = date('Y-m-d H:i:s');
        $invoice_data['updated_by'] = $user_id;

        if ($contra) {
            $invoice_no = $invoice_data['voucher_no'];
            $debit      = 0;
            $credit     = ($invoice_data['amount'] - $invoice_data['discount']) + $invoice_data['tax'] + $invoice_data['shipping'] + $invoice_data['shipping_tax'];
        } else {
            $invoice_no = $voucher_no;
            $debit      = ($invoice_data['amount'] - $invoice_data['discount']) + $invoice_data['tax'] + $invoice_data['shipping'] + $invoice_data['shipping_tax'];
            $credit     = 0;
        }

        DB::table('invoice_account_detail')
            ->insert(
                [
                    'invoice_no'  => $invoice_no,
                    'trn_no'      => $voucher_no,
                    'trn_date'    => $invoice_data['trn_date'],
                    'particulars' => '',
                    'debit'       => $debit,
                    'credit'      => $credit,
                    'created_at'  => $invoice_data['created_at'],
                    'created_by'  => $invoice_data['created_by'],
                    'updated_at'  => $invoice_data['created_at'],
                    'updated_by'  => $invoice_data['created_by'],
                ]
            );
    }

    /**
     * Update invoice data
     *
     * @param array $data       Data Filter
     * @param int   $invoice_no Invoice Number
     *
     * @return int
     */
    public function updateInvoice($data, $invoice_no)
    {

        $common = new CommonFunc();
        $trans = new Transactions();

        if (1 === $data['estimate'] && $data['convert']) {
            $this->convertEstimateToInvoice($data, $invoice_no);

            return;
        }

        $user_id    = auth()->user()->id;
        $voucher_no = null;

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $user_id;

        $estimate_type = 1;
        $draft         = 1;
        $currency      = $common->getCurrency(true);

        try {
            DB::beginTransaction();

            if ($estimate_type === $data['estimate'] || $draft === $data['status']) {
                $this->updateDraftAndEstimate($data, $invoice_no);
            } else {
                // disable editing on old invoice
                DB::table('purchase_voucher_no')
                    ->where('id', $invoice_no)
                    ->update(['editable' => 0]);

                // insert contra voucher
                $voucher_no =  DB::table('purchase_voucher_no')
                    ->insertGetId(
                        [
                            'type'       => 'invoice',
                            'currency'   => $currency,
                            'editable'   => 0,
                            'created_at' => $data['created_at'],
                            'created_by' => $data['created_by'],
                            'updated_at' => $data['updated_at'],
                            'updated_by' => $data['updated_by'],
                        ]
                    );


                $old_invoice = $this->getInvoice($invoice_no);

                // insert contra `invoice` (basically a duplication of row)
                DB::statement("CREATE TEMPORARY TABLE acct_tmptable SELECT * FROM invoice WHERE voucher_no = %d", [$invoice_no]);
                DB::update(

                    "UPDATE acct_tmptable SET id = %d, voucher_no = %d, particulars = 'Contra entry for voucher no \#%d', created_at = '%s'",
                    [
                        0,
                        $voucher_no,
                        $invoice_no,
                        $data['created_at']
                    ]
                );
                DB::insert("INSERT INTO invoice SELECT * FROM acct_tmptable");
                DB::statement('DROP TABLE acct_tmptable');

                // change invoice status and other things
                $status_closed = 7;
                DB::update(
                    "UPDATE invoice SET status = %d, updated_at ='%s', updated_by = %d WHERE voucher_no IN (%d, %d)",
                    [
                        $status_closed,
                        $data['updated_at'],
                        $user_id,
                        $invoice_no,
                        $voucher_no
                    ]
                );

                // insert contra `invoice_detail` AND `invoice_detail_tax`
                $this->insertInvoiceDetailsAndTax($old_invoice, $voucher_no, true);

                // insert contra `invoice_account_detail`
                $this->insertInvoiceAccountDetails($old_invoice, $voucher_no, true);

                // insert contra `account_ledger_detail`
                $this->insertInvoiceDataIntoLedger($old_invoice, $voucher_no, true);

                // insert new invoice with edited data
                $new_invoice = $this->insertInvoice($data);

                do_action('after_sales_update', $data, $invoice_no);

                $data['dr'] = $data['amount'];
                $data['cr'] = 0;
                $trans->updateDataIntoPeopleTrnDetails($data, $old_invoice['voucher_no']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag('invoice-exception', $e->getMessage());
            return;
        }

        return $this->getInvoice($new_invoice['voucher_no']);
    }

    /**
     * Convert estimate to invoice
     *
     * @param array $data       Data Filter
     * @param int   $invoice_no Invoice Number
     *
     * @return array
     */
    public function convertEstimateToInvoice($data, $invoice_no)
    {

        $trans = new Transactions();
        $people = new People();

        $user_id  = auth()->user()->id;

        $data['created_at'] = date('Y-m-d');
        $data['created_by'] = $user_id;
        $data['updated_at'] = date('Y-m-d');
        $data['updated_by'] = $user_id;
        $data['estimate']   = 0;

        try {
            DB::beginTransaction();

            $invoice_data = $this->getFormattedInvoiceData($data, $invoice_no);

            DB::table('invoice')
                ->where('voucher_no', $invoice_no)
                ->update(
                    [
                        'customer_id'     => $invoice_data['customer_id'],
                        'customer_name'   => $invoice_data['customer_name'],
                        'trn_date'        => $invoice_data['trn_date'],
                        'due_date'        => $invoice_data['due_date'],
                        'billing_address' => $invoice_data['billing_address'],
                        'amount'          => $invoice_data['amount'],
                        'discount'        => $invoice_data['discount'],
                        'discount_type'   => $invoice_data['discount_type'],
                        'shipping'        => $invoice_data['shipping'],
                        'shipping_tax'    => $invoice_data['shipping_tax'],
                        'tax'             => $invoice_data['tax'],
                        'estimate'        => false,
                        'attachments'     => $invoice_data['attachments'],
                        'status'          => 2,
                        'particulars'     => $invoice_data['particulars'],
                        'created_at'      => $invoice_data['created_at'],
                        'created_by'      => $invoice_data['created_by'],
                    ]
                );

            DB::table('invoice_detail')->where([['trn_no' => $invoice_no]])->delete();

            // insert data into invoice_details
            $this->insertInvoiceDetailsAndTax($invoice_data, $invoice_no);

            $this->insertInvoiceAccountDetails($invoice_data, $invoice_no);

            $this->insertInvoiceDataIntoLedger($invoice_data, $invoice_no);

            do_action('after_sales_create', $data, $invoice_no);

            $data['dr'] = $invoice_data['amount'];
            $data['cr'] = 0;
            $trans->insertDataIntoPeopleTrnDetails($data, $invoice_no);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag('invoice-exception', $e->getMessage());
            return;
        }

        $invoice = $this->getInvoice($invoice_no);

        $invoice['email'] = $people->getPeopleEmail($data['customer_id']);

        do_action('new_transaction_sales', $invoice_no, $invoice);

        return $invoice;
    }

    /**
     * Update draft & estimate
     *
     * @param array $data       Data Filter
     * @param int   $invoice_no Invoice Number
     *
     * @return void
     */
    public function updateDraftAndEstimate($data, $invoice_no)
    {


        $invoice_data = $this->getFormattedInvoiceData($data, $invoice_no);

        DB::table('invoice')
            ->where('voucher_no', $invoice_no)
            ->update(
                [
                    'customer_id'     => $invoice_data['customer_id'],
                    'customer_name'   => $invoice_data['customer_name'],
                    'trn_date'        => $invoice_data['trn_date'],
                    'due_date'        => $invoice_data['due_date'],
                    'billing_address' => $invoice_data['billing_address'],
                    'amount'          => $invoice_data['amount'],
                    'discount'        => $invoice_data['discount'],
                    'discount_type'   => $invoice_data['discount_type'],
                    'shipping'        => $invoice_data['shipping'],
                    'shipping_tax'    => $invoice_data['shipping_tax'],
                    'tax'             => $invoice_data['tax'],
                    'estimate'        => $invoice_data['estimate'],
                    'attachments'     => $invoice_data['attachments'],
                    'status'          => $invoice_data['status'],
                    'particulars'     => $invoice_data['particulars'],
                    'updated_at'      => $invoice_data['updated_at'],
                    'updated_by'      => $invoice_data['updated_by'],
                ]
            );

        /*
     *? We can't update `invoice_details` directly
     *? suppose there were 5 detail rows previously
     *? but on update there may be 2 detail rows
     *? that's why we can't update because the foreach will iterate only 2 times, not 5 times
     *? so, remove previous rows to insert new rows
     */
        DB::table('invoice_detail')->where([['trn_no' => $invoice_no]])->delete();

        $this->insertInvoiceDetailsAndTax($invoice_data, $invoice_no);
    }

    /**
     * Get formatted invoice data
     *
     * @param array $data       Data Filter
     * @param int   $voucher_no Voucher Number
     *
     * @return mixed
     */
    public function getFormattedInvoiceData($data, $voucher_no)
    {
        $people = new People();
        $invoice_data = [];

        // We can pass the name from view... to reduce DB query load
        if (empty($data['customer_name'])) {
            $customer      = $people->getPeople($data['customer_id']);
            $customer_name = $customer->first_name . ' ' . $customer->last_name;
        } else {
            $customer_name = $data['customer_name'];
        }

        $invoice_data['voucher_no']      = !empty($voucher_no) ? $voucher_no : 0;
        $invoice_data['customer_id']     = isset($data['customer_id']) ? $data['customer_id'] : null;
        $invoice_data['customer_name']   = $customer_name;
        $invoice_data['trn_date']        = isset($data['date']) ? $data['date'] : date('Y-m-d');
        $invoice_data['due_date']        = isset($data['due_date']) ? $data['due_date'] : date('Y-m-d');
        $invoice_data['billing_address'] = isset($data['billing_address']) ? maybe_serialize($data['billing_address']) : '';
        $invoice_data['amount']          = isset($data['amount']) ? $data['amount'] : 0;
        $invoice_data['discount']        = isset($data['discount']) ? $data['discount'] : 0;
        $invoice_data['discount_type']   = isset($data['discount_type']) ? $data['discount_type'] : null;
        $invoice_data['shipping']        = isset($data['shipping']) ? $data['shipping'] : 0;
        $invoice_data['shipping_tax']    = isset($data['shipping_tax']) ? $data['shipping_tax'] : 0;
        $invoice_data['tax_rate_id']     = isset($data['tax_rate_id']) ? $data['tax_rate_id'] : 0;
        $invoice_data['line_items']      = isset($data['line_items']) ? $data['line_items'] : [];
        $invoice_data['trn_by']          = isset($data['trn_by']) ? $data['trn_by'] : '';
        $invoice_data['tax']             = isset($data['tax']) ? $data['tax'] : 0;
        $invoice_data['attachments']     = !empty($data['attachments']) ? $data['attachments'] : '';
        $invoice_data['status']          = isset($data['status']) ? $data['status'] : 1;
        $invoice_data['particulars']     = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Invoice created with voucher no %s'), $voucher_no);
        $invoice_data['estimate']        = isset($data['estimate']) ? $data['estimate'] : 0;
        $invoice_data['created_at']      = isset($data['created_at']) ? $data['created_at'] : null;
        $invoice_data['created_by']      = isset($data['created_by']) ? $data['created_by'] : null;
        $invoice_data['updated_at']      = isset($data['updated_at']) ? $data['updated_at'] : null;
        $invoice_data['updated_by']      = isset($data['updated_by']) ? $data['updated_by'] : null;

        $draft   = 1;
        $pending = 3;

        if (!empty($data['estimate']) && $data['status'] !== $draft) {
            $invoice_data['status'] = $pending;
        }

        return $invoice_data;
    }

    /**
     * Void an invoice
     *
     * @param int $invoice_no Invoice Number
     *
     * @return void
     */
    public function voidInvoice($invoice_no)
    {


        if (!$invoice_no) {
            return;
        }

        DB::table('invoice')
            ->where('voucher_no', $invoice_no)
            ->update(
                [
                    'status' => 8,
                ]
            );

        DB::table('account_ledger_detail')->where([['trn_no' => $invoice_no]])->delete();
        DB::table('invoice_account_detail')->where([['invoice_no' => $invoice_no]])->delete();

        $results = DB::select(
            "SELECT
            inv_detail_tax.id
            FROM invoice_detail_tax as inv_detail_tax
            LEFT JOIN invoice_detail as inv_detail ON inv_detail_tax.invoice_details_id = inv_detail.id
            LEFT JOIN invoice as invoice ON inv_detail.trn_no = invoice.voucher_no
            WHERE inv_detail.trn_no = {$invoice_no}"
        );

        foreach ($results as $result) {
            DB::table('invoice_detail_tax')->where([['id' => $result['id']]])->delete();
        }

        DB::table('account_tax_agency_detail')->where([['trn_no' => $invoice_no]])->delete();
    }

    /**
     * Insert invoice/s data into ledger
     *
     * @param array   $invoice_data Invoice Data
     * @param int     $voucher_no   Voucher Number
     * @param boolean $contra       Contra
     *
     * @return mixed
     */
    public function insertInvoiceDataIntoLedger($invoice_data, $voucher_no = 0, $contra = false)
    {


        $user_id = auth()->user()->id;
        $date    = date('Y-m-d H:i:s');


        $sales_ledger_id              = get_ledger_id_by_slug('sales_revenue');
        $sales_discount_ledger_id     = get_ledger_id_by_slug('sales_discount');
        $sales_shipping_ledger_id     =get_ledger_id_by_slug('shipment');
        $sales_shipping_tax_ledger_id = get_ledger_id_by_slug('shipment_tax');

        if ($contra) {
            $sales_credit        = 0;
            $discount_debit      = 0;
            $shipment_credit     = 0;
            $shipment_tax_credit = 0;

            $trn_no              = $voucher_no;
            $sales_debit         = $invoice_data['amount'];
            $discount_credit     = $invoice_data['discount'];
            $shipment_debit      = $invoice_data['shipping'];
            $shipment_tax_debit  = $invoice_data['shipping_tax'];
        } else {
            $sales_debit         = 0;
            $discount_credit     = 0;
            $shipment_debit      = 0;
            $shipment_tax_debit  = 0;

            $trn_no              = $invoice_data['voucher_no'];
            $sales_credit        = $invoice_data['amount'];
            $discount_debit      = $invoice_data['discount'];
            $shipment_credit     = $invoice_data['shipping'];
            $shipment_tax_credit = $invoice_data['shipping_tax'];
        }

        // insert amount in ledger_details
        DB::table('account_ledger_detail')
            ->insert(
                [
                    'ledger_id'   => $sales_ledger_id,
                    'trn_no'      => $trn_no,
                    'particulars' => $invoice_data['particulars'],
                    'debit'       => $sales_debit,
                    'credit'      => $sales_credit,
                    'trn_date'    => $invoice_data['trn_date'],
                    'created_at'  => $date,
                    'created_by'  => $user_id,
                    'updated_at'  => $date,
                    'updated_by'  => $user_id,
                ]
            );

        // insert discount in ledger_details
        if ((float) $discount_debit > 0 || (float) $discount_credit > 0) {
            DB::table('account_ledger_detail')
                ->insert(
                    [
                        'ledger_id'   => $sales_discount_ledger_id,
                        'trn_no'      => $trn_no,
                        'particulars' => $invoice_data['particulars'],
                        'debit'       => $discount_debit,
                        'credit'      => $discount_credit,
                        'trn_date'    => $invoice_data['trn_date'],
                        'created_at'  => $date,
                        'created_by'  => $user_id,
                        'updated_at'  => $date,
                        'updated_by'  => $user_id,
                    ]
                );
        }

        // insert shipping in ledger_details
        if ((float) $shipment_debit > 0 || (float) $shipment_credit > 0) {
            DB::table('account_ledger_detail')
                ->insert(
                    [
                        'ledger_id'   => $sales_shipping_ledger_id,
                        'trn_no'      => $trn_no,
                        'particulars' => $invoice_data['particulars'],
                        'debit'       => $shipment_debit,
                        'credit'      => $shipment_credit,
                        'trn_date'    => $invoice_data['trn_date'],
                        'created_at'  => $date,
                        'created_by'  => $user_id,
                        'updated_at'  => $date,
                        'updated_by'  => $user_id,
                    ]
                );
        }

        // insert shipping tax in ledger_details
        if ((float) $shipment_tax_debit > 0 || (float) $shipment_tax_credit > 0) {
            DB::table('account_ledger_detail')
                ->insert(
                    [
                        'ledger_id'   => $sales_shipping_tax_ledger_id,
                        'trn_no'      => $trn_no,
                        'particulars' => $invoice_data['particulars'],
                        'debit'       => $shipment_tax_debit,
                        'credit'      => $shipment_tax_credit,
                        'trn_date'    => $invoice_data['trn_date'],
                        'created_at'  => $date,
                        'created_by'  => $user_id,
                        'updated_at'  => $date,
                        'updated_by'  => $user_id,
                    ]
                );
        }
    }

    /**
     * Update invoice/s data into ledger
     *
     * @param array $invoice_data Invoice Data
     * @param int   $invoice_no   Invoice Number
     *
     * @return mixed
     */
    public function updateInvoiceDataInLedger($invoice_data, $invoice_no)
    {


        // Update amount in ledger_details
        DB::table('account_ledger_detail')
            ->where('trn_no', $invoice_no)
            ->update(
                [
                    'particulars' => $invoice_data['particulars'],
                    'credit'      => $invoice_data['amount'],
                    'trn_date'    => $invoice_data['trn_date'],
                    'updated_at'  => $invoice_data['updated_at'],
                    'updated_by'  => $invoice_data['updated_by'],
                ]
            );

        // Update discount in ledger_details
        DB::table('account_ledger_detail')
            ->where('trn_no', $invoice_no)
            ->update(
                [
                    'particulars' => $invoice_data['particulars'],
                    'debit'       => $invoice_data['discount'],
                    'trn_date'    => $invoice_data['trn_date'],
                    'updated_at'  => $invoice_data['updated_at'],
                    'updated_by'  => $invoice_data['updated_by'],
                ]
            );
    }

    /**
     * Get Invoice count
     *
     * @return int
     */
    public function getInvoiceCount()
    {


        $row = DB::select('SELECT COUNT(*) as count FROM ' . 'invoice');

        $row = (!empty($row)) ? $row[0] : null;

        return $row->count;
    }

    /**
     * Receive payments with due from a customer
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function receivePaymentsFromCustomer($args = [])
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

        if ('-1' === $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $invoices            = "invoice";
        $invoice_act_details = "invoice_account_detail";
        $items               = $args['count'] ? ' COUNT( id ) as total_number ' : ' id, voucher_no, due_date, (amount + tax - discount) as amount, invs.due as due ';

        $query =
            "SELECT $items FROM $invoices as invoice INNER JOIN
        (SELECT invoice_no, SUM( ia.debit - ia.credit) as due
        FROM $invoice_act_details as ia
        GROUP BY ia.invoice_no
        HAVING due <> 0) as invs
        ON invoice.voucher_no = invs.invoice_no
        WHERE invoice.customer_id = {$args['people_id']} AND invoice.status != 1 AND invoice.estimate != 1
        ORDER BY {$args['orderby']} {$args['order']} $limit";

        if ($args['count']) {
            return DB::scalar($query);
        }

        return DB::select($query);
    }

    /**
     * Get due of a bill
     *
     * @param int $invoice_no Invoice Number
     *
     * @return int
     */
    public function getDuePayment($invoice_no)
    {


        $result = DB::select("SELECT invoice_no, SUM( ia.debit - ia.credit) as due FROM invoice_account_detail as ia WHERE ia.invoice_no = %d GROUP BY ia.invoice_no", [$invoice_no]);

        $result = (!empty($result)) ? $result[0] : null;


        return $result['due'];
    }

    /**
     * Get recievables from given date
     *
     * @param string $from From
     * @param string $to   To
     *
     * @return array|object|null
     */
    public function getRecievables($from, $to)
    {


        $from_date = date('Y-m-d', strtotime($from));
        $to_date   = date('Y-m-d', strtotime($to));

        $invoices              = 'invoice';
        $invoices_acct_details = 'invoice_account_detail';

        $query =
            "Select voucher_no, SUM(ad.debit - ad.credit) as due, due_date
        FROM $invoices LEFT JOIN $invoices_acct_details as ad
        ON ad.invoice_no = voucher_no  where due_date
        BETWEEN {$from_date} and {$to_date} Group BY voucher_no Having due > 0 ";

        $results = DB::select($query);

        return $results;
    }

    /**
     * Get Dashboard Overview details
     *
     * @return array
     */
    public function getRecievablesOverview()
    {
        // get dates till coming 90 days
        $from_date = date('Y-m-d');
        $to_date   = date('Y-m-d', strtotime('+90 day', strtotime($from_date)));

        $data   = [];
        $amount = [
            'first'  => 0,
            'second' => 0,
            'third'  => 0,
        ];

        $result = $this->getRecievables($from_date, $to_date);

        if (!empty($result)) {
            $from_date = new \DateTime($from_date);

            foreach ($result as $item_data) {
                $item  = (object) $item_data;
                $later = new \DateTime($item->due_date);
                $diff  = $later->diff($from_date)->format('%a');

                //segment by date difference
                switch ($diff) {
                    case $diff === 0:
                        $data['first'][] = $item_data;
                        $amount['first'] = $amount['first'] + $item->due;
                        break;

                    case $diff <= 30:
                        $data['first'][] = $item_data;
                        $amount['first'] = $amount['first'] + $item->due;
                        break;

                    case $diff <= 60:
                        $data['second'][] = $item_data;
                        $amount['second'] = $amount['second'] + $item->due;
                        break;

                    case $diff <= 90:
                        $data['third'][] = $item_data;
                        $amount['third'] = $amount['third'] + $item->due;
                        break;

                    default:
                }
            }
        }

        return [
            'data'   => $data,
            'amount' => $amount,
        ];
    }

    /**
     * Get due of an invoice
     *
     * @param int $invoice_no Invoice Number
     *
     * @return int
     */
    public function getInvoiceDue($invoice_no)
    {


        $result = DB::select(
            "SELECT ia.invoice_no, SUM( ia.debit - ia.credit) as due
            FROM invoice_account_detail as ia
            WHERE ia.invoice_no = %d
            GROUP BY ia.invoice_no",
            [$invoice_no]
        );

        $result = (!empty($result)) ? $result[0] : null;

        return $result['due'];
    }

    /**
     * Retrieves tax zone of an invoice
     *
     * @param int $invoice_no Invoice Number
     *
     * @return int|string
     */
    public function getInvoiceTaxZone($invoice_no)
    {


        $tax_zone = DB::scalar(
            "SELECT tax_zone_id FROM invoice WHERE voucher_no = %d",
            [(int) $invoice_no]
        );

        return $tax_zone;
    }
}
