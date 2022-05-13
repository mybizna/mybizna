<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\Transactions;
use Modules\Account\Classes\People;
use Modules\Account\Classes\Bank;
use Modules\Account\Classes\Company;

use Illuminate\Support\Facades\DB;

class Expenses
{

    /**
     * Get all expenses
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getExpenses($args = [])
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
        $sql .= "FROM erp_acct_expenses WHERE `trn_by_ledger_id` IS NOT NULL ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        if ($args['count']) {
            return DB::scalar($sql);
        }

        $rows = DB::select($sql);

        return $rows;
    }

    /**
     * Get a single expense
     *
     * @param int $expense_no Expense Number
     *
     * @return mixed
     */
    public function getExpense($expense_no)
    {

        $common = new CommonFunc();

        $sql = "SELECT

                expense.id,
                expense.voucher_no,
                expense.people_id,
                expense.people_name,
                expense.address,
                expense.trn_date,
                expense.amount,
                expense.ref,
                expense.check_no,
                expense.particulars,
                expense.status,
                expense.trn_by_ledger_id,
                expense.trn_by,
                expense.transaction_charge,
                expense.attachments,
                expense.created_at,
                expense.created_by,
                expense.updated_at,
                expense.updated_by

            FROM erp_acct_expenses AS expense WHERE expense.voucher_no = {$expense_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select($sql);

        $row = (!empty($row)) ? $row[0] : null;


        $row['bill_details'] = $this->formatExpenseLineItems($expense_no);
        $row['pdf_link']    = $common->pdfAbsPathToUrl($expense_no);

        $check_data = $this->getCheckDataOfExpense($expense_no);

        if (!empty($check_data)) {
            $row['check_data'] = $check_data;
        }

        return $row;
    }

    /**
     * Get a single check
     *
     * @param int $expense_no Expense Number
     *
     * @return mixed
     */
    public function getCheck($expense_no)
    {


        $sql = "SELECT

    expense.id,
    expense.voucher_no,
    expense.people_id,
    expense.people_name,
    expense.address,
    expense.trn_date,
    expense.amount,
    expense.particulars,
    expense.status,
    expense.trn_by_ledger_id,
    expense.trn_by,
    expense.check_no,
    expense.attachments,
    expense.created_at,
    expense.created_by,
    expense.updated_at,
    expense.updated_by,

    ledg_detail.debit,
    ledg_detail.credit

    FROM erp_acct_expenses AS expense

    LEFT JOIN erp_acct_ledger_details AS ledg_detail ON expense.voucher_no = ledg_detail.trn_no

    WHERE expense.voucher_no = {$expense_no} AND expense.trn_by = 3";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select($sql);

        $row = (!empty($row)) ? $row[0] : null;

        $row['bill_details'] = $this->formatCheckLineItems($expense_no);

        return $row;
    }

    /**
     * Format check line items
     *
     * @param int $voucher_no Voucher Number
     *
     * @return array
     */
    public function formatCheckLineItems($voucher_no)
    {


        $sql =
            "SELECT
        expense.id,
        expense.voucher_no,
        expense.status,
        expense.trn_by,
        expense.trn_date,

        expense_detail.ledger_id,
        expense_detail.particulars,
        expense_detail.amount,

        ledger.name AS ledger_name

        FROM erp_acct_expenses AS expense
        LEFT JOIN erp_acct_expense_details AS expense_detail ON expense_detail.trn_no = expense.voucher_no
        LEFT JOIN erp_acct_ledgers AS ledger ON expense_detail.ledger_id = ledger.id

        WHERE expense.voucher_no={$voucher_no} AND expense.trn_by = 3";

        return DB::select($sql);
    }

    /**
     * Format expense line items
     *
     * @param int $voucher_no Voucher Number
     *
     * @return array
     */
    public function formatExpenseLineItems($voucher_no)
    {


        $sql =
            "SELECT
        expense_detail.id,
        expense_detail.ledger_id,
        ledger.name AS ledger_name,
        expense_detail.trn_no,
        expense_detail.particulars,
        expense_detail.amount

        FROM erp_acct_expenses AS expense
        LEFT JOIN erp_acct_expense_details AS expense_detail ON expense.voucher_no = expense_detail.trn_no LEFT JOIN erp_acct_ledgers AS ledger ON expense_detail.ledger_id = ledger.id WHERE expense.voucher_no = {$voucher_no}";



        return DB::select($sql);
    }

    /**
     * Insert a expense
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function insertExpense($data)
    {

        $common = new CommonFunc();
        $people = new People();
        $bank = new Bank();
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

            $type = 'expense';

            if (isset($data['voucher_type']) && 'check' === $data['voucher_type']) {
                $type = 'check';
            }

            $voucher_no =  DB::table('erp_acct_voucher_no')
                ->insertGetId(
                    [
                        'type'       => $type,
                        'currency'   => $currency,
                        'created_at' => $data['created_at'],
                        'created_by' => $data['created_by'],
                        'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : '',
                        'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : '',
                    ]
                );


            $expense_data = $this->getFormattedExpenseData($data, $voucher_no);

            // check transaction charge
            $transaction_charge = 0;
            if (isset($expense_data['bank_trn_charge']) && 0 < (float)$expense_data['bank_trn_charge'] && 2 === (int)$expense_data['trn_by']) {
                $transaction_charge = (float)$expense_data['bank_trn_charge'];
            }


            DB::table('erp_acct_expenses')
                ->insert(
                    [
                        'voucher_no'         => $expense_data['voucher_no'],
                        'people_id'          => $expense_data['people_id'],
                        'people_name'        => $expense_data['people_name'],
                        'address'            => $expense_data['billing_address'],
                        'trn_date'           => $expense_data['trn_date'],
                        'amount'             => $expense_data['amount'],
                        'transaction_charge' => $transaction_charge,
                        'ref'                => $expense_data['ref'],
                        'check_no'           => $expense_data['check_no'],
                        'particulars'        => $expense_data['particulars'],
                        'status'             => $expense_data['status'],
                        'trn_by'             => $expense_data['trn_by'],
                        'trn_by_ledger_id'   => $expense_data['trn_by_ledger_id'],
                        'attachments'        => $expense_data['attachments'],
                        'created_at'         => $expense_data['created_at'],
                        'created_by'         => $expense_data['created_by'],
                        'updated_at'         => $expense_data['updated_at'],
                        'updated_by'         => $expense_data['updated_by'],
                    ]
                );

            $items = $expense_data['bill_details'];



            foreach ($items as $key => $item) {
                DB::table('erp_acct_expense_details')
                    ->insert(
                        [
                            'trn_no'      => $voucher_no,
                            'ledger_id'   => $item['ledger_id'],
                            'particulars' => !empty($item['particulars']) ? $item['particulars'] : '',
                            'amount'      => $item['amount'],
                            'created_at'  => $expense_data['created_at'],
                            'created_by'  => $expense_data['created_by'],
                            'updated_at'  => $expense_data['updated_at'],
                            'updated_by'  => $expense_data['updated_by'],
                        ]
                    );

                $this->insertExpenseDataIntoLedger($expense_data, $item);
            }


            // add transaction charge entry to ledger
            if ($transaction_charge) {
                $common->insertBankTransactionChargeIntoLedger($expense_data);
            }

            if (1 === $expense_data['status']) {
                DB::commit();

                if ('check' === $type) {
                    return $this->getCheck($voucher_no);
                }

                return $this->getExpense($voucher_no);
            }

            $check = 3;

            if ($check == $expense_data['trn_by']) {
                $common->insertCheckData($expense_data);
            } elseif ('check' === $type) {
                $common->insertCheckData($expense_data);
            }

            if ('check' === $type) {
                $this->insertSourceExpenseDataIntoLedger($expense_data);
            } elseif (isset($expense_data['trn_by']) && 4 === $expense_data['trn_by']) {
                do_action('erp_acct_expense_people_transaction', $expense_data, $voucher_no);
            } else {
                //Insert into Ledger for source account
                $this->insertSourceExpenseDataIntoLedger($expense_data);
            }

            $data['dr'] = 0;
            $data['cr'] = $expense_data['amount'];
            $trans->insertDataIntoPeopleTrnDetails($data, $voucher_no);

            do_action('erp_acct_after_expense_create', $expense_data, $voucher_no);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('expense-exception', $e->getMessage());
            return;
        }

        $email = $people->getPeopleEmail($expense_data['people_id']);

        if ('check' === $type) {
            $check          = $this->getCheck($voucher_no);
            $check['email'] = $email;

            do_action('erp_acct_new_transaction_check', $voucher_no, $check);

            return $check;
        }

        $expense          = $this->getExpense($voucher_no);
        $expense['email'] = $email;

        do_action('erp_acct_new_transaction_expense', $voucher_no, $expense);


        return $expense;
    }

    /**
     * Update a expense
     *
     * @param array $data       Data Filter
     * @param int   $expense_id Expense Id
     *
     * @return mixed
     */
    public function updateExpense($data, $expense_id)
    {


        if ($data['convert']) {
            $this->convertDraftToExpense($data, $expense_id);

            return;
        }

        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            DB::beginTransaction();

            $expense_data = $this->getFormattedExpenseData($data, $expense_id);

            DB::table('erp_acct_expenses')
                ->where('voucher_no', $expense_id)
                ->update(
                    [
                        'people_id'        => $expense_data['people_id'],
                        'people_name'      => $expense_data['people_name'],
                        'address'          => $expense_data['billing_address'],
                        'trn_date'         => $expense_data['trn_date'],
                        'amount'           => $expense_data['amount'],
                        'ref'              => $expense_data['ref'],
                        'check_no'         => $expense_data['check_no'],
                        'particulars'      => $expense_data['particulars'],
                        'trn_by'           => $expense_data['trn_by'],
                        'trn_by_ledger_id' => $expense_data['trn_by_ledger_id'],
                        'attachments'      => $expense_data['attachments'],
                        'updated_at'       => $expense_data['updated_at'],
                        'updated_by'       => $expense_data['updated_by'],
                    ]
                );

            /**
             *? We can't update `expense_details` directly
             *? suppose there were 5 detail rows previously
             *? but on update there may be 2 detail rows
             *? that's why we can't update because the foreach will iterate only 2 times, not 5 times
             *? so, remove previous rows and insert new rows
             */
            $prev_detail_ids = DB::select("SELECT id FROM erp_acct_expense_details WHERE trn_no = {$expense_id}");
            $prev_detail_ids = implode(',', array_map('absint', $prev_detail_ids));

            DB::table('erp_acct_expense_details')->where([['trn_no' => $expense_id]])->delete();

            $items = $expense_data['bill_details'];

            foreach ($items as $key => $item) {
                DB::table('erp_acct_expense_details')
                    ->insert(
                        [
                            'ledger_id'   => $item['ledger_id'],
                            'particulars' => $item['particulars'],
                            'amount'      => $item['amount'],
                            'created_at'  => $expense_data['created_at'],
                            'created_by'  => $expense_data['created_by'],
                            'updated_at'  => $expense_data['updated_at'],
                            'updated_by'  => $expense_data['updated_by'],
                        ]
                    );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('expense-exception', $e->getMessage());
            return;
        }


        return $expense_id;
    }

    /**
     * Convert draft to expense
     *
     * @param array $data       Data Filter
     * @param int   $expense_id Expense Id
     *
     * @return array
     */
    public function convertDraftToExpense($data, $expense_id)
    {

        $common = new CommonFunc();
        $people = new People();
        $trans = new Transactions();

        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            DB::beginTransaction();

            $type = 'expense';

            if (isset($data['voucher_type']) && 'check' === $data['voucher_type']) {
                $type = 'check';
            }

            $expense_data = $this->getFormattedExpenseData($data, $expense_id);

            DB::table('erp_acct_expenses')
                ->where('voucher_no', $expense_id)
                ->update(
                    [
                        'people_id'        => $expense_data['people_id'],
                        'people_name'      => $expense_data['people_name'],
                        'address'          => $expense_data['billing_address'],
                        'trn_date'         => $expense_data['trn_date'],
                        'amount'           => $expense_data['amount'],
                        'ref'              => $expense_data['ref'],
                        'check_no'         => $expense_data['check_no'],
                        'status'           => $expense_data['status'],
                        'particulars'      => $expense_data['particulars'],
                        'trn_by'           => $expense_data['trn_by'],
                        'trn_by_ledger_id' => $expense_data['trn_by_ledger_id'],
                        'attachments'      => $expense_data['attachments'],
                        'updated_at'       => $expense_data['updated_at'],
                        'updated_by'       => $expense_data['updated_by'],
                    ]
                );

            /**
             *? We can't update `expense_details` directly
             *? suppose there were 5 detail rows previously
             *? but on update there may be 2 detail rows
             *? that's why we can't update because the foreach will iterate only 2 times, not 5 times
             *? so, remove previous rows and insert new rows
             */
            $prev_detail_ids = DB::select("SELECT id FROM erp_acct_expense_details WHERE trn_no = {$expense_id}");
            $prev_detail_ids = implode(',', array_map('absint', $prev_detail_ids));

            DB::table('erp_acct_expense_details')->where([['trn_no' => $expense_id]])->delete();

            $items = $expense_data['bill_details'];

            foreach ($items as $item) {
                DB::table('erp_acct_expense_details')
                    ->insert(
                        [
                            'ledger_id'   => $item['ledger_id'],
                            'particulars' => $item['particulars'],
                            'trn_no'      => $expense_id,
                            'amount'      => $item['amount'],
                            'created_at'  => $expense_data['created_at'],
                            'created_by'  => $expense_data['created_by'],
                            'updated_at'  => $expense_data['updated_at'],
                            'updated_by'  => $expense_data['updated_by'],
                        ]
                    );

                $this->insertExpenseDataIntoLedger($expense_data, $item);
            }

            $check = 3;

            if ($check == $expense_data['trn_by']) {
                $common->insertCheckData($expense_data);
            } elseif ('check' === $type) {
                $common->insertCheckData($expense_data);
            }

            if ('check' === $type) {
                $this->insertSourceExpenseDataIntoLedger($expense_data);
            } elseif (isset($expense_data['trn_by']) && 4 === $expense_data['trn_by']) {
                do_action('erp_acct_expense_people_transaction', $expense_data, $expense_id);
            } else {
                //Insert into Ledger for source account
                $this->insertSourceExpenseDataIntoLedger($expense_data);
            }

            $data['dr'] = 0;
            $data['cr'] = $expense_data['amount'];
            $trans->insertDataIntoPeopleTrnDetails($data, $expense_id);

            do_action('erp_acct_after_expense_create', $expense_data, $expense_id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('expense-exception', $e->getMessage());
            return;
        }

        $email = $people->getPeopleEmail($expense_data['people_id']);

        if ('check' === $type) {
            $check          = $this->getCheck($expense_id);
            $check['email'] = $email;

            do_action('erp_acct_new_transaction_check', $expense_id, $check);

            return $check;
        }

        $expense          = $this->getExpense($expense_id);
        $expense['email'] = $email;

        do_action('erp_acct_new_transaction_expense', $expense_id, $expense);


        return $expense;
    }

    /**
     * Void a expense
     *
     * @param int $id Id
     *
     * @return void
     */
    public function voidExpense($id)
    {


        if (!$id) {
            return;
        }

        DB::table('erp_acct_expenses')
            ->where('voucher_no', $id)
            ->update(
                [
                    'status' => 8,
                ]
            );

        DB::table('erp_acct_ledger_details')->where([['trn_no' => $id]])->delete();
        DB::table('erp_acct_expense_details')->where([['trn_no' => $id]])->delete();
    }

    /**
     * Get formatted expense data
     *
     * @param array $data       Data Filter
     * @param int   $voucher_no Voucher Number
     *
     * @return mixed
     */
    public function getFormattedExpenseData($data, $voucher_no)
    {
        $people_obj = new People();
        $expense_data = [];

        $people  = $people_obj->getPeople($data['people_id']);
        $company = new Company();

        $expense_data['voucher_no']       = !empty($voucher_no) ? $voucher_no : 0;
        $expense_data['people_id']        = isset($data['people_id']) ? $data['people_id'] : auth()->user()->id;
        $expense_data['people_name']      = isset($people) ? $people->first_name . ' ' . $people->last_name : '';
        $expense_data['billing_address']  = isset($data['billing_address']) ? $data['billing_address'] : '';
        $expense_data['trn_date']         = isset($data['trn_date']) ? $data['trn_date'] : date('Y-m-d');
        $expense_data['amount']           = isset($data['amount']) ? $data['amount'] : 0;
        $expense_data['attachments']      = isset($data['attachments']) ? $data['attachments'] : '';
        $expense_data['ref']              = isset($data['ref']) ? $data['ref'] : '';
        $expense_data['check_no']         = isset($data['check_no']) ? $data['check_no'] : null;
        $expense_data['particulars']      = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Expense created with voucher no %s', 'erp'), $voucher_no);
        $expense_data['bill_details']     = isset($data['bill_details']) ? $data['bill_details'] : '';
        $expense_data['status']           = isset($data['status']) ? $data['status'] : 1;
        $expense_data['trn_by_ledger_id'] = isset($data['trn_by_ledger_id']) ? $data['trn_by_ledger_id'] : null;
        $expense_data['trn_by']           = isset($data['trn_by']) ? $data['trn_by'] : null;
        $expense_data['bank_trn_charge']  = isset($data['bank_trn_charge']) ? $data['bank_trn_charge'] : null;
        $expense_data['created_at']       = date('Y-m-d');
        $expense_data['created_by']       = isset($data['created_by']) ? $data['created_by'] : '';
        $expense_data['updated_at']       = isset($data['updated_at']) ? $data['updated_at'] : '';
        $expense_data['updated_by']       = isset($data['updated_by']) ? $data['updated_by'] : '';
        $expense_data['pay_to']           = isset($people) ? $people->first_name . ' ' . $people->last_name : '';
        $expense_data['name']             = isset($data['name']) ? $data['name'] : $company->name;
        $expense_data['bank']             = isset($data['bank']) ? $data['bank'] : '';
        $expense_data['voucher_type']     = isset($data['voucher_type']) ? $data['voucher_type'] : '';

        return $expense_data;
    }

    /**
     * Insert expense/s data into ledger
     *
     * @param array $expense_data Data filter
     * @param array $item_data    Data filter
     *
     * @return mixed
     */
    public function insertExpenseDataIntoLedger($expense_data, $item_data = [])
    {


        $draft  = 1;
        $people = '4'; // from reimbursement

        if ($draft === $expense_data['status'] || $people === $expense_data['trn_by']) {
            return;
        }

        // Insert amount in ledger_details
        DB::table('erp_acct_ledger_details')
            ->insert(
                [
                    'ledger_id'   => $item_data['ledger_id'],
                    'trn_no'      => $expense_data['voucher_no'],
                    'particulars' => $expense_data['particulars'],
                    'debit'       => $item_data['amount'],
                    'credit'      => 0,
                    'trn_date'    => $expense_data['trn_date'],
                    'created_at'  => $expense_data['created_at'],
                    'created_by'  => $expense_data['created_by'],
                    'updated_at'  => $expense_data['updated_at'],
                    'updated_by'  => $expense_data['updated_by'],
                ]
            );
    }

    /**
     * Update expense/s data into ledger
     *
     * @param array $expense_data Data Filter
     * @param array $expense_no   Expense Number
     * @param array $item_data    Item Data
     *
     * @return mixed
     */
    public function updateExpenseDataIntoLedger($expense_data, $expense_no, $item_data = [])
    {


        if (1 === $expense_data['status'] && (isset($expense_data['trn_by']) && 4 === $expense_data['trn_by'])) {
            return;
        }

        // Update amount in ledger_details
        DB::table('erp_acct_ledger_details')
            ->where('trn_no', $expense_no)
            ->update(
                [
                    'ledger_id'   => $item_data['ledger_id'],
                    'particulars' => $expense_data['particulars'],
                    'debit'       => $item_data['amount'],
                    'credit'      => 0,
                    'trn_date'    => $expense_data['trn_date'],
                    'created_at'  => $expense_data['created_at'],
                    'created_by'  => $expense_data['created_by'],
                    'updated_at'  => $expense_data['updated_at'],
                    'updated_by'  => $expense_data['updated_by'],
                ]
            );
    }

    /**
     * Insert Expense from account data into ledger
     *
     * @param array $expense_data Expense Data
     *
     * @return void
     */
    public function insertSourceExpenseDataIntoLedger($expense_data)
    {


        if (1 === $expense_data['status'] && (isset($expense_data['trn_by']) && 4 === $expense_data['trn_by'])) {
            return;
        }

        // Insert amount in ledger_details
        DB::table('erp_acct_ledger_details')
            ->insert(
                [
                    'ledger_id'   => $expense_data['trn_by_ledger_id'],
                    'trn_no'      => $expense_data['voucher_no'],
                    'particulars' => $expense_data['particulars'],
                    'debit'       => 0,
                    'credit'      => $expense_data['amount'],
                    'trn_date'    => $expense_data['trn_date'],
                    'created_at'  => $expense_data['created_at'],
                    'created_by'  => $expense_data['created_by'],
                    'updated_at'  => $expense_data['updated_at'],
                    'updated_by'  => $expense_data['updated_by'],
                ]
            );
    }

    /**
     * Get check data of a expense
     *
     * @param int $expense_no Expense Number
     *
     * @return mixed
     */
    public function getCheckDataOfExpense($expense_no)
    {


        $sql = "SELECT
                cheque.bank,
                cheque.check_no,
                cheque.trn_no,
                cheque.name,
                cheque.pay_to,
                cheque.bank,
                cheque.amount,

                ledg_detail.debit,
                ledg_detail.credit

            FROM erp_acct_expense_checks AS cheque
            LEFT JOIN erp_acct_ledger_details AS ledg_detail ON cheque.trn_no = ledg_detail.trn_no

            WHERE cheque.trn_no = {$expense_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select($sql);

        $row = (!empty($row)) ? $row[0] : null;


        return $row;
    }
}
