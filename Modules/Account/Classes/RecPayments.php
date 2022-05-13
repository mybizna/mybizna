<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;

use Modules\Account\Classes\People;
use Modules\Account\Classes\Invoices;
use Modules\Account\Classes\Bank;

use Illuminate\Support\Facades\DB;

class RecPayments
{
    /**
     * Get all payments
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getPayments($args = [])
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

        $sql  = 'SELECT';
        $sql .= $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';
        $sql .= "FROM erp_acct_invoice_receipts ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            return DB::scalar($sql);
        }

        $payment_data = DB::select($sql);

        return $payment_data;
    }

    /**
     * Get a single payment
     *
     * @param int $invoice_no Invoice Number
     *
     * @return mixed
     */
    public function getPayment($invoice_no)
    {

        $common = new CommonFunc();

        $sql = "SELECT
                pay_inv.id,
                pay_inv.voucher_no,
                pay_inv.customer_id,
                pay_inv.customer_name,
                pay_inv.trn_date,
                pay_inv.amount,
                pay_inv.trn_by,
                pay_inv.ref,
                pay_inv.trn_by_ledger_id,
                pay_inv.particulars,
                pay_inv.attachments,
                pay_inv.status,
                pay_inv.created_at,
                pay_inv.transaction_charge,

                pay_inv_detail.invoice_no,
                pay_inv_detail.amount as pay_inv_detail_amount,

                ledger_detail.particulars,
                ledger_detail.debit,
                ledger_detail.credit

            from erp_acct_invoice_receipts as pay_inv

            LEFT JOIN erp_acct_invoice_receipts_details as pay_inv_detail ON pay_inv.voucher_no = pay_inv_detail.voucher_no
            LEFT JOIN erp_acct_ledger_details as ledger_detail ON pay_inv.voucher_no = ledger_detail.trn_no

            WHERE pay_inv.voucher_no = {$invoice_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select($sql);
        $row = (!empty($row)) ? $row[0] : null;

        $row['line_items'] = $this->formatPaymentLineItems($invoice_no);
        $row['pdf_link']   = $common->pdfAbsPathToUrl($invoice_no);

        return $row;
    }

    /**
     * Insert payment info
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function insertPayment($data)
    {

        $common = new CommonFunc();
        $people = new People();
        $trans = new Transactions();
        $bank = new Bank();

        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;
        $voucher_no         = null;
        $currency           = $common->getCurrency(true);

        try {
            DB::beginTransaction();

            if (floatval($data['amount']) < 0) {
                $trn_type = 'return_payment';
            } else {
                $trn_type = 'payment';
            }

            $voucher_no =  DB::table('erp_acct_voucher_no')
                ->insertGetId(
                    [
                        'type'       => $trn_type,
                        'currency'   => $currency,
                        'created_at' => $data['created_at'],
                        'created_by' => $data['created_by'],
                        'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : '',
                        'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : '',
                    ]
                );


            $payment_data = $this->getFormattedPaymentData($data, $voucher_no);

            // check transaction charge
            $transaction_charge = 0;

            if (isset($payment_data['bank_trn_charge']) && 0 < (float) $payment_data['bank_trn_charge'] && 2 === (int) $payment_data['trn_by']) {
                $transaction_charge = (float) $payment_data['bank_trn_charge'];
            }

            DB::table('erp_acct_invoice_receipts')
                ->insert(
                    [
                        'voucher_no'         => $voucher_no,
                        'customer_id'        => $payment_data['customer_id'],
                        'customer_name'      => $payment_data['customer_name'],
                        'trn_date'           => $payment_data['trn_date'],
                        'particulars'        => $payment_data['particulars'],
                        'amount'             => abs(floatval($payment_data['amount'])),
                        'transaction_charge' => $transaction_charge,
                        'ref'                => $payment_data['ref'],
                        'trn_by'             => $payment_data['trn_by'],
                        'attachments'        => $payment_data['attachments'],
                        'status'             => $payment_data['status'],
                        'trn_by_ledger_id'   => $payment_data['trn_by_ledger_id'],
                        'created_at'         => $payment_data['created_at'],
                        'created_by'         => $payment_data['created_by'],
                        'updated_at'         => $payment_data['updated_at'],
                        'updated_by'         => $payment_data['updated_by'],
                    ]
                );

            $items = $payment_data['line_items'];

            foreach ($items as $key => $item) {
                $total              = 0;
                $invoice_no[$key] = $payment_data['invoice_no'];
                $total += $item['line_total'];

                $payment_data['amount'] = $total;

                $this->insertPaymentLineItems($payment_data, $item, $voucher_no);
            }

            if (isset($payment_data['trn_by']) && 3 === $payment_data['trn_by']) {
                $common->insertCheckData($payment_data);
            }

            // add transaction charge entry to ledger
            if ($transaction_charge) {
                $common->insertBankTransactionChargeIntoLedger($payment_data);
            }

            $data['dr'] = 0;
            $data['cr'] = 0;

            if (floatval($payment_data['amount']) < 0) {
                $data['dr'] = abs(floatval($payment_data['amount']));
            } else {
                $data['cr'] = $payment_data['amount'];
            }

            $trans->insertDataIntoPeopleTrnDetails($data, $voucher_no);

            do_action('erp_acct_after_payment_create', $payment_data, $voucher_no);


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('payment-exception', $e->getMessage());
            return;
        }

        foreach ($items as $key => $item) {
            $this->changeInvoiceStatus($item['invoice_no']);
        }

        $payment = $this->getPayment($voucher_no);

        $payment['email'] = $people->getPeopleEmail($data['customer_id']);

        do_action('erp_acct_new_transaction_payment', $voucher_no, $payment);

        return $payment;
    }

    /**
     * Insert payment line items
     *
     * @param array  $data       Data
     * @param object $item       Item
     * @param int    $voucher_no Voucher Number
     *
     * @return int
     */
    public function insertPaymentLineItems($data, $item, $voucher_no)
    {


        $payment_data               = $this->getFormattedPaymentData($data, $voucher_no, $item['invoice_no']);
        $created_by                 = auth()->user()->id;
        $payment_data['created_at'] = date('Y-m-d H:i:s');
        $payment_data['created_by'] = $created_by;

        DB::table('erp_acct_invoice_receipts_details')
            ->insert(
                [
                    'voucher_no' => $voucher_no,
                    'invoice_no' => $item['invoice_no'],
                    'amount'     => abs($item['line_total']),
                    'created_at' => $payment_data['created_at'],
                    'created_by' => $payment_data['created_by'],
                    'updated_at' => $payment_data['updated_at'],
                    'updated_by' => $payment_data['updated_by'],
                ]
            );

        if (1 === $payment_data['status']) {
            return;
        }

        $debit  = 0;
        $credit = 0;

        if (floatval($item['line_total']) < 0) {
            $debit  = abs(floatval($item['line_total']));
        } else {
            $credit = $item['line_total'];
        }

        DB::table('erp_acct_invoice_account_details')
            ->insert(
                [
                    'invoice_no'  => $item['invoice_no'],
                    'trn_no'      => $voucher_no,
                    'trn_date'    => $payment_data['trn_date'],
                    'particulars' => $payment_data['particulars'],
                    'debit'       => $debit,
                    'credit'      => $credit,
                    'created_at'  => $payment_data['created_at'],
                    'created_by'  => $payment_data['created_by'],
                    'updated_at'  => $payment_data['updated_at'],
                    'updated_by'  => $payment_data['updated_by'],
                ]
            );

        $this->insertPaymentDataIntoLedger($payment_data);

        return $voucher_no;
    }

    /**
     * Update payment data
     *
     * @param string $data       Data Filter
     * @param int    $voucher_no Voucher Number
     *
     * @return mixed
     */
    public function updatePayment($data, $voucher_no)
    {

        $common = new CommonFunc();

        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            DB::beginTransaction();

            $payment_data = $this->getFormattedPaymentData($data, $voucher_no);

            DB::table('erp_acct_invoice_receipts')
                ->where('voucher_no', $voucher_no)
                ->update(
                    [
                        'trn_date'         => $payment_data['trn_date'],
                        'particulars'      => $payment_data['particulars'],
                        'amount'           => $payment_data['amount'],
                        'trn_by'           => $payment_data['trn_by'],
                        'trn_by_ledger_id' => $payment_data['trn_by_ledger_id'],
                        'created_at'       => $payment_data['created_at'],
                        'created_by'       => $payment_data['created_by'],
                        'updated_at'       => $payment_data['updated_at'],
                        'updated_by'       => $payment_data['updated_by'],
                    ]
                );

            $items = $payment_data['line_items'];

            foreach ($items as $key => $item) {
                $total = 0;

                $invoice_no[$key] = $item['invoice_id'];
                $total += $item['line_total'];

                $payment_data['amount'] = $total;

                $this->updatePaymentLineItems($payment_data, $voucher_no, $invoice_no[$key]);
            }

            if (isset($payment_data['trn_by']) && 3 === $payment_data['trn_by']) {
                $common->insertCheckData($payment_data);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('payment-exception', $e->getMessage());
            return;
        }

        foreach ($items as $key => $item) {
            $this->changeInvoiceStatus($item['invoice_no']);
        }

        return $this->getPayment($voucher_no);
    }

    /**
     * Insert payment line items
     *
     * @param array $data       Data Fiter
     * @param int   $invoice_no Invoice Number
     * @param int   $voucher_no Voucher Number
     *
     * @return int
     */
    public function updatePaymentLineItems($data, $invoice_no, $voucher_no)
    {


        $payment_data = $this->getFormattedPaymentData($data, $voucher_no, $invoice_no);

        DB::table('erp_acct_invoice_receipts_details')
            ->where('invoice_no', $invoice_no)
            ->update(
                [
                    'voucher_no' => $voucher_no,
                    'amount'     => abs($payment_data['amount']),
                    'created_at' => $payment_data['created_at'],
                    'created_by' => $payment_data['created_by'],
                    'updated_at' => $payment_data['updated_at'],
                    'updated_by' => $payment_data['updated_by'],
                ]
            );

        if (1 === $payment_data['status']) {
            return;
        }

        $debit  = 0;
        $credit = 0;

        if (floatval($payment_data['amount']) < 0) {
            $debit = abs(floatval($payment_data['amount']));
        } else {
            $credit  = $payment_data['amount'];
        }

        DB::table('erp_acct_invoice_account_details')
            ->where('invoice_no', $invoice_no)
            ->update(
                [
                    'trn_no'      => $voucher_no,
                    'particulars' => $payment_data['particulars'],
                    'trn_date'    => $payment_data['trn_date'],
                    'debit'       => $debit,
                    'credit'      => $credit,
                    'created_at'  => $payment_data['created_at'],
                    'created_by'  => $payment_data['created_by'],
                    'updated_at'  => $payment_data['updated_at'],
                    'updated_by'  => $payment_data['updated_by'],
                ]
            );

        $this->insertPaymentDataIntoLedger($payment_data);

        return $voucher_no;
    }

    /**
     * Get formatted payment data
     *
     * @param array $data       Data Filter
     * @param int   $voucher_no Voucher Number
     * @param int   $invoice_no Invoice Number
     *
     * @return mixed
     */
    public function getFormattedPaymentData($data, $voucher_no, $invoice_no = 0)
    {
        $people = new People();
        $payment_data = [];

        // We can pass the name from view... to reduce query load
        $user_info = $people->getPeople($data['customer_id']);
        $company   = new Company();

        $payment_data['voucher_no']       = !empty($voucher_no) ? $voucher_no : 0;
        $payment_data['invoice_no']       = !empty($invoice_no) ? $invoice_no : 0;
        $payment_data['customer_id']      = isset($data['customer_id']) ? $data['customer_id'] : null;
        $payment_data['customer_name']    = isset($user_info) ? $user_info->first_name . ' ' . $user_info->last_name : '';
        $payment_data['trn_date']         = isset($data['trn_date']) ? $data['trn_date'] : date('Y-m-d');
        $payment_data['line_items']       = isset($data['line_items']) ? $data['line_items'] : [];
        $payment_data['created_at']       = date('Y-m-d');
        $payment_data['amount']           = isset($data['amount']) ? $data['amount'] : 0;
        $payment_data['bank_trn_charge']  = isset($data['bank_trn_charge']) ? $data['bank_trn_charge'] : 0;
        $payment_data['ref']              = isset($data['ref']) ? $data['ref'] : null;
        $payment_data['attachments']      = isset($data['attachments']) ? $data['attachments'] : '';
        $payment_data['voucher_type']     = isset($data['type']) ? $data['type'] : '';
        $payment_data['particulars']      = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Invoice receipt created with voucher no %s', 'erp'), $voucher_no);
        $payment_data['trn_by']           = isset($data['trn_by']) ? $data['trn_by'] : '';
        $payment_data['trn_by_ledger_id'] = isset($data['deposit_to']) ? $data['deposit_to'] : null;
        $payment_data['status']           = isset($data['status']) ? $data['status'] : null;
        $payment_data['check_no']         = isset($data['check_no']) ? $data['check_no'] : 0;
        $payment_data['pay_to']           = isset($user_info) ? $user_info->first_name . ' ' . $user_info->last_name : '';
        $payment_data['name']             = isset($data['name']) ? $data['name'] : $company->name;
        $payment_data['bank']             = isset($data['bank']) ? $data['bank'] : '';
        $payment_data['voucher_type']     = isset($data['type']) ? $data['type'] : '';
        $payment_data['created_at']       = isset($data['created_at']) ? $data['created_at'] : null;
        $payment_data['created_by']       = isset($data['created_by']) ? $data['created_by'] : '';
        $payment_data['updated_at']       = isset($data['updated_at']) ? $data['updated_at'] : null;
        $payment_data['updated_by']       = isset($data['updated_by']) ? $data['updated_by'] : '';
        $payment_data['trn_by_ledger_id'] = empty($payment_data['trn_by_ledger_id']) ? $data['trn_by_ledger_id'] : $payment_data['trn_by_ledger_id'];

        return $payment_data;
    }

    /**
     * Delete a payment
     *
     * @param int $id Id
     *
     * @return void
     */
    public function deletePayment($id)
    {


        DB::table('erp_acct_invoice_receipts')->where([['voucher_no' => $id]])->delete();
        DB::table('erp_acct_invoice_receipts_details')->where([['voucher_no' => $id]])->delete();
        DB::table('erp_acct_invoice_account_details')->where([['invoice_no' => $id]])->delete();
    }

    /**
     * Void a payment
     *
     * @param int $id Id
     *
     * @return void
     */
    public function voidPayment($id)
    {


        if (!$id) {
            return;
        }

        DB::table('erp_acct_invoice_receipts')
            ->where('voucher_no', $id)
            ->update(
                [
                    'status' => 8,
                ]
            );

        DB::table('erp_acct_ledger_details')->where([['trn_no' => $id]])->delete();
        DB::table('erp_acct_invoice_account_details')->where([['trn_no' => $id]])->delete();
    }

    /**
     * Update invoice status after a payment
     *
     * @param int $invoice_no Invoice Number
     *
     * @return void
     */
    public function changeInvoiceStatus($invoice_no)
    {

        $invoices = new Invoices();

        $due = (float) $invoices->getInvoiceDue($invoice_no);

        if (0.00 === $due) {
            DB::table('erp_acct_invoices')
                ->where('voucher_no', $invoice_no)
                ->update(
                    [
                        'status' => 4,
                    ]
                );
        } else {
            DB::table('erp_acct_invoices')
                ->where('voucher_no', $invoice_no)
                ->update(
                    [
                        'status' => 5,
                    ]
                );
        }
    }

    /**
     * Insert Payment/s data into ledger
     *
     * @param array $payment_data Data Filter
     *
     * @return mixed
     */
    public function insertPaymentDataIntoLedger($payment_data)
    {


        if (1 === $payment_data['status'] || (isset($payment_data['trn_by']) && 4 === $payment_data['trn_by'])) {
            return;
        }

        $debit  = 0;
        $credit = 0;

        if (floatval($payment_data['amount']) < 0) {
            $credit = abs(floatval($payment_data['amount']));
        } else {
            $debit  = $payment_data['amount'];
        }

        // Insert amount in ledger_details
        DB::table('erp_acct_ledger_details')
            ->insert(
                [
                    'ledger_id'   => $payment_data['trn_by_ledger_id'],
                    'trn_no'      => $payment_data['voucher_no'],
                    'particulars' => $payment_data['particulars'],
                    'debit'       => $debit,
                    'credit'      => $credit,
                    'trn_date'    => $payment_data['trn_date'],
                    'created_at'  => $payment_data['created_at'],
                    'created_by'  => $payment_data['created_by'],
                    'updated_at'  => $payment_data['updated_at'],
                    'updated_by'  => $payment_data['updated_by'],
                ]
            );
    }

    /**
     * Update Payment/s data into ledger
     *
     * @param array $payment_data Data Filter
     * @param int   $invoice_no   Invoice Number
     *
     * @return mixed
     */
    public function updatePaymentDataInLedger($payment_data, $invoice_no)
    {


        if (1 === $payment_data['status'] || (isset($payment_data['trn_by']) && 4 === $payment_data['trn_by'])) {
            return;
        }

        $debit  = 0;
        $credit = 0;

        if (floatval($payment_data['amount']) < 0) {
            $credit = abs(floatval($payment_data['amount']));
        } else {
            $debit  = $payment_data['amount'];
        }

        // Update amount in ledger_details
        DB::table(('erp_acct_ledger_details')
                ->where('trn_no', $invoice_no)
                ->update(
                    [
                        'ledger_id'   => $payment_data['trn_by_ledger_id'],
                        'particulars' => $payment_data['particulars'],
                        'debit'       => $debit,
                        'credit'      => $credit,
                        'trn_date'    => $payment_data['trn_date'],
                        'created_at'  => $payment_data['created_at'],
                        'created_by'  => $payment_data['created_by'],
                        'updated_at'  => $payment_data['updated_at'],
                        'updated_by'  => $payment_data['updated_by'],
                    ]
                )
        );
    }

    /**
     * Get Payment count
     *
     * @return int
     */
    public function getPaymentCount()
    {


        $row = DB::select('SELECT COUNT(*) as count FROM ' . 'erp_acct_invoice_receipts');
        $row = (!empty($row)) ? $row[0] : null;
        return $row->count;
    }

    /**
     * Format payment line items
     *
     * @param string $invoice Invoice String
     *
     * @return array
     */
    public function formatPaymentLineItems($invoice = 'all')
    {


        $sql = 'SELECT inv_rec_detail.id, inv_rec_detail.voucher_no, inv_rec_detail.invoice_no, inv_rec_detail.amount, voucher.type ';

        if ('all' === $invoice) {
            $invoice_sql = '';
        } else {
            $invoice_sql = 'WHERE voucher_no = ' . $invoice;
        }
        $sql .= "FROM erp_acct_invoice_receipts_details AS inv_rec_detail
            LEFT JOIN erp_acct_voucher_no AS voucher
            ON inv_rec_detail.voucher_no = voucher.id
            {$invoice_sql}";

        return DB::select($sql);
    }
}
