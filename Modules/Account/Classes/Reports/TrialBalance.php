<?php

namespace Modules\Account\Classes\Reports;

use Modules\Account\Classes\OpenBalances;
use Modules\Account\Classes\Reports;
use Modules\Account\Classes\FinalAccounts;
use Modules\Account\Classes\CommonFunc;

use Illuminate\Support\Facades\DB;

/**
 * Trial Balance
 */
class TrialBalance
{

    /**
     * Trial balance helper
     *
     * @param array  $args Data Filter
     * @param string $type Type
     *
     * @return int
     */
    public function cashAtBank($args, $type)
    {


        $balance = 0;
        $result  = 0;

        $chart_bank = 7;

        $sql1       = "SELECT group_concat(id) FROM account_ledger where chart_id = " . $chart_bank;
        $ledger_ids = implode(',', explode(',', DB::scalar($sql1))); // e.g. 4, 5

        if ($ledger_ids) {
            $sql2 = "SELECT SUM(ledger_details.balance) as balance from (SELECT SUM( debit - credit ) AS balance
        FROM account_ledger_detail WHERE ledger_id IN ({$ledger_ids}) AND trn_date BETWEEN '%s' AND '%s'
        GROUP BY ledger_id) AS ledger_details";

            $data = DB::scalar($sql2, [$args['start_date'], $args['end_date']]);

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
     * @param array  $args Data Filter
     * @param string $type Type
     *
     * @return mixed
     */
    public function bankBalance($args, $type)
    {


        $balance = null;

        $chart_bank = 7;

        $sql = "SELECT ledger.id, ledger.name, SUM( debit - credit ) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_ledger_detail AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.chart_id = {$chart_bank} AND trn_date BETWEEN '{$args['start_date']}' AND '{$args['end_date']}' GROUP BY ledger.id";

        $data = DB::select($sql);

        $balance = $this->bankBalanceCalcWithOpeningBalance($args['start_date'], $data, $sql, $type);

        return $balance;
    }

    /**
     * Trial balance helper
     *
     * @param array  $args Data Filter
     * @param string $type Type
     *
     * @return int
     */
    public function salesTaxQuery($args, $type)
    {


        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance FROM account_tax_agency_detail
        WHERE trn_date BETWEEN '%s' AND '%s' GROUP BY agency_id {$having} ) AS get_amount";

        $data = DB::scalar($sql, [$args['start_date'], $args['end_date']]);

        return $this->salesTaxCalcWithOpeningBalance($args['start_date'], $data, $sql, $type);
    }

    /**
     * Trial balance helper
     * Get account receivable
     *
     * @param array $args Data Filter
     *
     * @return array
     */
    public function getAccountReceivable($args)
    {


        // mainly ( debit - credit )
        $sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance
            FROM invoice_account_detail WHERE trn_date BETWEEN '%s' AND '%s'
            GROUP BY invoice_no HAVING balance <> 0 )
        AS get_amount";

        $data = DB::scalar($sql, [$args['start_date'], $args['end_date']]);

        return $this->salesTaxCalcWithOpeningBalance($args, $data, 'receivable', $sql);
    }

    /**
     * Trial balance helper
     * Get account payble
     *
     * @param array $args Data Filter
     *
     * @return array
     */
    public function getAccountPayable($args)
    {


        /**
         *? Why only bills, not expense?
         *? Expense is `direct expense`, and we don't include direct expense here
         */
        $bill_sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance FROM bill_account_detail WHERE trn_date <= '%s'
        GROUP BY bill_no HAVING balance < 0 )
        AS get_amount";

        $purchase_sql = "SELECT SUM(balance) AS amount
        FROM ( SELECT SUM( debit - credit ) AS balance FROM purchase_account_details WHERE trn_date <= '%s'
        GROUP BY purchase_no HAVING balance <> 0 )
        AS get_amount";

        $bill_amount     = DB::scalar($bill_sql, [$args['end_date']]);
        $purchase_amount = DB::scalar($purchase_sql, [$args['end_date']]);

        $data = (float) $bill_amount + (float) $purchase_amount;

        return $this->salesTaxCalcWithOpeningBalance($args, $data, 'payable', $bill_sql, $purchase_sql);
    }

    /**
     * Trial balance helper
     *
     * Get owners equity
     *
     * @param array $args Data Filter
     * @param array $type Type
     *
     * @return array
     */
    public function getOwnersEquity($args, $type)
    {


        if ('capital' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('drawings' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM( debit - credit ) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_ledger_detail AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.slug = 'owner_s_equity' AND trn_date BETWEEN '%s' AND '%s' GROUP BY ledger.id {$having}";

        $data = DB::scalar($sql, [$args['start_date'], $args['end_date']]);

        return $this->ownersEquityCalcWithOpeningBalance($args['start_date'], $data, $sql, $type);
    }

    /**
     * Check if date has min 2 days difference ( Trial balance helper )
     *
     * @param string $date1 Date
     * @param string $date2 Date
     *
     * @return bool
     */
    public function hasDateDiff($date1, $date2)
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
     * @param string $sql        Sql
     * @param string $start_date Start Date
     * @param string $end_date   End Date
     *
     * @return float
     */
    public function calculatePeopleBalance($sql, $start_date, $end_date)
    {


        $balance = 0;
        $query   = DB::scalar($sql, [$start_date, $end_date]);

        if ($query) {
            $balance += (float) $query;
        }

        return $balance;
    }

    /**
     * Get ledger balance with opening balance
     *
     * @param array $ledgers         Ledgers
     * @param array $data            Data Filter
     * @param array $opening_balance Opening Balance
     *
     * @return array
     */
    public function getBalanceWithOpeningBalance($ledgers, $data, $opening_balance)
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
     * Get ledger details data between
     * `financial year start date`
     * and
     * `previous date from trial balance start date`
     *
     * @param string $sql       Sql
     * @param array  $temp_data Temp Data
     *
     * @return array
     */
    public function getBalanceWithinLedgerDetailsAndTrialBalance($sql, $temp_data)
    {


        $result = [];

        $ledger_details = DB::select($sql);

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
     * @param string $tb_start_date Start Date
     * @param array  $data          => ledger details data on trial balance date range
     * @param string $sql           SQL
     *
     * @return array
     */
    public function calcWithOpeningBalance($tb_start_date, $data, $sql)
    {

        $common = new CommonFunc();

        $result = [];

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->openingBalanceByFnYearId($closest_fy_date['id']);

        $ledgers = DB::select(
            "SELECT ledger.id, ledger.chart_id, ledger.name FROM account_ledger AS ledger
                WHERE ledger.chart_id <> 7 AND ledger.slug <> 'owner_s_equity'"
        );

        $temp_data = $this->getBalanceWithOpeningBalance($ledgers, $data, $opening_balance);

        // should we go further calculation, check the diff
        if (!$common->hasDateDiff($tb_start_date, $closest_fy_date['start_date'])) {
            return $temp_data;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        $sql = "SELECT  ledger.id, ledger.name, SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_ledger_detail AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.chart_id NOT IN ( 4, 5, 7 ) AND ledger.slug <> 'owner_s_equity' AND ledger_detail.trn_date BETWEEN '{$closest_fy_date['start_date']}' AND '{$prev_date_of_tb_start}' GROUP BY ledger_detail.ledger_id";

        $result = $this->getBalanceWithinLedgerDetailsAndTrialBalance($sql, $temp_data);

        return $result;
    }

    /**
     * Get trial balance cash at bank calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date Start Date
     * @param array  $data          => ledger details data on trial balance date range
     * @param string $sql           Sql
     * @param string $type          Type
     *
     * @return float
     */
    public function bankCashCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {

        $common = new CommonFunc();

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->bankCashOpeningBalanceByFnYearId($closest_fy_date['id']);

        $balance = (float) $data;

        foreach ($opening_balance as $op_balance) {
            $balance += (float) $op_balance['balance'];
        }

        // should we go further calculation, check the diff
        if (!$common->hasDateDiff($tb_start_date, $closest_fy_date['start_date'])) {
            return $balance;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        // get ledger details data between
        //     `financial year start date`
        // and
        //     `previous date from trial balance start date`
        $ledger_details_balance = DB::scalar($sql, [$closest_fy_date['start_date'], $prev_date_of_tb_start]);

        if ($ledger_details_balance) {
            $balance += (float) $ledger_details_balance;
        }

        return $balance;
    }

    /**
     * Get trial balance bank balance calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date Start Date
     * @param array  $data          => ledger details data on trial balance date range
     * @param string $sql           Sql
     * @param string $type          Type
     *
     * @return array
     */
    public function bankBalanceCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {

        $common = new CommonFunc();

        $chart_bank = 7;

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->bankBalanceOpeningBalanceByFnYearId($closest_fy_date['id']);

        $ledgers = DB::select("SELECT ledger.id, ledger.chart_id, ledger.name FROM account_ledger AS ledger WHERE ledger.chart_id = 7");

        $temp_data = $this->getBalanceWithOpeningBalance($ledgers, $data, $opening_balance);

        // should we go further calculation, check the diff
        if (!$common->hasDateDiff($tb_start_date, $closest_fy_date['start_date'])) {
            return $temp_data;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        $sql = "SELECT ledger.id, ledger.name, SUM( debit - credit ) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_ledger_detail AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.chart_id = {$chart_bank} AND trn_date BETWEEN '{$closest_fy_date['start_date']}' AND '{$prev_date_of_tb_start}' GROUP BY ledger.id";



        $result = $this->getBalanceWithinLedgerDetailsAndTrialBalance($sql, $temp_data);

        return $result;
    }

    /**
     * Get trial balance sales tax calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date Start Date
     * @param float  $data          => ledger details data on trial balance date range
     * @param string $sql           Sql
     * @param string $type          Type
     *
     * @return float
     */
    public function salesTaxCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {


        $common = new CommonFunc();

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->salesTaxOpeningBalanceByFnYearId($closest_fy_date['id'], $type);

        $balance = (float) $data;

        foreach ($opening_balance as $op_balance) {
            $balance += (float) $op_balance['balance'];
        }

        // should we go further calculation, check the diff
        if (!$common->hasDateDiff($tb_start_date, $closest_fy_date['start_date'])) {
            return $balance;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        // get agency details data between
        //     `financial year start date`
        // and
        //     `previous date from trial balance start date`
        $ledger_details_balance = DB::scalar($sql, [$closest_fy_date['start_date'], $prev_date_of_tb_start]);

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
     * @param string $tb_start_date Start Date
     * @param float  $data          => ledger details data on trial balance date range
     * @param string $sql           Sql
     * @param string $type          Type
     *
     * @return float
     */
    public function peopleCalcWithOpeningBalance($tb_date, $data, $type, $sql1, $sql2 = null)
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
     * @param string $closest_fy_start_date Financial Start Date
     * @param string $tb_end_date           End Date
     * @param string $type                  Type
     *
     * @return void
     */
    public function calcWithPeopleAccountDetails($closest_fy_start_date, $tb_end_date, $type)
    {


        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        // mainly ( debit - credit )
        $sql = "SELECT SUM(balance) AS amount FROM (
                SELECT SUM( debit - credit ) AS balance
                FROM partner_account_detail WHERE trn_date BETWEEN '%s' AND '%s'
                GROUP BY people_id {$having} )
            AS get_amount";

        return DB::scalar($sql, [$closest_fy_start_date, $tb_end_date]);
    }

    /**
     * Get trial balance owners equity calculate with opening balance within financial year date range
     *
     * @param string $tb_start_date Start Date
     * @param float  $data          => ledger details data on trial balance date range
     * @param string $sql           Sql
     * @param string $type          Type
     *
     * @return float
     */
    public function ownersEquityCalcWithOpeningBalance($tb_start_date, $data, $sql, $type)
    {

        $common = new CommonFunc();

        // get closest financial year id and start date
        $closest_fy_date = $this->getClosestFnYearDate($tb_start_date);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->ownersEquityOpeningBalanceByFnYearId($closest_fy_date['id'], $type);

        $balance = (float) $data;

        if (!empty($opening_balance)) {
            $balance += (float) $opening_balance;
        }

        // should we go further calculation, check the diff
        if (!$common->hasDateDiff($tb_start_date, $closest_fy_date['start_date'])) {
            return $balance;
        } else {
            $prev_date_of_tb_start = date('Y-m-d', strtotime('-1 day', strtotime($tb_start_date)));
        }

        // get ledger details data between
        //     `financial year start date`
        // and
        //     `previous date from trial balance start date`
        $ledger_details_balance = DB::scalar($sql, [$closest_fy_date['start_date'], $prev_date_of_tb_start]);

        if ($ledger_details_balance) {
            $balance += (float) $ledger_details_balance;
        }

        return $balance;
    }

    /**
     * Get closest date from financial year
     *
     * @param string $date Start Date
     *
     * @return string
     */
    public function getClosestFnYearDate($date)
    {


        $sql = "SELECT id, name, start_date, end_date FROM account_financial_year WHERE start_date <= '%s' ORDER BY start_date DESC LIMIT 1";

        return DB::select($sql, [$date]);
    }

    /**
     * Get opening balance data by financial year id
     *
     * @param int $id       Financial Year Id
     * @param int $chart_id Chart Id ( optional )
     *
     * @return string
     */
    public function openingBalanceByFnYearId($id, $chart_id = null)
    {


        $where = '';

        if ($chart_id) {
            $where = 'AND ledger.chart_id = %d' . $chart_id;
        }

        $sql = "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_opening_balance AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d {$where} AND opb.type = 'ledger' AND ledger.slug <> 'owner_s_equity'
        GROUP BY opb.ledger_id";

        return DB::select($sql, [$id]);
    }

    /**
     * Get bank opening balance data by financial year id
     *
     * @param int $id Financial Year id
     *
     * @return array
     */
    public function bankCashOpeningBalanceByFnYearId($id)
    {


        $sql = "SELECT SUM(opb.balance) AS balance FROM (SELECT SUM( debit - credit ) AS balance
            FROM account_opening_balance WHERE financial_year_id = %d AND chart_id = 7
            GROUP BY ledger_id) AS opb";

        return DB::select($sql, [$id]);
    }

    /**
     * Get bank opening balance data by financial year id
     *
     * @param int    $id   Financial Year Id
     * @param string $type Type
     *
     * @return array
     */
    public function salesTaxOpeningBalanceByFnYearId($id, $type)
    {


        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(opb.balance) AS balance FROM ( SELECT SUM( debit - credit ) AS balance
            FROM account_opening_balance
            WHERE financial_year_id = %d AND type = 'tax_agency' GROUP BY ledger_id {$having} ) AS opb";

        return DB::select($sql, [$id]);
    }

    /**
     * Get bank balance opening balance data by financial year id
     *
     * @param int    $id   Financial Year Id
     *
     * @return array
     */
    public function bankBalanceOpeningBalanceByFnYearId($id)
    {


        $sql = "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_opening_balance AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d AND ledger.chart_id = 7 GROUP BY opb.ledger_id";

        return DB::select($sql, [$id]);
    }

    /**
     * Get bank balance opening balance data by financial year id
     *
     * @param int    $id   Financial Year Id
     * @param string $type Type
     *
     * @return mixed
     */
    public function ownersEquityOpeningBalanceByFnYearId($id, $type)
    {


        if ('capital' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('drawings' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(opb.debit - opb.credit) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_opening_balance AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = %d AND opb.type = 'ledger' AND ledger.slug = 'owner_s_equity' {$having}";

        return DB::scalar($sql, [$id]);
    }

    /**
     * People Opening balance by financial year id
     *
     * @param mixed $id   Financial Year Id
     * @param mixed $type Type
     *
     * @return void
     */
    public function peopleOpeningBalanceByFnYearId($id, $type)
    {


        if ('payable' === $type) {
            $having = 'HAVING balance < 0';
        } elseif ('receivable' === $type) {
            $having = 'HAVING balance > 0';
        }

        $sql = "SELECT SUM(opb.balance) AS balance FROM ( SELECT SUM( debit - credit ) AS balance
        FROM account_opening_balance
        WHERE financial_year_id = %d AND type = 'people' GROUP BY ledger_id {$having} ) AS opb";

        return DB::scalar($sql, [$id]);
    }

    /**
     * Get trial balance
     *
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getTrialBalance($args)
    {
        $reports = new Reports();

        $sql = "SELECT ledger.id, ledger.chart_id, ledger.name, SUM(ledger_detail.debit - ledger_detail.credit) AS balance
        FROM account_ledger AS ledger
        LEFT JOIN account_ledger_detail AS ledger_detail ON ledger.id = ledger_detail.ledger_id
        WHERE ledger.chart_id <> 7 AND ledger.slug <> 'owner_s_equity' AND ledger_detail.trn_date BETWEEN '%s' AND '%s' GROUP BY ledger_detail.ledger_id";

        $data = DB::select($sql, [$args['start_date'], $args['end_date']]);

        // All calculated DB results are inside `rows` key
        $results['rows'] = $this->calcWithOpeningBalance($args['start_date'], $data, $sql);

        /*
     * Let's create some virtual ledgers
     */
        $final_accounts    = new FinalAccounts($args);

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
