<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\Bills;
use Modules\Account\Classes\People;

use Illuminate\Support\Facades\DB;

class PayBills
{
    /**
     * Get all pay_bills
     *
     * @param array $args Data FIlter
     *
     * @return mixed
     */
    public function getPayBills($args = [])
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

        $sql  = 'SELECT';
        $sql .= $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';
        $sql .= "FROM payment_pay_bill ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            return DB::scalar($sql);
        }

        return DB::select($sql);
    }

    /**
     * Get a pay_bill
     *
     * @param int $bill_no Bill No
     *
     * @return mixed
     */
    public function getPayBill($bill_no)
    {

        $common = new CommonFunc();

        $row = DB::select(
            "SELECT
            pay_bill.id,
            pay_bill.voucher_no,
            pay_bill.vendor_id,
            pay_bill.vendor_name,
            pay_bill.trn_date,
            pay_bill.amount,
            pay_bill.ref,
            pay_bill.trn_by,
            pay_bill.particulars,
            pay_bill.created_at,
            pay_bill.attachments,
            pay_bill.status
            FROM payment_pay_bill AS pay_bill
            WHERE pay_bill.voucher_no = %d",
            [$bill_no]
        );

        $row = (!empty($row)) ? $row[0] : null;

        $row['bill_details'] = $this->formatPaybillLineItems($bill_no);
        $row['pdf_link']    = $common->pdfAbsPathToUrl($bill_no);

        return $row;
    }

    /**
     * Format pay bill line items
     *
     * @param array $voucher_no Voucher No
     *
     * @return array
     */
    public function formatPaybillLineItems($voucher_no)
    {


        return DB::select(
            "SELECT pay_bill_detail.id,
            pay_bill_detail.voucher_no,
            pay_bill_detail.bill_no,
            pay_bill_detail.amount
            FROM payment_pay_bill AS pay_bill
            LEFT JOIN payment_pay_bill_details as pay_bill_detail ON pay_bill.voucher_no = pay_bill_detail.voucher_no
            WHERE pay_bill.voucher_no = %d",
            [$voucher_no]
        );
    }

    /**
     * Insert a pay_bill
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function insertPayBill($data)
    {
        $people = new People();
        $common = new CommonFunc();
        $trans = new Transactions();

        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $created_by;

        $voucher_no = null;
        $currency   = $common->getCurrency(true);

        try {
            DB::beginTransaction();

            $voucher_no = DB::table('purchase_voucher_no')
                ->insertGetId(
                    [
                        'type'       => 'pay_bill',
                        'currency'   => $currency,
                        'created_at' => $data['created_at'],
                        'created_by' => $created_by,
                        'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : '',
                        'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : '',
                    ]
                );


            $pay_bill_data = $this->getFormattedPayBillData($data, $voucher_no);

            DB::table('payment_pay_bill')
                ->insert(
                    [
                        'voucher_no'       => $voucher_no,
                        'trn_date'         => $pay_bill_data['trn_date'],
                        'vendor_id'        => $pay_bill_data['vendor_id'],
                        'vendor_name'      => $pay_bill_data['people_name'],
                        'amount'           => $pay_bill_data['amount'],
                        'ref'              => $pay_bill_data['ref'],
                        'trn_by'           => $pay_bill_data['trn_by'],
                        'trn_by_ledger_id' => $pay_bill_data['trn_by_ledger_id'],
                        'particulars'      => $pay_bill_data['particulars'],
                        'attachments'      => $pay_bill_data['attachments'],
                        'status'           => $pay_bill_data['status'],
                        'created_at'       => $pay_bill_data['created_at'],
                        'created_by'       => $created_by,
                        'updated_at'       => $pay_bill_data['updated_at'],
                        'updated_by'       => $pay_bill_data['updated_by'],
                    ]
                );

            $items = $pay_bill_data['bill_details'];

            foreach ($items as $key => $item) {
                DB::table('payment_pay_bill_details')
                    ->insert(
                        [
                            'voucher_no' => $voucher_no,
                            'bill_no'    => $item['voucher_no'],
                            'amount'     => $item['amount'],
                            'created_at' => $pay_bill_data['created_at'],
                            'created_by' => $pay_bill_data['created_by'],
                            'updated_at' => $pay_bill_data['updated_at'],
                            'updated_by' => $pay_bill_data['updated_by'],
                        ]
                    );

                if (1 === $pay_bill_data['status']) {
                    DB::commit();

                    return $this->getPayBill($voucher_no);
                }
            }

            foreach ($items as $key => $item) {
                DB::table('bill_account_detail')
                    ->insert(
                        [
                            'bill_no'     => $item['voucher_no'],
                            'trn_no'      => $voucher_no,
                            'trn_date'    => $pay_bill_data['trn_date'],
                            'particulars' => $pay_bill_data['particulars'],
                            'debit'       => $item['amount'],
                            'credit'      => 0,
                            'created_at'  => $pay_bill_data['created_at'],
                            'created_by'  => $pay_bill_data['created_by'],
                            'updated_at'  => $pay_bill_data['updated_at'],
                            'updated_by'  => $pay_bill_data['updated_by'],
                        ]
                    );
            }

            $this->insertPayBillDataIntoLedger($pay_bill_data);

            if (isset($pay_bill_data['trn_by']) && 3 === $pay_bill_data['trn_by']) {
                $common->insertCheckData($pay_bill_data);
            }

            $data['dr'] = $pay_bill_data['amount'];
            $data['cr'] = 0;
            $trans->insertDataIntoPeopleTrnDetails($data, $voucher_no);

            do_action('after_pay_bill_create', $pay_bill_data, $voucher_no);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('pay-bill-exception', $e->getMessage());
            return;
        }

        foreach ($items as $item) {
            $this->changeBillStatus($item['voucher_no']);
        }

        $pay_bill = $this->getPayBill($voucher_no);

        $pay_bill['email'] = $people->getPeopleEmail($data['vendor_id']);

        do_action('new_transaction_pay_bill', $voucher_no, $pay_bill);


        return $pay_bill;
    }

    /**
     * Update a pay_bill
     *
     * @param array $data        Data Filter
     * @param int   $pay_bill_id Pay Bill Id
     *
     * @return mixed
     */
    public function updatePayBill($data, $pay_bill_id)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            DB::beginTransaction();

            $pay_bill_data = $this->getFormattedPayBillData($data, $pay_bill_id);

            DB::table('payment_pay_bill')
                ->where('voucher_no', $pay_bill_id)
                ->update(
                    [
                        'bill_no'     => $pay_bill_data['bill_no'],
                        'trn_date'    => $pay_bill_data['trn_date'],
                        'amount'      => $pay_bill_data['amount'],
                        'type'        => $pay_bill_data['type'],
                        'particulars' => $pay_bill_data['particulars'],
                        'attachments' => $pay_bill_data['attachments'],
                        'status'      => $pay_bill_data['status'],
                        'created_at'  => $pay_bill_data['created_at'],
                        'created_by'  => $pay_bill_data['created_by'],
                        'updated_at'  => $pay_bill_data['updated_at'],
                        'updated_by'  => $pay_bill_data['updated_by'],
                    ]
                );

            $items = $pay_bill_data['bill_details'];

            foreach ($items as $key => $item) {
                DB::table('payment_pay_bill_details')
                    ->where('voucher_no', $pay_bill_id)
                    ->update(
                        [
                            'bill_no'    => $item['voucher_no'],
                            'amount'     => $item['amount'],
                            'created_at' => $pay_bill_data['created_at'],
                            'created_by' => $pay_bill_data['created_by'],
                            'updated_at' => $pay_bill_data['updated_at'],
                            'updated_by' => $pay_bill_data['updated_by'],
                        ]
                    );

                DB::table('bill_account_detail')
                    ->where('trn_no', $pay_bill_id)
                    ->update(
                        [
                            'bill_no'     => $item['voucher_no'],
                            'particulars' => $pay_bill_data['particulars'],
                            'debit'       => 0,
                            'credit'      => $item['amount'],
                            'created_at'  => $pay_bill_data['created_at'],
                            'created_by'  => $pay_bill_data['created_by'],
                            'updated_at'  => $pay_bill_data['updated_at'],
                            'updated_by'  => $pay_bill_data['updated_by'],
                        ]
                    );
            }

            $this->updatePayBillDataIntoLedger($pay_bill_data, $pay_bill_id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('bill-exception', $e->getMessage());
            return;
        }

        foreach ($items as $item) {
            $this->changeBillStatus($item['voucher_no']);
        }


        return $this->getPayBill($pay_bill_id);
    }

    /**
     * Void a pay_bill
     *
     * @param int $id Id
     *
     * @return void
     */
    public function voidPayBill($id)
    {


        if (!$id) {
            return;
        }

        DB::table('payment_pay_bill')
            ->where('voucher_no', $id)
            ->update(
                [
                    'status' => 8,
                ]
            );

        DB::table('account_ledger_detail')->where([['trn_no' => $id]])->delete();
        DB::table('bill_account_detail')->where([['trn_no' => $id]])->delete();
    }

    /**
     * Get formatted pay_bill data
     *
     * @param array $data       Data Filter
     * @param int   $voucher_no Voucher Number
     *
     * @return mixed
     */
    public function getFormattedPayBillData($data, $voucher_no)
    {
        $people = new People();
        $pay_bill_data = [];

        $user_info = $people->getPeople($data['vendor_id']);
        $company   = new Company();

        $pay_bill_data['voucher_no']       = !empty($voucher_no) ? $voucher_no : 0;
        $pay_bill_data['trn_no']           = !empty($voucher_no) ? $voucher_no : 0;
        $pay_bill_data['vendor_id']        = isset($data['vendor_id']) ? $data['vendor_id'] : null;
        $pay_bill_data['people_name']      = isset($user_info) ? $user_info->first_name . ' ' . $user_info->last_name : '';
        $pay_bill_data['trn_date']         = isset($data['trn_date']) ? $data['trn_date'] : date('Y-m-d');
        $pay_bill_data['amount']           = isset($data['amount']) ? $data['amount'] : 0;
        $pay_bill_data['ref']              = isset($data['ref']) ? $data['ref'] : '';
        $pay_bill_data['trn_by']           = isset($data['trn_by']) ? $data['trn_by'] : 0;
        $pay_bill_data['particulars']      = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Bill payment created with voucher no %s', 'erp'), $voucher_no);
        $pay_bill_data['attachments']      = isset($data['attachments']) ? $data['attachments'] : '';
        $pay_bill_data['bill_details']     = isset($data['bill_details']) ? $data['bill_details'] : '';
        $pay_bill_data['status']           = isset($data['status']) ? $data['status'] : 4;
        $pay_bill_data['trn_by_ledger_id'] = isset($data['deposit_to']) ? $data['deposit_to'] : null;
        $pay_bill_data['check_no']         = isset($data['check_no']) ? $data['check_no'] : 0;
        $pay_bill_data['pay_to']           = isset($user_info) ? $user_info->first_name . ' ' . $user_info->last_name : '';
        $pay_bill_data['name']             = isset($data['name']) ? $data['name'] : $company->name;
        $pay_bill_data['bank']             = isset($data['bank']) ? $data['bank'] : '';
        $pay_bill_data['voucher_type']     = isset($data['voucher_type']) ? $data['voucher_type'] : '';
        $pay_bill_data['created_at']       = date('Y-m-d');
        $pay_bill_data['created_by']       = isset($data['created_by']) ? $data['created_by'] : '';
        $pay_bill_data['updated_at']       = isset($data['updated_at']) ? $data['updated_at'] : '';
        $pay_bill_data['updated_by']       = isset($data['updated_by']) ? $data['updated_by'] : '';

        return $pay_bill_data;
    }

    /**
     * Insert pay_bill/s data into ledger
     *
     * @param array $pay_bill_data Pay Bill Data
     *
     * @return mixed
     */
    public function insertPayBillDataIntoLedger($pay_bill_data)
    {


        if (1 === $pay_bill_data['status'] || (isset($pay_bill_data['trn_by']) && 4 === $pay_bill_data['trn_by'])) {
            return;
        }

        // Insert amount in ledger_details
        DB::table('account_ledger_detail')
            ->insert(
                [
                    'ledger_id'   => $pay_bill_data['trn_by_ledger_id'],
                    'trn_no'      => $pay_bill_data['trn_no'],
                    'particulars' => $pay_bill_data['particulars'],
                    'debit'       => 0,
                    'credit'      => $pay_bill_data['amount'],
                    'trn_date'    => $pay_bill_data['trn_date'],
                    'created_at'  => $pay_bill_data['created_at'],
                    'created_by'  => $pay_bill_data['created_by'],
                    'updated_at'  => $pay_bill_data['updated_at'],
                    'updated_by'  => $pay_bill_data['updated_by'],
                ]
            );
    }

    /**
     * Update pay_bill/s data into ledger
     *
     * @param array $pay_bill_data Pay Bill Data
     * @param int   $pay_bill_no   Pay Bill Number
     *
     * @return mixed
     */
    public function updatePayBillDataIntoLedger($pay_bill_data, $pay_bill_no)
    {


        if (1 === $pay_bill_data['status'] || (isset($pay_bill_data['trn_by']) && 4 === $pay_bill_data['trn_by'])) {
            return;
        }

        // Update amount in ledger_details
        DB::table('account_ledger_detail')
            ->where('trn_no', $pay_bill_no)
            ->update(
                [
                    'ledger_id'   => $pay_bill_data['trn_by_ledger_id'],
                    'particulars' => $pay_bill_data['particulars'],
                    'debit'       => 0,
                    'credit'      => $pay_bill_data['amount'],
                    'trn_date'    => $pay_bill_data['trn_date'],
                    'created_at'  => $pay_bill_data['created_at'],
                    'created_by'  => $pay_bill_data['created_by'],
                    'updated_at'  => $pay_bill_data['updated_at'],
                    'updated_by'  => $pay_bill_data['updated_by'],
                ]
            );
    }

    /**
     * Get Pay bills count
     *
     * @return int
     */
    public function getPayBillCount()
    {


        $row = DB::select('SELECT COUNT(*) as count FROM ' . 'payment_pay_bill');
        $row = (!empty($row)) ? $row[0] : null;
        return $row->count;
    }

    /**
     * Update bill status after a payment
     *
     * @param int $bill_no Bill Number
     *
     * @return void
     */
    public function changeBillStatus($bill_no)
    {
        $bills = new Bills();

        $due = $bills->getBillDue($bill_no);

        if (0 == $due) {
            DB::table('bill')
                ->where('voucher_no', $bill_no)
                ->update(
                    [
                        'status' => 4,
                    ]
                );
        } else {
            DB::table('bill')
                ->where('voucher_no', $bill_no)
                ->update(
                    [
                        'status' => 5,
                    ]
                );
        }
    }
}
