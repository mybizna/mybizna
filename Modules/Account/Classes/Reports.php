<?php

namespace Modules\Account\Classes;


use Modules\Account\Classes\Reports\TrialBalance;

use Illuminate\Support\Facades\DB;

class Reports
{

    /**
     * ===================================================
     * Ledger Report
     * ===================================================
     */

    /**
     * get ledger report
     *
     * @param int    $ledger_id  Ledger Id 
     * @param string $start_date Start Date
     * @param string $end_date   End Date
     *
     * @return mixed
     */
    function getLedgerReport($ledger_id, $start_date, $end_date)
    {
        $trialbal = new TrialBalance();



        // get closest financial year id and start date
        $closest_fy_date = $trialbal->getClosestFnYearDate($start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = (float) $this->ledgerReportOpeningBalanceByFnYearId($closest_fy_date['id'], $ledger_id);

        // should we go further calculation, check the diff
        if (erp_acct_has_date_diff($start_date, $closest_fy_date['start_date'])) {
            $prev_date_of_start = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));

            $sql1 =
                "SELECT SUM(debit - credit) AS balance
            FROM erp_acct_ledger_details
            WHERE ledger_id = %d AND trn_date BETWEEN '%s' AND '%s' ORDER BY trn_date ASC";

            $prev_ledger_details = DB::scalar(
                $sql1,
                [
                    $ledger_id,
                    $closest_fy_date['start_date'],
                    $prev_date_of_start
                ]
            );
            $opening_balance += (float) $prev_ledger_details;
        }

        $raw_opening_balance = $opening_balance;

        // ledger details
        $sql2 =
            "SELECT
        trn_no, particulars, debit, credit, trn_date, created_at
        FROM erp_acct_ledger_details
        WHERE ledger_id = %d AND trn_date BETWEEN '%s' AND '%s' ORDER BY trn_date ASC";

        $wpdb->query("SET SESSION sql_mode='';");

        $details = DB::select($sql2, [
            $ledger_id,
            $start_date,
            $end_date
        ]);

        $total_debit  = 0;
        $total_credit = 0;

        foreach ($details as $key => $detail) {
            $total_debit += (float) $detail['debit'];
            $total_credit += (float) $detail['credit'];

            if ('0.00' === $detail['debit']) {
                // so we're working with credit
                $opening_balance = $opening_balance + (-(float) $detail['credit']);

                // after calculation with credit
                if ($opening_balance >= 0) {
                    // opening balance is positive
                    $details[$key]['balance'] = $opening_balance . ' Dr';
                } elseif ($opening_balance < 0) {
                    // opening balance is negative
                    $details[$key]['balance'] = abs($opening_balance) . ' Cr';
                }
            }

            if ('0.00' === $detail['credit']) {
                // so we're working with debit
                $opening_balance = $opening_balance + (float) $detail['debit'];

                // after calculation with debit
                if ($opening_balance >= 0) {
                    // opening balance is positive
                    $details[$key]['balance'] = $opening_balance . ' Dr';
                } elseif ($opening_balance < 0) {
                    // opening balance is negative
                    $details[$key]['balance'] = abs($opening_balance) . ' Cr';
                }
            }
        }

        // Assign opening balance as first row
        if ((float) $raw_opening_balance > 0) {
            $balance = $raw_opening_balance . ' Dr';
        } elseif ((float) $raw_opening_balance < 0) {
            $balance = abs($raw_opening_balance) . ' Cr';
        } else {
            $balance = '0 Dr';
        }

        array_unshift(
            $details,
            [
                'trn_no'      => null,
                'particulars' => 'Opening Balance =',
                'debit'       => null,
                'credit'      => null,
                'trn_date'    => $start_date,
                'balance'     => $balance,
                'created_at'  => null,
            ]
        );

        return [
            'details' => $details,
            'extra'   => [
                'total_debit'  => $total_debit,
                'total_credit' => $total_credit,
            ],
        ];
    }

    /**
     * Ledger report opening balance helper
     *
     * @param int $id        Id
     * @param int $ledger_id Ledger Id
     *
     * @return string|null
     */
    function ledgerReportOpeningBalanceByFnYearId($id, $ledger_id)
    {


        $sql = "SELECT SUM(debit - credit) AS balance FROM erp_acct_opening_balances
        WHERE financial_year_id = %d AND ledger_id = %d AND type = 'ledger' GROUP BY ledger_id";

        return DB::scalar($sql, [$id, $ledger_id]);
    }

    /**
     * ===================================================
     * Sales Tax Report
     * ===================================================
     */

    /**
     * Get sales tax report
     *
     * @param int    $agency_id  Agency Id
     * @param string $start_date Start Date
     * @param string $end_date   End Date
     *
     * @return mixed
     */
    function getSalesTaxReport($agency_id, $start_date, $end_date)
    {


        // opening balance
        $sql1 =
            "SELECT SUM(debit - credit) AS opening_balance
        FROM erp_acct_tax_agency_details
        WHERE agency_id = {$agency_id} AND trn_date < '{$start_date}'";

        $db_opening_balance = DB::scalar($sql1);
        $opening_balance    = (float) $db_opening_balance;

        // agency details
        $details = DB::select("SELECT trn_no, particulars, debit, credit, trn_date, created_at FROM erp_acct_tax_agency_details WHERE agency_id = %d AND trn_date BETWEEN '%s' AND '%s'", [$agency_id, $start_date, $end_date]);

        $total_debit  = 0;
        $total_credit = 0;

        // Please refactor me
        foreach ($details as $key => $detail) {
            $total_debit += (float) $detail['debit'];
            $total_credit += (float) $detail['credit'];

            if ('0.00' === $detail['debit']) {
                // so we're working with credit
                if ($opening_balance < 0) {
                    // opening balance is negative
                    $opening_balance            = $opening_balance + (-(float) $detail['credit']);
                    $details[$key]['balance'] = abs($opening_balance) . ' Cr';
                } elseif ($opening_balance >= 0) {
                    // opening balance is positive
                    $opening_balance = $opening_balance + (-(float) $detail['credit']);

                    // after calculation with credit
                    if ($opening_balance >= 0) {
                        $details[$key]['balance'] = $opening_balance . ' Dr';
                    } elseif ($opening_balance < 0) {
                        $details[$key]['balance'] = abs($opening_balance) . ' Cr';
                    }
                } else {
                    // opening balance is 0
                    $details[$key]['balance'] = '0 Dr';
                }
            }

            if ('0.00' === $detail['credit']) {
                // so we're working with debit

                if ($opening_balance < 0) {
                    // opening balance is negative
                    $opening_balance            = $opening_balance + (float) $detail['debit'];
                    $details[$key]['balance'] = abs($opening_balance) . ' Cr';
                } elseif ($opening_balance >= 0) {
                    // opening balance is positive
                    $opening_balance = $opening_balance + (float) $detail['debit'];

                    // after calculation with debit
                    if ($opening_balance >= 0) {
                        $details[$key]['balance'] = $opening_balance . ' Dr';
                    } elseif ($opening_balance < 0) {
                        $details[$key]['balance'] = abs($opening_balance) . ' Cr';
                    }
                } else {
                    // opening balance is 0
                    $details[$key]['balance'] = '0 Dr';
                }
            }
        }

        // Assign opening balance as first row
        if ((float) $db_opening_balance > 0) {
            $balance = $db_opening_balance . ' Dr';
        } elseif ((float) $db_opening_balance < 0) {
            $balance = abs($db_opening_balance) . ' Cr';
        } else {
            $balance = '0 Dr';
        }

        array_unshift(
            $details,
            [
                'trn_no'      => null,
                'particulars' => 'Opening Balance =',
                'debit'       => null,
                'credit'      => null,
                'trn_date'    => $start_date,
                'balance'     => $balance,
                'created_at'  => null,
            ]
        );

        return [
            'details' => $details,
            'extra'   => [
                'total_debit'  => $total_debit,
                'total_credit' => $total_credit,
            ],
        ];
    }

    /**
     * Generates filter wise sales tax report
     *
     * @param array $args Sales Tax Filter
     *
     * @return array
     */
    function getFilteredSalesTaxReport($args)
    {


        if (empty($args['start_date']) || empty($args['end_date'])) {
            return [];
        }

        $sql['from']  = "erp_acct_invoices AS inv";
        $sql['where'] = "inv.trn_date BETWEEN '%s' AND '%s'";
        $sql['extra'] = '';
        $values       = [$args['start_date'], $args['end_date']];

        if (!empty($args['customer_id'])) {

            $sql['select'] = 'inv.trn_date, inv.voucher_no, inv.tax AS tax_amount, inv.customer_id, inv.customer_name';
            $sql['where'] .= " AND inv.tax > 0 AND inv.customer_id = %d";
            $values[]      = $args['customer_id'];
        } else if (!empty($args['category_id'])) {

            $sql['select'] = 'inv.trn_date, details.trn_no AS voucher_no, sum(details.tax) AS tax_amount, details.tax_cat_id';
            $sql['from']  .= " RIGHT JOIN erp_acct_invoice_details AS details ON inv.voucher_no = details.trn_no";
            $sql['where'] .= " AND details.tax > 0 AND details.tax_cat_id = %d";
            $sql['extra'] .= "GROUP BY details.trn_no";
            $values[]      = $args['category_id'];
        } else {

            $sql['select'] = 'inv.trn_date, inv.voucher_no, inv.tax AS tax_amount';
            $sql['where'] .= " AND inv.tax > 0";
        }

        return DB::select(
                "SELECT {$sql['select']} FROM {$sql['from']} WHERE {$sql['where']} {$sql['extra']}",
                [$values]
        );
    }

    /**
     * ===================================================
     * Income Statement
     * ===================================================
     */

    /**
     * Get income statement
     * 
     * @param array $args Income Statement Filter
     * 
     * @return array
     */
    function getIncomeStatement($args)
    {


        $results = $this->getProfitLoss($args);

        if ($results['income'] >= abs($results['expense'])) {
            $results['profit']      = $results['income'] - $results['expense'];
            $results['raw_balance'] = $results['profit'];
        } else {
            $results['loss']        = $results['income'] - $results['expense'];
            $results['raw_balance'] = $results['loss'];
        }

        $results['balance'] = isset($results['profit']) ? $results['profit'] : $results['loss'];

        return $results;
    }

    /**
     * Income statement with opening balance helper
     *
     * @param boolean $is_start_date Start Date
     * @param array   $data          Data
     * @param string  $sql           SQL
     * @param int     $chart_id      Chart ID
     *
     * @return array
     */
    function incomeStatementCalculateWithOpeningBalance($is_start_date, $data, $sql, $chart_id)
    {

        $trialbal = new TrialBalance();



        // get closest financial year id and start date
        $closest_fy_date = $trialbal->getClosestFnYearDate($is_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->isOpeningBalanceByFnYearId($closest_fy_date['id'], $chart_id);

        $ledgers   = DB::select("SELECT ledger.id, ledger.name FROM erp_acct_ledgers AS ledger WHERE ledger.chart_id = %d", [$chart_id]);
        $temp_data = $this->getIsBalanceWithOpeningBalance($ledgers, $data, $opening_balance);
        $result    = [];

        if (!erp_acct_has_date_diff($is_start_date, $closest_fy_date['start_date'])) {
            return $temp_data;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($is_start_date)));
        }

        // should we go further calculation, check the diff
        $date1    = date_create($is_start_date);
        $date2    = date_create($closest_fy_date['start_date']);
        $interval = date_diff($date1, $date2);

        // if difference is `0` OR `1` day
        if ('2' > $interval->format('%a')) {
            return $temp_data;
        } else {
            // get previous date from balance sheet start date
            $date_before_balance_sheet_start = date('Y-m-d', strtotime('-1 day', strtotime($is_start_date)));
            $is_date                         = $date_before_balance_sheet_start;
        }

        // get ledger details data between `financial year start date` and `previous date from balance sheet start date`
        $ledger_details = DB::select(
            $sql, [$closest_fy_date['start_date'], $is_date),
        );

        foreach ($temp_data as $temp) {
            $balance = $temp['balance'];

            foreach ($ledger_details as $detail) {
                if ($temp['id'] === $detail['id']) {
                    $balance += (float) $detail['balance'];
                }
            }

            $result[] = [
                'id'      => $temp['id'],
                'name'    => $temp['name'],
                'balance' => $balance,
            ];
        }

        return $result;
    }

    /**
     * Get income statement ledger balance with opening balance
     *
     * @param array $ledgers         Ledger List
     * @param array $data            Data
     * @param array $opening_balance Opening Balance
     *
     * @return array
     */
    function getIsBalanceWithOpeningBalance($ledgers, $data, $opening_balance)
    {
        $temp_data = [];

        foreach ($ledgers as $ledger) {
            $balance = 0;

            foreach ($data as $row) {
                if ($row['balance'] && $row['id'] === $ledger['id']) {
                    $balance += (float) abs($row['balance']);
                }
            }

            foreach ($opening_balance as $op_balance) {
                if ($op_balance['id'] === $ledger['id']) {
                    $balance += (float) abs($op_balance['balance']);
                }
            }

            if ($balance) {
                $temp_data[] = [
                    'id'      => $ledger['id'],
                    'name'    => $ledger['name'],
                    'balance' => $balance,
                ];
            }
        }

        return $temp_data;
    }

    /**
     * Get income statement opening balance data by financial year id
     *
     * @param int $id       Id
     * @param int $chart_id Chart Id ( optional )
     *
     * @return array
     */
    function isOpeningBalanceByFnYearId($id, $chart_id)
    {


        $where = '';

        if ($chart_id) {
            $where = 'AND ledger.chart_id = ' . $chart_id;
        }

        $sql = "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_opening_balances AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d {$where} AND opb.type = 'ledger' AND ledger.slug <> 'owner_s_equity'
        GROUP BY opb.ledger_id";

        return DB::select($sql, [$id]);
    }

    /**
     * ===================================================
     * Balance Sheet
     * ===================================================
     */

    /**
     * Get balance sheet
     *
     * @param array $args Balance Sheet Filter
     *
     * @return mixed
     */
    function getBalanceSheet($args)
    {
        $trialbal = new TrialBalance();



        if (empty($args['start_date'])) {
            $args['start_date'] = date('Y-m-d', strtotime('first day of this month'));
        }

        if (empty($args['end_date'])) {
            $args['end_date'] = date('Y-m-d', strtotime('last day of this month'));
        }

        if (empty($args['start_date']) && empty($args['end_date'])) {
            $args['start_date'] = date('Y-m-d', strtotime('first day of this month'));
            $args['end_date']   = date('Y-m-d', strtotime('last day of this month'));
        }

        $sql1 = "SELECT
        ledger.id,
        ledger.name,
        SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id WHERE ledger.chart_id=1 AND ledger_detail.trn_date BETWEEN '%s' AND '%s'
        GROUP BY ledger_detail.ledger_id";

        $sql2 = "SELECT
        ledger.id,
        ledger.name,
        SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id WHERE ledger.chart_id=2 AND ledger_detail.trn_date BETWEEN '%s' AND '%s'
        GROUP BY ledger_detail.ledger_id";

        $sql3 = "SELECT
        ledger.id,
        ledger.name,
        SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id WHERE ledger.chart_id=3 AND ledger.slug <> 'owner_s_equity' AND ledger_detail.trn_date BETWEEN '%s' AND '%s'
        GROUP BY ledger_detail.ledger_id";

        $data1 = DB::select($sql1, [$args['start_date'], $args['end_date']]);
        $data2 = DB::select($sql2, [$args['start_date'], $args['end_date']]);
        $data3 = DB::select($sql3, [$args['start_date'], $args['end_date']]);

        $results['rows1'] = $this->balanceSheetCalculateWithOpeningBalance($args['start_date'], $data1, $sql1, 1);
        $results['rows2'] = $this->balanceSheetCalculateWithOpeningBalance($args['start_date'], $data2, $sql2, 2);
        $results['rows3'] = $this->balanceSheetCalculateWithOpeningBalance($args['start_date'], $data3, $sql3, 3);

        $final_accounts   = new \WeDevs\ERP\Accounting\Includes\Classes\Final_Accounts($args);

        $results['rows1'][] = [
            'name'    => 'Accounts Receivable',
            'balance' => $trialbal->getAccountReceivable($args),
        ];

        $results['rows1'][] = [
            'name'    => 'Sales Tax Receivable',
            'slug'    => 'sales_tax',
            'balance' => $trialbal->salesTaxQuery($args, 'receivable'),
        ];

        $results['rows1'][] = [
            'name'       => 'Cash at Bank',
            'balance'    => $final_accounts->cash_at_bank,
            'additional' => $final_accounts->cash_at_bank_breakdowns,
        ];

        $results['rows2'][] = [
            'name'    => 'Accounts Payable',
            'balance' => $trialbal->getAccountPayable($args),
        ];

        $results['rows2'][] = [
            'name'       => 'Bank Loan',
            'balance'    => $final_accounts->loan_at_Bank,
            'additional' => $final_accounts->loan_at_bank_breakdowns,
        ];

        $results['rows2'][] = [
            'name'    => 'Sales Tax Payable',
            'slug'    => 'sales_tax',
            'balance' => $trialbal->salesTaxQuery($args, 'payable'),
        ];

        $ledger_map        = \WeDevs\ERP\Accounting\Includes\Classes\Ledger_Map::get_instance();
        $owner_s_equity_id = $ledger_map->get_ledger_id_by_slug('owner_s_equity');

        $capital     = $trialbal->getOwnersEquity($args, 'capital');
        $drawings    = $trialbal->getOwnersEquity($args, 'drawings');
        $new_capital = $capital + $drawings;

        $closest_fy_date       = $trialbal->getClosestFnYearDate($args['start_date']);
        $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($args['start_date'])));

        // Owner's Equity calculation with income statement profit/loss
        $inc_statmnt_range = [
            'start_date' => $closest_fy_date['start_date'],
            'end_date'   => $prev_date_of_tb_start,
        ];

        $income_statement_balance = $this->getIncomeStatement($inc_statmnt_range);

        $new_capital = $new_capital - $income_statement_balance['raw_balance'];

        if (0 < $new_capital) {
            $results['rows3'][] = [
                'id'      => $owner_s_equity_id,
                'name'    => 'Owner\'s Drawings',
                'balance' => $new_capital,
            ];
        } else {
            $results['rows3'][] = [
                'id'      => $owner_s_equity_id,
                'name'    => 'Owner\'s Capital',
                'balance' => $new_capital,
            ];
        }

        $profit_loss = $this->getIncomeStatement($args);

        if (!empty($profit_loss['profit'])) {
            $results['rows3'][] = [
                'name'    => 'Profit',
                'slug'    => 'profit',
                'balance' => -$profit_loss['profit'],
            ];
        }

        if (!empty($profit_loss['loss'])) {
            $results['rows3'][] = [
                'name'    => 'Loss',
                'slug'    => 'loss',
                'balance' => -$profit_loss['loss'],
            ];
        }

        $results['total_asset']     = 0;
        $results['total_equity']    = 0;
        $results['total_liability'] = 0;

        foreach ($results['rows1'] as $result) {
            if (!is_numeric($result['balance'])) {
                continue;
            }

            if (!empty($result['balance'])) {
                $results['total_asset'] += (float) $result['balance'];
            }
        }

        foreach ($results['rows2'] as $result) {
            if (!is_numeric($result['balance'])) {
                continue;
            }

            if (!empty($result['balance'])) {
                $results['total_liability'] += (float) $result['balance'];
            }
        }

        foreach ($results['rows3'] as $result) {
            if (isset($results['slug']) && 'loss' !== $results['slug']) {
                $result['balance'] = abs($result['balance']);
            }

            if (!empty($result['balance'])) {
                if (!is_numeric((float) $result['balance'])) {
                    continue;
                }
                $results['total_equity'] += (float) $result['balance'];
            }
        }

        $profit = 0;
        $loss   = 0;

        if (!empty($profit_loss['profit'])) {
            $profit = $profit_loss['profit'];
        } elseif (!empty($profit_loss['loss'])) {
            $loss = $profit_loss['loss'];
        }

        $results['owners_equity'] = abs($capital) - abs($drawings) + abs($profit) - abs($loss);

        return $results;
    }

    /**
     * Balance sheet with opening balance helper
     *
     * @param boolean $bs_start_date Start Date
     * @param array   $data          Data
     * @param string  $sql           Sql
     * @param int     $chart_id      Chart Id
     * 
     * @return array
     */
    function balanceSheetCalculateWithOpeningBalance($bs_start_date, $data, $sql, $chart_id)
    {
        $trialbal = new TrialBalance();



        // get closest financial year id and start date
        $closest_fy_date = $trialbal->getClosestFnYearDate($bs_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->bsOpeningBalanceByFnYearId($closest_fy_date['id'], $chart_id);

        $ledger_sql = "SELECT
        ledger.id, ledger.name
        FROM erp_acct_ledgers AS ledger
        WHERE ledger.chart_id={$chart_id} AND ledger.slug <> 'owner_s_equity'";

        $ledgers   = DB::select($ledger_sql, ARRAY_A);
        $temp_data = $this->getBsBalanceWithOpeningBalance($ledgers, $data, $opening_balance);
        $result    = [];

        if (!erp_acct_has_date_diff($bs_start_date, $closest_fy_date['start_date'])) {
            return $temp_data;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($bs_start_date)));
        }

        // should we go further calculation, check the diff
        $date1    = date_create($bs_start_date);
        $date2    = date_create($closest_fy_date['start_date']);
        $interval = date_diff($date1, $date2);

        // if difference is `0` OR `1` day
        if ('2' > $interval->format('%a')) {
            return $temp_data;
        } else {
            // get previous date from balance sheet start date
            $date_before_balance_sheet_start = date('Y-m-d', strtotime('-1 day', strtotime($bs_start_date)));
            $bs_date                         = $date_before_balance_sheet_start;
        }

        // get ledger details data between `financial year start date` and `previous date from balance sheet start date`
        $ledger_details = DB::select(
            $sql, [$closest_fy_date['start_date'], $bs_date]
        );

        foreach ($temp_data as $temp) {
            $balance = $temp['balance'];

            foreach ($ledger_details as $detail) {
                if ($temp['id'] === $detail['id']) {
                    $balance += (float) $detail['balance'];
                }
            }

            $result[] = [
                'id'      => $temp['id'],
                'name'    => $temp['name'],
                'balance' => $balance,
            ];
        }

        return $result;
    }

    /**
     * Get ledger balance with opening balance
     *
     * @param array $ledgers         Ledger
     * @param array $data            Data
     * @param array $opening_balance Opening Balance
     *
     * @return array
     */
    function getBsBalanceWithOpeningBalance($ledgers, $data, $opening_balance)
    {
        $temp_data = [];

        foreach ($ledgers as $ledger) {
            $balance = 0;

            foreach ($data as $row) {
                if ($row['balance'] && $row['id'] === $ledger['id']) {
                    $balance += (float) $row['balance'];
                }
            }

            foreach ($opening_balance as $op_balance) {
                if ($op_balance['id'] === $ledger['id']) {
                    $balance += (float) $op_balance['balance'];
                }
            }

            if ($balance) {
                $temp_data[] = [
                    'id'      => $ledger['id'],
                    'name'    => $ledger['name'],
                    'balance' => $balance,
                ];
            }
        }

        return $temp_data;
    }

    /**
     * Get opening balance data by financial year id
     *
     * @param int $id       Id
     * @param int $chart_id Chart Id ( optional )
     *
     * @return array
     */
    function bsOpeningBalanceByFnYearId($id, $chart_id)
    {


        $where = '';

        if ($chart_id) {
            $where = 'AND ledger.chart_id = '.$chart_id;
        }

        $sql = "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_opening_balances AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d {$where} AND opb.type = 'ledger' AND ledger.slug <> 'owner_s_equity'
        GROUP BY opb.ledger_id";

        return DB::select($sql, [$id]);
    }

    /**
     * Get profit-loss
     *
     * @param array $args Profit Loss Filter
     *
     * @return array
     */
    function getProfitLoss($args)
    {
        $trialbal = new TrialBalance();



        if (empty($args['start_date'])) {
            $args['start_date'] = date('Y-m-d', strtotime('first day of january'));
        } else {
            $closest_fy_date    = $trialbal->getClosestFnYearDate($args['start_date']);
            $args['start_date'] = $closest_fy_date['start_date'];
        }

        if (empty($args['end_date'])) {
            $args['end_date'] = date('Y-m-d', strtotime('last day of this month'));
        }

        if (empty($args['start_date']) && empty($args['end_date'])) {
            $args['start_date'] = date('Y-m-d', strtotime('first day of january'));
            $args['end_date']   = date('Y-m-d', strtotime('last day of this month'));
        }

        $sql1 = "SELECT
        ledger.id,
        ledger.name,
        SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id WHERE ledger.chart_id=4 AND ledger_detail.trn_date BETWEEN '%s' AND '%s'
        GROUP BY ledger_detail.ledger_id";

        $sql2 = "SELECT
        ledger.id,
        ledger.name,
        SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id WHERE ledger.chart_id=5 AND ledger_detail.trn_date BETWEEN '%s' AND '%s'
        GROUP BY ledger_detail.ledger_id";

        $data1 = DB::select($sql1, [$args['start_date'], $args['end_date']);
        $data2 = DB::select($sql2, [$args['start_date'], $args['end_date']);

        $results['rows1'] = $this->incomeStatementCalculateWithOpeningBalance($args['start_date'], $data1, $sql1, 4);
        $results['rows2'] = $this->incomeStatementCalculateWithOpeningBalance($args['start_date'], $data2, $sql2, 5);

        $results['income']  = 0;
        $results['expense'] = 0;

        foreach ($results['rows1'] as $result) {
            $results['income'] += (float) $result['balance'];
        }

        foreach ($results['rows2'] as $result) {
            $results['expense'] += (float) $result['balance'];
        }

        return $results;
    }
}
