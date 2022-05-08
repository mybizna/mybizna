<?php

namespace Modules\Account\Classes\Reports;

use Illuminate\Support\Facades\DB;
/**
 * Trial Balance
 */
class TrialBalance
{

    /**
     * Trial balance helper
     *
     * @param array $args
     *
     * @return int
     */
    function cashAtBank($args, $type)
    {
       

        $balance = 0;
        $result  = 0;

        $chart_bank = 7;

        $sql1       = $wpdb->prepare("SELECT group_concat(id) FROM {$wpdb->prefix}erp_acct_ledgers where chart_id = %d", $chart_bank);
        $ledger_ids = implode(',', explode(',', $wpdb->get_var($sql1))); // e.g. 4, 5

        if ($ledger_ids) {
            $sql2 = "SELECT SUM(ledger_details.balance) as balance from (SELECT SUM( debit - credit ) AS balance
        FROM {$wpdb->prefix}erp_acct_ledger_details WHERE ledger_id IN ({$ledger_ids}) AND trn_date BETWEEN '%s' AND '%s'
        GROUP BY ledger_id) AS ledger_details";

            $data = $wpdb->get_var($wpdb->prepare($sql2, $args['start_date'], $args['end_date']));

            $balance = $this->bankCashCalcWithOpeningBalance($args['start_date'], $data, $sql2, $type);
        }

        if ('loan' === $type && $balance < 0) {
            $result = $balance;
        } elseif ('balance' === $type && $balance >= 0) {
            $result = $balance;
        }

        return $result;
    }

    /**
     * Trial balance helper
     *
     * @param array $args
     *
     * @return mixed
     */
    function bankBalance($args, $type)
    {
       

        $balance = null;

        $chart_bank = 7;

        $sql = "SELECT ledger.id, ledger.name, SUM( debit - credit ) AS balance
        FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
        LEFT JOIN {$wpdb->prefix}erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.chart_id = %d AND trn_date BETWEEN '%s' AND '%s' GROUP BY ledger.id";

        $data = $wpdb->get_results($wpdb->prepare($sql, $chart_bank, $args['start_date'], $args['end_date']), ARRAY_A);

        $balance = $this->bankBalanceCalcWithOpeningBalance($args['start_date'], $data, $sql, $type);

        return $balance;
    }

    /**
     * Trial balance helper
     *
     * @param array  $args
     * @param string $type
     *
     * @return int
     */
    function salesTaxQuery($args, $type)
    {
       

        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance FROM {$wpdb->prefix}erp_acct_tax_agency_details
        WHERE trn_date BETWEEN '%s' AND '%s' GROUP BY agency_id {$having} ) AS get_amount";

        $data = $wpdb->get_var($wpdb->prepare($sql, $args['start_date'], $args['end_date']));

        return $this->salesTaxCalcWithOpeningBalance($args['start_date'], $data, $sql, $type);
    }

    /**
     * Trial balance helper
     *
     * Get account receivable
     */
    function getAccountReceivable($args)
    {
       

        // mainly ( debit - credit )
        $sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance
            FROM {$wpdb->prefix}erp_acct_invoice_account_details WHERE trn_date BETWEEN '%s' AND '%s'
            GROUP BY invoice_no HAVING balance <> 0 )
        AS get_amount";

        $data = $wpdb->get_var($wpdb->prepare($sql, $args['start_date'], $args['end_date']));

        return $this->salesTaxCalcWithOpeningBalance($args, $data, 'receivable', $sql);
    }

    /**
     * Trial balance helper
     *
     * Get account payble
     */
    function getAccountPayable($args)
    {
       

        /**
         *? Why only bills, not expense?
         *? Expense is `direct expense`, and we don't include direct expense here
         */
        $bill_sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance FROM {$wpdb->prefix}erp_acct_bill_account_details WHERE trn_date <= '%s'
        GROUP BY bill_no HAVING balance < 0 )
        AS get_amount";

        $purchase_sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance FROM {$wpdb->prefix}erp_acct_purchase_account_details WHERE trn_date <= '%s'
        GROUP BY purchase_no HAVING balance <> 0 )
        AS get_amount";

        $bill_amount     = $wpdb->get_var($wpdb->prepare($bill_sql, $args['end_date']));
        $purchase_amount = $wpdb->get_var($wpdb->prepare($purchase_sql, $args['end_date']));

        $data = (float) $bill_amount + (float) $purchase_amount;

        return $this->salesTaxCalcWithOpeningBalance($args, $data, 'payable', $bill_sql, $purchase_sql);
    }

    /**
     * Trial balance helper
     *
     * Get owners equity
     */
    function getOwnersEquity($args, $type)
    {
       

        if ('capital' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('drawings' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM( debit - credit ) AS balance
        FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
        LEFT JOIN {$wpdb->prefix}erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.slug = 'owner_s_equity' AND trn_date BETWEEN '%s' AND '%s' GROUP BY ledger.id {$having}";

        $data = $wpdb->get_var($wpdb->prepare($sql, $args['start_date'], $args['end_date']));

        return $this->ownersEquityCalcWithOpeningBalance($args['start_date'], $data, $sql, $type);
    }

    /**
     * Check if date has min 2 days difference ( Trial balance helper )
     *
     * @param string $date1
     * @param string $date2
     *
     * @return bool
     */
    function hasDateDiff($date1, $date2)
    {
        $interval = date_diff(date_create($date1), date_create($date2));

        // if difference is `0` OR `1` day
        if ('2' > $interval->format('%a')) {
            return false;
        }

        return true;
    }

    /**
     * Calculate extra account receivable/payable
     *
     * @param string $sql
     * @param string $start_date
     * @param string $end_date
     *
     * @return float
     */
    function calculatePeopleBalance($sql, $start_date, $end_date)
    {
       

        $balance = 0;
        $query   = $wpdb->get_var($wpdb->prepare($sql, $start_date, $end_date));

        if ($query) {
            $balance += (float) $query;
        }

        return $balance;
    }

    /**
     * Get ledger balance with opening balance
     *
     * @param array $ledgers
     * @param array $data
     * @param array $opening_balance
     *
     * @return array
     */
    function getBalanceWithOpeningBalance($ledgers, $data, $opening_balance)
    {
        $temp_data = [];

        /*
     * Start writing a very `inefficient :(` foreach loop
     */
        foreach ($ledgers as $ledger) {
            $balance = 0;

            foreach ($data as $row) {
                if ($row['id'] === $ledger['id']) {
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
                    'id'       => $ledger['id'],
                    'chart_id' => $ledger['chart_id'],
                    'name'     => $ledger['name'],
                    'balance'  => $balance,
                ];
            }
        }

        return $temp_data;
    }

    /**
     * get ledger details data between
     * `financial year start date`
     * and
     * `previous date from trial balance start date`
     *
     * @return array
     */
    function getBalanceWithinLedgerDetailsAndTrialBalance($sql, $temp_data)
    {
       

        $result = [];

        $ledger_details = $wpdb->get_results($sql, ARRAY_A);

        if (!empty($temp_data)) {
            foreach ($temp_data as $temp) {
                $balance = $temp['balance'];

                foreach ($ledger_details as $detail) {
                    if ($temp['id'] === $detail['id']) {
                        $balance += (float) $detail['balance'];
                    }
                }

                $result[] = [
                    'id'       => $temp['id'],
                    'chart_id' => $temp['chart_id'],
                    'name'     => $temp['name'],
                    'balance'  => $balance,
                ];
            }
        } else {
            $result = $ledger_details;
        }

        return $result;
    }

    /**
     * Get trial balance calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date
     * @param array  $data          => ledger details data on trial balance date range
     * @param string $sql
     *
     * @return array
     */
    function calcWithOpeningBalance($tb_start_date, $data, $sql)
    {
       

        $result = [];

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance =$open_balance->openingBalanceByFnYearId($closest_fy_date['id']);

        $ledgers = $wpdb->get_results(
            "SELECT ledger.id, ledger.chart_id, ledger.name FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
                WHERE ledger.chart_id <> 7 AND ledger.slug <> 'owner_s_equity'",
            ARRAY_A
        );

        $temp_data = $this->getBalanceWithOpeningBalance($ledgers, $data, $opening_balance);

        // should we go further calculation, check the diff
        if (!erp_acct_has_date_diff($tb_start_date, $closest_fy_date['start_date'])) {
            return $temp_data;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        $sql = $wpdb->prepare(
            "SELECT
        ledger.id, ledger.name, SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
        LEFT JOIN {$wpdb->prefix}erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.chart_id NOT IN ( 4, 5, 7 ) AND ledger.slug <> 'owner_s_equity' AND ledger_detail.trn_date BETWEEN '%s' AND '%s' GROUP BY ledger_detail.ledger_id",
            $closest_fy_date['start_date'],
            $prev_date_of_tb_start
        );

        $result = $this->getBalanceWithinLedgerDetailsAndTrialBalance($sql, $temp_data);

        return $result;
    }

    /**
     * Get trial balance cash at bank calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date
     * @param array  $data          => ledger details data on trial balance date range
     * @param string $sql
     * @param string $type
     *
     * @return float
     */
    function bankCashCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {
       

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->bankCashOpeningBalanceByFnYearId($closest_fy_date['id']);

        $balance = (float) $data;

        foreach ($opening_balance as $op_balance) {
            $balance += (float) $op_balance['balance'];
        }

        // should we go further calculation, check the diff
        if (!erp_acct_has_date_diff($tb_start_date, $closest_fy_date['start_date'])) {
            return $balance;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        // get ledger details data between
        //     `financial year start date`
        // and
        //     `previous date from trial balance start date`
        $ledger_details_balance = $wpdb->get_var($wpdb->prepare($sql, $closest_fy_date['start_date'], $prev_date_of_tb_start));

        if ($ledger_details_balance) {
            $balance += (float) $ledger_details_balance;
        }

        return $balance;
    }

    /**
     * Get trial balance bank balance calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date
     * @param array  $data          => ledger details data on trial balance date range
     * @param string $sql
     * @param string $type
     *
     * @return array
     */
    function bankBalanceCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {
       

        $chart_bank = 7;

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->bankBalanceOpeningBalanceByFnYearId($closest_fy_date['id']);

        $ledgers = $wpdb->get_results("SELECT ledger.id, ledger.chart_id, ledger.name FROM {$wpdb->prefix}erp_acct_ledgers AS ledger WHERE ledger.chart_id = 7", ARRAY_A);

        $temp_data = $this->getBalanceWithOpeningBalance($ledgers, $data, $opening_balance);

        // should we go further calculation, check the diff
        if (!erp_acct_has_date_diff($tb_start_date, $closest_fy_date['start_date'])) {
            return $temp_data;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        $sql = $wpdb->prepare($sql, $chart_bank, $closest_fy_date['start_date'], $prev_date_of_tb_start);

        $result = $this->getBalanceWithinLedgerDetailsAndTrialBalance($sql, $temp_data);

        return $result;
    }

    /**
     * Get trial balance sales tax calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date
     * @param float  $data          => ledger details data on trial balance date range
     * @param string $sql
     * @param string $type
     *
     * @return float
     */
    function salesTaxCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {
       

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->salesTaxOpeningBalanceByFnYearId($closest_fy_date['id'], $type);

        $balance = (float) $data;

        foreach ($opening_balance as $op_balance) {
            $balance += (float) $op_balance['balance'];
        }

        // should we go further calculation, check the diff
        if (!erp_acct_has_date_diff($tb_start_date, $closest_fy_date['start_date'])) {
            return $balance;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        // get agency details data between
        //     `financial year start date`
        // and
        //     `previous date from trial balance start date`
        $ledger_details_balance = $wpdb->get_var($wpdb->prepare($sql, $closest_fy_date['start_date'], $prev_date_of_tb_start));

        if ($ledger_details_balance) {
            $balance += (float) $ledger_details_balance;
        }

        return $balance;
    }

    /**
     * Get trial balance people account_payable/account_receivable
     * calculate with opening balance within financial year date range
     * and with people account details data
     *
     * @param string $tb_start_date
     * @param float  $data          => ledger details data on trial balance date range
     * @param string $sql
     * @param string $type
     *
     * @return float
     */
    function peopleCalcWithOpeningBalance($tb_date, $data, $type, $sql1, $sql2 = null)
    {
       

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_date['start_date']);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->peopleOpeningBalanceByFnYearId($closest_fy_date['id'], $type);

        $balance = (float) $data;

        if (!empty($opening_balance)) {
            $balance += (float) $opening_balance;
        }

        // get people account details balance within trial balance end and financial year start date
        $people_account_details = $this->calcWithPeopleAccountDetails($closest_fy_date['start_date'], $tb_date['end_date'], $type);

        if (!empty($people_account_details)) {
            $balance += (float) $people_account_details;
        }

        return $balance;
    }

    /**
     * Calculate people balance from people account details
     *
     * @param string $tb_end_date
     * @param string $closest_fy_start_date
     * @param string $type
     *
     * @return void
     */
    function calcWithPeopleAccountDetails($closest_fy_start_date, $tb_end_date, $type)
    {
       

        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        // mainly ( debit - credit )
        $sql = "SELECT SUM(balance) AS amount FROM (
                SELECT SUM( debit - credit ) AS balance
                FROM {$wpdb->prefix}erp_acct_people_account_details WHERE trn_date BETWEEN '%s' AND '%s'
                GROUP BY people_id {$having} )
            AS get_amount";

        return $wpdb->get_var($wpdb->prepare($sql, $closest_fy_start_date, $tb_end_date));
    }

    /**
     * Get trial balance owners equity calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date
     * @param float  $data          => ledger details data on trial balance date range
     * @param string $sql
     * @param string $type
     *
     * @return float
     */
    function ownersEquityCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {
       

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->ownersEquityOpeningBalanceByFnYearId($closest_fy_date['id'], $type);

        $balance = (float) $data;

        if (!empty($opening_balance)) {
            $balance += (float) $opening_balance;
        }

        // should we go further calculation, check the diff
        if (!erp_acct_has_date_diff($tb_start_date, $closest_fy_date['start_date'])) {
            return $balance;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        // get ledger details data between
        //     `financial year start date`
        // and
        //     `previous date from trial balance start date`
        $ledger_details_balance = $wpdb->get_var($wpdb->prepare($sql, $closest_fy_date['start_date'], $prev_date_of_tb_start));

        if ($ledger_details_balance) {
            $balance += (float) $ledger_details_balance;
        }

        return $balance;
    }

    /**
     * Get closest date from financial year
     *
     * @param string $date
     *
     * @return string
     */
    function getClosestFnYearDate($date)
    {
       

        $sql = "SELECT id, name, start_date, end_date FROM {$wpdb->prefix}erp_acct_financial_years WHERE start_date <= '%s' ORDER BY start_date DESC LIMIT 1";

        return $wpdb->get_row($wpdb->prepare($sql, $date), ARRAY_A);
    }

    /**
     * Get opening balance data by financial year id
     *
     * @param int $id
     * @param int $chart_id ( optional )
     *
     * @return string
     */
    function openingBalanceByFnYearId($id, $chart_id = null)
    {
       

        $where = '';

        if ($chart_id) {
            $where = $wpdb->prepare('AND ledger.chart_id = %d', $chart_id);
        }

        $sql = "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance
        FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
        LEFT JOIN {$wpdb->prefix}erp_acct_opening_balances AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d {$where} AND opb.type = 'ledger' AND ledger.slug <> 'owner_s_equity'
        GROUP BY opb.ledger_id";

        return $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
    }

    /**
     * Get bank opening balance data by financial year id
     *
     * @param int    $id
     * @param string $type
     *
     * @return array
     */
    function bankCashOpeningBalanceByFnYearId($id)
    {
       

        $sql = "SELECT SUM(opb.balance) AS balance FROM (SELECT SUM( debit - credit ) AS balance
            FROM {$wpdb->prefix}erp_acct_opening_balances WHERE financial_year_id = %d AND chart_id = 7
            GROUP BY ledger_id) AS opb";

        return $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
    }

    /**
     * Get bank opening balance data by financial year id
     *
     * @param int    $id
     * @param string $type
     *
     * @return array
     */
    function salesTaxOpeningBalanceByFnYearId($id, $type)
    {
       

        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(opb.balance) AS balance FROM ( SELECT SUM( debit - credit ) AS balance
            FROM {$wpdb->prefix}erp_acct_opening_balances
            WHERE financial_year_id = %d AND type = 'tax_agency' GROUP BY ledger_id {$having} ) AS opb";

        return $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
    }

    /**
     * Get bank balance opening balance data by financial year id
     *
     * @param int    $id
     * @param string $type
     *
     * @return array
     */
    function bankBalanceOpeningBalanceByFnYearId($id)
    {
       

        $sql = "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance
        FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
        LEFT JOIN {$wpdb->prefix}erp_acct_opening_balances AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d AND ledger.chart_id = 7 GROUP BY opb.ledger_id";

        return $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
    }

    /**
     * Get bank balance opening balance data by financial year id
     *
     * @param int    $id
     * @param string $type
     *
     * @return mixed
     */
    function ownersEquityOpeningBalanceByFnYearId($id, $type)
    {
       

        if ('capital' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('drawings' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(opb.debit - opb.credit) AS balance
        FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
        LEFT JOIN {$wpdb->prefix}erp_acct_opening_balances AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d AND opb.type = 'ledger' AND ledger.slug = 'owner_s_equity' {$having}";

        return $wpdb->get_var($wpdb->prepare($sql, $id));
    }

    function peopleOpeningBalanceByFnYearId($id, $type)
    {
       

        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(opb.balance) AS balance FROM ( SELECT SUM( debit - credit ) AS balance
        FROM {$wpdb->prefix}erp_acct_opening_balances
        WHERE financial_year_id = %d AND type = 'people' GROUP BY ledger_id {$having} ) AS opb";

        return $wpdb->get_var($wpdb->prepare($sql, $id));
    }

    /**
     * Get trial balance
     *
     * @return mixed
     */
    function getTrialBalance($args)
    {
       

        $sql = "SELECT ledger.id, ledger.chart_id, ledger.name, SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
        LEFT JOIN {$wpdb->prefix}erp_acct_ledger_details AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.chart_id <> 7 AND ledger.slug <> 'owner_s_equity' AND ledger_detail.trn_date BETWEEN '%s' AND '%s' GROUP BY ledger_detail.ledger_id";

        $data = $wpdb->get_results($wpdb->prepare($sql, $args['start_date'], $args['end_date']), ARRAY_A);

        // All calculated DB results are inside `rows` key
        $results['rows'] = $this->calcWithOpeningBalance($args['start_date'], $data, $sql);

        /*
     * Let's create some virtual ledgers
     */
        $final_accounts    = new \WeDevs\ERP\Accounting\Includes\Classes\Final_Accounts($args);

        $results['rows'][] = [
            'chart_id'   => '1',
            'name'       => 'Cash at Bank',
            'balance'    =>  $final_accounts->cash_at_bank,
            'additional' =>  $final_accounts->cash_at_bank_breakdowns
        ];

        $results['rows'][] = [
            'chart_id'   => '2',
            'name'       => 'Bank Loan',
            'balance'    => $final_accounts->loan_at_Bank,
            'additional' => $final_accounts->loan_at_bank_breakdowns
        ];

        $results['rows'][] = [
            'chart_id' => '2',
            'name'     => 'Sales Tax Payable',
            'balance'  => $this->salesTaxQuery($args, 'payable'),
        ];
        $results['rows'][] = [
            'chart_id' => '1',
            'name'     => 'Sales Tax Receivable',
            'balance'  => $this->salesTaxQuery($args, 'receivable'),
        ];

        $results['rows'][] = [
            'chart_id' => '2',
            'name'     => 'Accounts Payable',
            'balance'  => $this->getAccountPayable($args),
        ];
        $results['rows'][] = [
            'chart_id' => '1',
            'name'     => 'Accounts Receivable',
            'balance'  => $this->getAccountReceivable($args),
        ];

        /**
         * Owner's equity
         */
        $capital     = $this->getOwnersEquity($args, 'capital');
        $drawings    = $this->getOwnersEquity($args, 'drawings');
        $new_capital = $capital + $drawings;

        $closest_fy_date       = $this->getClosestFnYearDate($args['start_date']);
        $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($args['start_date'])));

        // Owner's Equity calculation with income statement profit/loss
        $inc_statmnt_range = [
            'start_date' => $closest_fy_date['start_date'],
            'end_date'   => $prev_date_of_tb_start,
        ];

        $income_statement_balance = $reports->getIncomeStatement($inc_statmnt_range);

        $new_capital = $new_capital - $income_statement_balance['raw_balance'];

        if (0 < $new_capital) {
            $results['rows'][] = [
                'chart_id' => '3',
                'name'     => 'Owner\'s Drawings',
                'balance'  => $new_capital,
            ];
        } else {
            $results['rows'][] = [
                'chart_id' => '3',
                'name'     => 'Owner\'s Capital',
                'balance'  => $new_capital,
            ];
        }

        // Totals are inside the root `result` array
        $results['total_debit']  = 0;
        $results['total_credit'] = 0;

        $grouped = [];

        // Add-up all debit and credit
        foreach ($results['rows'] as $key => $result) {
            if (!empty($result['balance'])) {
                if ($result['balance'] > 0) {
                    $results['total_debit'] += $result['balance'];
                } else {
                    $results['total_credit'] += $result['balance'];
                }

                $grouped[$result['chart_id']][$key] = $result;
            }
        }

        ksort($grouped, SORT_NUMERIC);

        $results['rows'] = $grouped;

        return $results;
    }
}
