<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;

use Illuminate\Support\Facades\DB;

class Journals
{

    /**
     * Get all journals
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    function getAllJournals($args = [])
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

        $journals    = $journals_count  = false;


        if (false === $journals) {

            $where = '';
            $limit = '';

            if (!empty($args['start_date'])) {
                $where .= "WHERE journal.trn_date BETWEEN '{$args['start_date']}' AND '{$args['end_date']}'";
            }

            if ('-1' === $args['number']) {
                $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
            }

            $sql = 'SELECT';

            if ($args['count']) {
                $sql .= ' COUNT( DISTINCT journal.id ) as total_number';
            } else {
                $sql .= ' journal.*';
            }

            $sql .= " FROM erp_acct_journals AS journal LEFT JOIN erp_acct_journal_details AS journal_detail";
            $sql .= " ON journal.voucher_no = journal_detail.trn_no {$where} GROUP BY journal.voucher_no ORDER BY journal.{$args['orderby']} {$args['order']} {$limit}";

            if ($args['count']) {
                DB::select($sql);

                $journals_count = $wpdb->num_rows;
            } else {
                $journals = DB::select($sql);
            }
        }

        if ($args['count']) {
            return $journals_count;
        }

        return $journals;
    }

    /**
     * Get an single journal
     *
     * @param int $journal_no JNumber
     *
     * @return mixed
     */
    function getJournal($journal_no)
    {


        $sql = "SELECT

                journal.id,
                journal.voucher_no,
                journal.trn_date,
                journal.ref,
                journal.voucher_amount,
                journal.attachments,
                journal.particulars,
                journal.created_at,
                journal.created_by,
                journal.updated_at,
                journal.updated_by

            FROM erp_acct_journals as journal
            LEFT JOIN erp_acct_journal_details as journal_detail ON journal.voucher_no = journal_detail.trn_no
            WHERE journal.voucher_no = {$journal_no} LIMIT 1";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row                = DB::select($sql, ARRAY_A);

        $row = (!empty($row)) ? $row[0] : null;
        $rows               = $row;
        $rows['line_items'] = $this->formatJournalData($row, $journal_no);

        return $rows;
    }

    /**
     * Insert journal data
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    function insertJournal($data)
    {


        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        $voucher_no = null;
        $currency   = $common->getCurrency(true);

        try {
            DB::beginTransaction();

            $voucher_no =  DB::table('erp_acct_voucher_no')
                ->insertGetId(
                    [
                        'type'       => 'journal',
                        'currency'   => $currency,
                        'created_at' => $data['created_at'],
                        'created_by' => $data['created_by'],
                        'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : '',
                        'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : '',
                    ]
                );


            $journal_data = $this->getFormattedJournalData($data, $voucher_no);

            DB::table('erp_acct_journals')
                ->insert(
                    [
                        'voucher_no'     => $voucher_no,
                        'trn_date'       => $journal_data['trn_date'],
                        'ref'            => $journal_data['ref'],
                        'voucher_amount' => $journal_data['voucher_amount'],
                        'particulars'    => $journal_data['particulars'],
                        'attachments'    => $journal_data['attachments'],
                        'created_at'     => $journal_data['created_at'],
                        'created_by'     => $journal_data['created_by'],
                        'updated_at'     => $journal_data['updated_at'],
                        'updated_by'     => $journal_data['updated_by'],
                    ]
                );

            $items = $journal_data['line_items'];

            foreach ($items as $key => $item) {
                DB::table('erp_acct_journal_details')
                    ->insert(
                        [
                            'trn_no'      => $voucher_no,
                            'ledger_id'   => $item['ledger_id'],
                            'particulars' => empty($item['particulars']) ? $journal_data['particulars'] : $item['particulars'],
                            'debit'       => $item['debit'],
                            'credit'      => $item['credit'],
                            'created_at'  => $journal_data['created_at'],
                            'created_by'  => $journal_data['created_by'],
                            'updated_at'  => $journal_data['updated_at'],
                            'updated_by'  => $journal_data['updated_by'],
                        ]
                    );

                DB::table('erp_acct_ledger_details')
                    ->insert(
                        [
                            'ledger_id'   => $item['ledger_id'],
                            'trn_no'      => $voucher_no,
                            'particulars' => empty($item['particulars']) ? $journal_data['particulars'] : $item['particulars'],
                            'debit'       => $item['debit'],
                            'credit'      => $item['credit'],
                            'trn_date'    => $journal_data['trn_date'],
                            'created_at'  => $journal_data['created_at'],
                            'created_by'  => $journal_data['created_by'],
                            'updated_at'  => $journal_data['updated_at'],
                            'updated_by'  => $journal_data['updated_by'],
                        ]
                    );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('journal-exception', $e->getMessage());
            return;
        }


        return $this->getJournal($voucher_no);
    }

    /**
     * Update journal data
     *
     * @param $data
     *
     * @return int
     */
    function updateJournal($data, $journal_no)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            DB::beginTransaction();

            $journal_data = $journals->getFormattedJournalData($data, $journal_no);

            DB::table('erp_acct_journals')
                ->where('voucher_no', $journal_no)
                ->update(
                    [
                        'trn_date'       => $journal_data['trn_date'],
                        'ref'            => $journal_data['ref'],
                        'voucher_amount' => $journal_data['voucher_amount'],
                        'particulars'    => $journal_data['particulars'],
                        'attachments'    => $journal_data['attachments'],
                        'created_at'     => $journal_data['created_at'],
                        'created_by'     => $journal_data['created_by'],
                        'updated_at'     => $journal_data['updated_at'],
                        'updated_by'     => $journal_data['updated_by'],
                    ]
                );

            $items = $journal_data['line_items'];

            foreach ($items as $key => $item) {
                DB::table('erp_acct_journal_details')
                    ->where('trn_no', $journal_no)
                    ->update(
                        [
                            'ledger_id'   => $item['ledger_id'],
                            'particulars' => empty($item['particulars']) ? $journal_data['particulars'] : $item['particulars'],
                            'debit'       => $item['debit'],
                            'credit'      => $item['credit'],
                            'created_at'  => $journal_data['created_at'],
                            'created_by'  => $journal_data['created_by'],
                            'updated_at'  => $journal_data['updated_at'],
                            'updated_by'  => $journal_data['updated_by'],
                        ]
                    );

                DB::table('erp_acct_ledger_details')
                    ->where('trn_no', $journal_no)
                    ->update(
                        [
                            'ledger_id'   => $item['ledger_id'],
                            'particulars' => empty($item['particulars']) ? $journal_data['particulars'] : $item['particulars'],
                            'debit'       => $item['debit'],
                            'credit'      => $item['credit'],
                            'trn_date'    => $journal_data['trn_date'],
                            'created_at'  => $journal_data['created_at'],
                            'created_by'  => $journal_data['created_by'],
                            'updated_at'  => $journal_data['updated_at'],
                            'updated_by'  => $journal_data['updated_by'],
                        ]
                    );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            messageBag()->add('journal-exception', $e->getMessage());
            return;
        }


        return $journal->updateInvoice($journal_no);
    }

    /**
     * Get formatted journal data
     *
     * @param array $data       Data Filter
     * @param int   $voucher_no Voucher Number
     *
     * @return mixed
     */
    function getFormattedJournalData($data, $voucher_no)
    {
        $journal_data = [];

        $journal_data['voucher_no']     = !empty($voucher_no) ? $voucher_no : 0;
        $journal_data['trn_date']       = isset($data['date']) ? $data['date'] : date('Y-m-d');
        $journal_data['voucher_amount'] = isset($data['voucher_amount']) ? $data['voucher_amount'] : 0;
        $journal_data['line_items']     = isset($data['line_items']) ? $data['line_items'] : [];
        // translators: %s: voucher_no
        $journal_data['particulars'] = !empty($data['particulars']) ? $data['particulars'] : sprintf(__('Journal created with voucher no %s', 'erp'), $voucher_no);
        $journal_data['ref']         = isset($data['ref']) ? $data['ref'] : '';
        $journal_data['attachments'] = isset($data['attachments']) ? $data['attachments'] : '';
        $journal_data['created_at']  = isset($data['created_at']) ? $data['created_at'] : '';
        $journal_data['created_by']  = isset($data['created_by']) ? $data['created_by'] : '';
        $journal_data['updated_at']  = isset($data['updated_at']) ? $data['updated_at'] : '';
        $journal_data['updated_by']  = isset($data['updated_by']) ? $data['updated_by'] : '';

        return $journal_data;
    }

    /**
     *  Format journal data
     *
     * @param array $item       Data Filter
     * @param int   $journal_no Voucher Number
     *
     * @return mixed
     */
    function formatJournalData($item, $journal_no)
    {

        $ledger = new LedgerAccounts();

        $sql = "SELECT
                journal.id,
                journal_detail.trn_no,
                journal_detail.ledger_id,
                journal_detail.particulars,
                journal_detail.debit,
                journal_detail.credit

            FROM erp_acct_journals as journal
            LEFT JOIN erp_acct_journal_details as journal_detail ON journal.voucher_no = journal_detail.trn_no
            WHERE journal.voucher_no = {$journal_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $rows       = DB::select($sql);
        $line_items = [];

        foreach ($rows as $key => $item) {
            $line_items[$key]['ledger_id']   = $item['ledger_id'];
            $line_items[$key]['account']     = $ledger->getLedgerNameById($item['ledger_id']);
            $line_items[$key]['particulars'] = $item['particulars'];
            $line_items[$key]['debit']       = $item['debit'];
            $line_items[$key]['credit']      = $item['credit'];
        }

        return $line_items;
    }
}
