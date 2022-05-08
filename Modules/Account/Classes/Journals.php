<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;

class Journals
{

    /**
     * Get all journals
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

        $args = wp_parse_args($args, $defaults);

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

            $sql .= " FROM {$wpdb->prefix}erp_acct_journals AS journal LEFT JOIN {$wpdb->prefix}erp_acct_journal_details AS journal_detail";
            $sql .= " ON journal.voucher_no = journal_detail.trn_no {$where} GROUP BY journal.voucher_no ORDER BY journal.{$args['orderby']} {$args['order']} {$limit}";

            if ($args['count']) {
                $wpdb->get_results($sql);

                $journals_count = $wpdb->num_rows;

                wp_cache_set($cache_key_count, $journals_count, 'erp-accounting');
            } else {
                $journals = $wpdb->get_results($sql, ARRAY_A);

                wp_cache_set($cache_key, $journals, 'erp-accounting');
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
     * @param $journal_no
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

            FROM {$wpdb->prefix}erp_acct_journals as journal
            LEFT JOIN {$wpdb->prefix}erp_acct_journal_details as journal_detail ON journal.voucher_no = journal_detail.trn_no
            WHERE journal.voucher_no = {$journal_no} LIMIT 1";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row                = $wpdb->get_row($sql, ARRAY_A);
        $rows               = $row;
        $rows['line_items'] = $this->formatJournalData($row, $journal_no);

        return $rows;
    }

    /**
     * Insert journal data
     *
     * @param $data
     *
     * @return mixed
     */
    function insertJournal($data)
    {
       

        $created_by         =auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        $voucher_no = null;
        $currency   = $common->getCurrency(true);

        try {
            $wpdb->query('START TRANSACTION');

            $wpdb->insert(
                'erp_acct_voucher_no',
                [
                    'type'       => 'journal',
                    'currency'   => $currency,
                    'created_at' => $data['created_at'],
                    'created_by' => $data['created_by'],
                    'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : '',
                    'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : '',
                ]
            );

            $voucher_no = $wpdb->insert_id;

            $journal_data = $this->getFormattedJournalData($data, $voucher_no);

            $wpdb->insert(
                'erp_acct_journals',
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
                $wpdb->insert(
                    'erp_acct_journal_details',
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

                $wpdb->insert(
                    'erp_acct_ledger_details',
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

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('journal-exception', $e->getMessage());
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
       

        $updated_by         =auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        try {
            $wpdb->query('START TRANSACTION');

            $journal_data = $journals->getFormattedJournalData($data, $journal_no);

            $wpdb->update(
                'erp_acct_journals',
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
                ],
                [
                    'voucher_no' => $journal_no,
                ]
            );

            $items = $journal_data['line_items'];

            foreach ($items as $key => $item) {
                $wpdb->update(
                    'erp_acct_journal_details',
                    [
                        'ledger_id'   => $item['ledger_id'],
                        'particulars' => empty($item['particulars']) ? $journal_data['particulars'] : $item['particulars'],
                        'debit'       => $item['debit'],
                        'credit'      => $item['credit'],
                        'created_at'  => $journal_data['created_at'],
                        'created_by'  => $journal_data['created_by'],
                        'updated_at'  => $journal_data['updated_at'],
                        'updated_by'  => $journal_data['updated_by'],
                    ],
                    [
                        'trn_no' => $journal_no,
                    ]
                );

                $wpdb->update(
                    'erp_acct_ledger_details',
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
                    ],
                    [
                        'trn_no' => $journal_no,
                    ]
                );
            }

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('journal-exception', $e->getMessage());
        }


        return $journal->updateInvoice($journal_no);
    }

    /**
     * Get formatted journal data
     *
     * @param $data
     * @param $voucher_no
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
     * @param $data
     * @param $voucher_no
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

            FROM {$wpdb->prefix}erp_acct_journals as journal
            LEFT JOIN {$wpdb->prefix}erp_acct_journal_details as journal_detail ON journal.voucher_no = journal_detail.trn_no
            WHERE journal.voucher_no = {$journal_no}";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $rows       = $wpdb->get_results($sql, ARRAY_A);
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
