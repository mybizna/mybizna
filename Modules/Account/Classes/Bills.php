<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\People;
use Modules\Account\Classes\Transactions;

use Illuminate\Support\Facades\DB;

class Bills
{

    /**
     * Get all bills
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getBills($args = [])
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

        if ($args['number'] != '-1') {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $sql  = 'SELECT';
        $sql .= $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';
        $sql .= "FROM erp_acct_bills WHERE `trn_by_ledger_id` IS NULL ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            return DB::scalar($sql);
        }

        $rows = DB::select($sql);

        return $rows;
    }

    /**
     * Get a single bill
     *
     * @param int $bill_no Bill No
     *
     * @return mixed
     */
    public function getBill($bill_no)
    {


        $sql =
            "SELECT

            voucher.editable,
            bill.id,
            bill.voucher_no,
            bill.vendor_id,
            bill.vendor_name,
            bill.address AS billing_address,
            bill.trn_date,
            bill.due_date,
            bill.amount,
            bill.ref,
            bill.particulars,
            bill.status,
            bill.created_at,
            bill.attachments

        FROM erp_acct_bills AS bill
        LEFT JOIN erp_acct_voucher_no as voucher ON bill.voucher_no = voucher.id
        LEFT JOIN erp_acct_bill_account_details AS b_ac_detail ON bill.voucher_no = b_ac_detail.trn_no
        WHERE bill.voucher_no = {$bill_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select($sql);
        $row = (!empty($row)) ? $row[0] : null;

        $row['bill_details'] = $this->formatBillLineItems($bill_no);
        $row['pdf_link']    = $this->pdfAbsPathToUrl($bill_no);
        return $row;
    }

    /**
     * Format bill line items
     *
     * @param int $voucher_no Voucher Number
     *
     * @return array|object|null
     */
    public function formatBillLineItems($voucher_no)
    {


        $sql =
            "SELECT
            b_detail.id,
            b_detail.trn_no,
            b_detail.ledger_id,
            b_detail.particulars,
            b_detail.amount,

            ledger.name AS ledger_name

        FROM erp_acct_bills AS bill
        LEFT JOIN erp_acct_bill_details AS b_detail ON bill.voucher_no = b_detail.trn_no
        LEFT JOIN erp_acct_ledgers AS ledger ON ledger.id = b_detail.ledger_id
        WHERE bill.voucher_no = { $voucher_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        return DB::select($sql);
    }

    /**
     * Insert a bill
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function insertBill($data)
    {


        $common = new CommonFunc();
        $people = new People();
        $trans = new Transactions();

        //$trans
        $created_by = auth()->user()->id;
        $voucher_no = null;
        $draft      = 1;

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $created_by;
        $currency           = $common->getCurrency(true);

        try {
            DB::beginTransaction();

            $voucher_no = DB::table('erp_acct_voucher_no')
                ->insertGetId(
                    [
                        'type'       => 'bill',
                        'currency'   => $currency,
                        'editable'   => 1,
                        'created_at' => $data['created_at'],
                        'created_by' => $data['created_by'],
                        'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : '',
                        'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : '',
                    ]
                );


            $bill_data           = $this->getFormattedBillData($data, $voucher_no);
            $bill_data['trn_no'] = $voucher_no;

            DB::table('erp_acct_bills')
                ->insert(
                    [
                        'voucher_no'  => $bill_data['voucher_no'],
                        'vendor_id'   => $bill_data['vendor_id'],
                        'vendor_name' => $bill_data['vendor_name'],
                        'address'     => $bill_data['billing_address'],
                        'trn_date'    => $bill_data['trn_date'],
                        'due_date'    => $bill_data['due_date'],
                        'amount'      => $bill_data['amount'],
                        'ref'         => $bill_data['ref'],
                        'particulars' => $bill_data['particulars'],
                        'status'      => $bill_data['status'],
                        'attachments' => $bill_data['attachments'],
                        'created_at'  => $bill_data['created_at'],
                        'created_by'  => $bill_data['created_by'],
                    ]
                );

            $items = $bill_data['bill_details'];

            foreach ($items as $key => $item) {
                DB::table('erp_acct_bill_details')
                    ->insert(
                        [
                            'trn_no'      => $voucher_no,
                            'ledger_id'   => $item['ledger_id'],
                            'particulars' => isset($item['description']) ? $item['description'] : '',
                            'amount'      => $item['amount'],
                            'created_at'  => $bill_data['created_at'],
                            'created_by'  => $bill_data['created_by'],
                        ]
                    );

                $this->insertBillDataIntoLedger($bill_data, $item);
            }

            if ($draft === $bill_data['status']) {
                DB::commit();

                return $this->getBill($voucher_no);
            }

            DB::table('erp_acct_bill_account_details')
                ->insert(
                    [
                        'bill_no'     => $voucher_no,
                        'trn_no'      => $voucher_no,
                        'trn_date'    => $bill_data['trn_date'],
                        'particulars' => $bill_data['particulars'],
                        'debit'       => 0,
                        'credit'      => $bill_data['amount'],
                        'created_at'  => $bill_data['created_at'],
                        'created_by'  => $bill_data['created_by'],
                    ]
                );

            $data['dr'] = 0;
            $data['cr'] = $bill_data['amount'];
            $trans->insertDataIntoPeopleTrnDetails($data, $voucher_no);

            do_action('erp_acct_after_bill_create', $data, $voucher_no);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('bill-exception', $e->getMessage());
            return;
        }

        $bill = $this->getBill($voucher_no);

        $bill['email'] = $people->getPeopleEmail($bill_data['vendor_id']);

        do_action('erp_acct_new_transaction_bill', $voucher_no, $bill);


        return $bill;
    }

    /**
     * Update a bill
     *
     * @param array $data    Data Filter
     * @param int   $bill_id Bill Id
     *
     * @return mixed
     */
    public function updateBill($data, $bill_id)
    {

        $common = new CommonFunc();
        $trans = new Transactions();

        $user_id    = auth()->user()->id;
        $draft      = 1;
        $voucher_no = null;

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $user_id;
        $currency           = $common->getCurrency(true);

        try {
            DB::beginTransaction();

            if ($draft === $data['status']) {
                $this->updateDraftBill($data, $bill_id);
            } else {
                // disable editing on old bill
                DB::table('erp_acct_voucher_no')
                    ->where(['id' => $bill_id])
                    ->update(['editable' => 0]);

                // insert contra voucher
                $voucher_no = DB::table('erp_acct_voucher_no')
                    ->insertGetId(
                        [
                            'type'       => 'bill',
                            'currency'   => $currency,
                            'editable'   => 0,
                            'created_at' => $data['created_at'],
                            'created_by' => $data['created_by'],
                            'updated_at' => $data['updated_at'],
                            'updated_by' => $data['updated_by'],
                        ]
                    );


                $old_bill = $this->getBill($bill_id);

                // insert contra `erp_acct_bills` (basically a duplication of row)
                DB::statement("CREATE TEMPORARY TABLE acct_tmptable SELECT * FROM erp_acct_bills WHERE voucher_no ={$bill_id}");
                DB::update(
                    "UPDATE acct_tmptable SET id = 0, voucher_no = {$voucher_no}, particulars = 'Contra entry for voucher no \#{$bill_id}', created_at = '{$data['created_at']}'"
                );
                DB::insert("INSERT INTO erp_acct_bills SELECT * FROM acct_tmptable");
                DB::statement('DROP TABLE acct_tmptable');

                // change bill status and other things
                $status_closed = 7;
                DB::update(
                    "UPDATE erp_acct_bills SET status = ?, updated_at ='?', updated_by = ? WHERE voucher_no IN (?, ?)",
                    [
                        $status_closed,
                        $data['updated_at'],
                        $user_id,
                        $bill_id,
                        $voucher_no
                    ]
                );

                $items = $old_bill['bill_details'];

                foreach ($items as $key => $item) {
                    // insert contra `erp_acct_bill_details`
                    DB::table('erp_acct_bill_details')
                        ->insert(
                            [
                                'trn_no'      => $voucher_no,
                                'ledger_id'   => $item['ledger_id'],
                                'particulars' => isset($item['description']) ? $item['description'] : '',
                                'amount'      => $item['amount'],
                                'created_at'  => $data['created_at'],
                                'created_by'  => $data['created_by'],
                            ]
                        );

                    // insert contra `erp_acct_ledger_details`
                    $this->updateBillDataIntoLedger($old_bill, $voucher_no, $item);
                }

                // insert contra `erp_acct_bill_account_details`
                DB::table('erp_acct_bill_account_details')
                    ->insert(
                        [
                            'bill_no'     => $bill_id,
                            'trn_no'      => $voucher_no,
                            'trn_date'    => $old_bill['trn_date'],
                            'particulars' => $old_bill['particulars'],
                            'debit'       => $old_bill['amount'],
                            'updated_at'  => $data['updated_at'],
                            'updated_by'  => $data['updated_by'],
                        ]
                    );

                // insert new bill with edited data
                $new_bill = $this->insertBill($data);

                do_action('erp_acct_after_bill_update', $data, $bill_id);

                $data['dr'] = 0;
                $data['cr'] = $data['amount'];
                $trans->updateDataIntoPeopleTrnDetails($data, $old_bill['voucher_no']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('bill-exception', $e->getMessage());
            return;
        }


        return $this->getBill($new_bill['voucher_no']);
    }

    /**
     * Make bill draft on update
     *
     * @param array $data    Data Filter
     * @param int   $bill_id Bill Id
     *
     * @return void
     */
    public function updateDraftBill($data, $bill_id)
    {


        $bill_data = $this->getFormattedBillData($data, $bill_id);

        DB::table('erp_acct_bills')
            ->where('voucher_no', $bill_id)
            ->update(
                [
                    'vendor_id'   => $bill_data['vendor_id'],
                    'vendor_name' => $bill_data['vendor_name'],
                    'address'     => $bill_data['billing_address'],
                    'trn_date'    => $bill_data['trn_date'],
                    'due_date'    => $bill_data['due_date'],
                    'amount'      => $bill_data['amount'],
                    'ref'         => $bill_data['ref'],
                    'particulars' => $bill_data['particulars'],
                    'attachments' => $bill_data['attachments'],
                    'updated_at'  => $bill_data['updated_at'],
                    'updated_by'  => $bill_data['updated_by'],
                ]
            );


        /**
         *? We can't update `bill_details` directly
         *? suppose there were 5 detail rows previously
         *? but on update there may be 2 detail rows
         *? that's why we can't update because the foreach will iterate only 2 times, not 5 times
         *? so, remove previous rows and insert new rows
         */
        $prev_detail_ids = DB::select("SELECT id FROM erp_acct_bill_details WHERE trn_no = {$bill_id}");

        $prev_detail_ids = implode(',', array_map('absint', $prev_detail_ids));

        DB::table('erp_acct_bill_details')->where([['trn_no' => $bill_id]])->delete();

        $items = $bill_data['bill_details'];

        foreach ($items as $item) {
            DB::table('erp_acct_bill_details')
                ->insert(
                    [
                        'trn_no'      => $bill_id,
                        'ledger_id'   => $item['ledger_id'],
                        'particulars' => isset($item['description']) ? $item['description'] : '',
                        'amount'      => $item['amount'],
                        'created_at'  => $bill_data['created_at'],
                        'created_by'  => $bill_data['created_by'],
                    ]
                );
        }
    }

    /**
     * Void a bill
     *
     * @param int $id Id
     *
     * @return void
     */
    public function voidBill($id)
    {


        if (!$id) {
            return;
        }

        DB::table('erp_acct_bills')
            ->where('voucher_no', $id)
            ->update(
                [
                    'status' => 8,
                ]
            );

        DB::table('erp_acct_ledger_details')->where([['trn_no' => $id]])->delete();
        DB::table('erp_acct_bill_account_details')->where([['bill_no' => $id]])->delete();
    }

    /**
     * Get formatted bill data
     *
     * @param array $data       Data  Filter
     * @param int   $voucher_no Voucher Number
     *
     * @return mixed
     */
    public function getFormattedBillData($data, $voucher_no)
    {

        $people_obj = new People();

        $bill_data = [];

        $vendor = $people_obj->getPeople($data['vendor_id']);

        $bill_data['voucher_no']      = !empty($voucher_no) ? $voucher_no : 0;
        $bill_data['vendor_id']       = isset($data['vendor_id']) ? $data['vendor_id'] : 1;
        $bill_data['vendor_name']     = isset($vendor) ? $vendor['first_name'] . ' ' . $vendor['last_name'] : '';
        $bill_data['billing_address'] = isset($data['billing_address']) ? $data['billing_address'] : '';
        $bill_data['trn_date']        = isset($data['trn_date']) ? $data['trn_date'] : date('Y-m-d');
        $bill_data['due_date']        = isset($data['due_date']) ? $data['due_date'] : date('Y-m-d');
        $bill_data['created_at']      = date('Y-m-d');
        $bill_data['amount']          = isset($data['amount']) ? $data['amount'] : 0;
        $bill_data['ref']             = isset($data['ref']) ? $data['ref'] : '';
        $bill_data['due']             = isset($data['due']) ? $data['due'] : 0;
        $bill_data['attachments']     = isset($data['attachments']) ? $data['attachments'] : '';
        // translators: %s: voucher_no
        $bill_data['particulars']      = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Bill created with voucher no %s', 'erp'), $voucher_no);
        $bill_data['bill_details']     = isset($data['bill_details']) ? $data['bill_details'] : '';
        $bill_data['status']           = isset($data['status']) ? $data['status'] : 1;
        $bill_data['trn_by_ledger_id'] = isset($data['trn_by']) ? $data['trn_by'] : null;
        $bill_data['created_at']       = date('Y-m-d');
        $bill_data['created_by']       = isset($data['created_by']) ? $data['created_by'] : '';
        $bill_data['updated_at']       = isset($data['updated_at']) ? $data['updated_at'] : '';
        $bill_data['updated_by']       = isset($data['updated_by']) ? $data['updated_by'] : '';

        return $bill_data;
    }

    /**
     * Insert bill/s data into ledger
     *
     * @param array $bill_data Bill Data Filter
     * @param array $item_data Item Data Filter
     *
     * @return mixed
     */
    public function insertBillDataIntoLedger($bill_data, $item_data)
    {


        $draft = 1;

        if ($draft === $bill_data['status']) {
            return;
        }

        // Insert items amount in ledger_details
        DB::table('erp_acct_ledger_details')
            ->insert(
                [
                    'ledger_id'   => $item_data['ledger_id'],
                    'trn_no'      => $bill_data['voucher_no'],
                    'particulars' => $bill_data['particulars'],
                    'debit'       => $item_data['amount'],
                    'credit'      => 0,
                    'trn_date'    => $bill_data['trn_date'],
                    'created_at'  => $bill_data['created_at'],
                    'created_by'  => $bill_data['created_by'],
                    'updated_at'  => $bill_data['updated_at'],
                    'updated_by'  => $bill_data['updated_by'],
                ]
            );
    }

    /**
     * Update bill/s data into ledger
     *
     * @param array $bill_data Bill Data Filter
     * @param array $bill_no   Bill Number
     * @param array $item_data Item Data Filter
     *
     * @return mixed
     */
    public function updateBillDataIntoLedger($bill_data, $bill_no, $item_data)
    {


        $user_id = auth()->user()->id;

        $bill_data['created_at'] = date('Y-m-d H:i:s');
        $bill_data['created_by'] = $user_id;
        $bill_data['updated_at'] = date('Y-m-d H:i:s');
        $bill_data['updated_by'] = $user_id;

        DB::table('erp_acct_ledger_details')
            ->insert(
                [
                    'ledger_id'   => $item_data['ledger_id'],
                    'trn_no'      => $bill_no,
                    'particulars' => $bill_data['particulars'],
                    'debit'       => 0,
                    'credit'      => $item_data['amount'],
                    'trn_date'    => $bill_data['trn_date'],
                    'created_at'  => $bill_data['created_at'],
                    'created_by'  => $bill_data['created_by'],
                    'updated_at'  => $bill_data['updated_at'],
                    'updated_by'  => $bill_data['updated_by'],
                ]
            );
    }

    /**
     * Get Bill count
     *
     * @return int
     */
    public function getBillCount()
    {


        $row = DB::select('SELECT COUNT(*) as count FROM ' . 'erp_acct_bills');
        $row = (!empty($row)) ? $row[0] : null;

        return $row->count;
    }

    /**
     * Get bills with due of a people
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getDueBillsByPeople($args = [])
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

        if ($args['number'] != '-1') {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $bills            = "erp_acct_bills";
        $bill_act_details = "erp_acct_bill_account_details";
        $items            = $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';

        $query =
            "SELECT $items FROM $bills as bill INNER JOIN (
            SELECT bill_no, ABS(SUM( ba.debit - ba.credit)) as due
            FROM $bill_act_details as ba
            GROUP BY ba.bill_no HAVING due > 0 ) as bs
            ON bill.voucher_no = bs.bill_no
            WHERE bill.vendor_id = {$args['people_id']} AND bill.status != 1
            ORDER BY {$args['orderby']} {$args['order']} $limit";

        if ($args['count']) {
            return DB::scalar($query);
        }

        return DB::select($query);
    }

    /**
     * Get due of a bill
     *
     * @param int $bill_no Bill No
     *
     * @return int
     */
    public function getBillDue($bill_no)
    {


        $result = DB::select("SELECT bill_no, SUM( ba.debit - ba.credit) as due FROM erp_acct_bill_account_details as ba WHERE ba.bill_no = ? GROUP BY ba.bill_no", [$bill_no]);
        $result = (!empty($result)) ? $result[0] : null;

        return $result['due'];
    }
}
