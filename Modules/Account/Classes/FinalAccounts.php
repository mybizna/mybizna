<?php


namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;

use Illuminate\Support\Facades\DB;

/**
 * Helper class for final accounts
 *
 * @since 1.10.0
 */
class FinalAccounts
{


    /**
     * Arguments
     *
     * @var array
     */
    private $args = [];

    /**
     * Total bank cash
     *
     * @var float
     */
    public $cash_at_bank = 0;

    /**
     * Total bank loan
     *
     * @var float
     */
    public $loan_at_Bank = 0;

    /**
     * Total bank cash breakdown
     *
     * @var array
     */
    public $cash_at_bank_breakdowns = [];

    /**
     * Total bank loan breakdown
     *
     * @var array
     */
    public $loan_at_bank_breakdowns = [];

    /**
     * Financial year
     *
     * @var object
     */
    public $financial_year;

    /**
     * Class constructor
     *
     * @param array $args
     */
    public function __construct($args)
    {
        $this->args = $args;

        $this->set_financial_year();
        $this->set_bank_data();
    }

    /**
     * Generates financial year data
     *
     * @since 1.10.0
     *
     * @return void
     */
    private function set_financial_year()
    {
        $common = new CommonFunc();

        $this->financial_year = $common->closest_financial_year($this->args['start_date']);
    }

    /**
     * Generates necessary bank data
     *
     * @since 1.10.0
     *
     * @return void
     */
    private function set_bank_data()
    {
        $bank_ledger_data        = [];
        $opening_alances         = $this->get_opening_balances(7);
        $ledger_details          = $this->get_ledger_details(7);
        $previous_ledger_balance = $this->get_previous_balance(7);

        /**
         * Format opening balance data by setting ledger_id as index
         */
        foreach ($opening_alances as $item) {
            $bank_ledger_data[$item['ledger_id']] = $item;
        }

        /**
         * Format current ledger details data by setting ledger_id as index
         * and merge  ledger data according to ledger id with summation
         */
        foreach ($ledger_details as $ledger) {
            if (isset($bank_ledger_data[$ledger['ledger_id']])) {
                $bank_ledger_data[$ledger['ledger_id']]['balance'] += $ledger['balance'];
            } else {
                $bank_ledger_data[$ledger['ledger_id']] = $ledger;
            }
        }

        /**
         * Format previous ledger details data by setting ledger_id as index
         * and merge  ledger data according to ledger id with summation
         */
        foreach ($previous_ledger_balance as $ledger) {
            if (isset($bank_ledger_data[$ledger['ledger_id']])) {
                $bank_ledger_data[$ledger['ledger_id']]['balance'] += $ledger['balance'];
            } else {
                $bank_ledger_data[$ledger['ledger_id']] = $ledger;
            }
        }


        foreach ($bank_ledger_data as $ledger) {
            if ((float) $ledger['balance'] > 0) {
                $this->cash_at_bank += (float) $ledger['balance'];
                $this->cash_at_bank_breakdowns[$ledger['ledger_id']] = $ledger;
            }

            if ((float)$ledger['balance'] < 0) {
                $this->loan_at_Bank += (float) $ledger['balance'];
                $this->loan_at_bank_breakdowns[$ledger['ledger_id']] = $ledger;
            }
        }
    }

    /**
     * Retrieves previous balance
     *
     * @since 1.10.0
     *
     * @param int|string $chart_id
     *
     * @return array
     */
    private function get_previous_balance($chart_id)
    {

        $sql = "SELECT
                    ld.ledger_id,
                    SUM( ld.debit - ld.credit ) AS balance,
                    ledger.name,
                    ledger.chart_id
                FROM account_ledger_detail AS ld
                INNER JOIN account_ledger AS ledger
                ON ledger.id = ld.ledger_id
                WHERE ledger.chart_id = ?
                AND ld.trn_date >= ? AND ld.trn_date < ?
                GROUP BY ld.ledger_id";

        $balance = DB::select(
            $sql,
            [
                $chart_id,
                $this->financial_year['start_date'],
                $this->args['start_date']
            ]
        );

        return  !empty($balance) ? $balance : [];
    }

    /**
     * Retrieves opening balance of ledger
     *
     * @since 1.10.0
     *
     * @param int|string $chart_id
     *
     * @return array
     */
    private function get_opening_balances($chart_id)
    {

        $sql = "SELECT
                    ob.ledger_id,
                    SUM(ob.debit - ob.credit) AS balance,
                    ledger.name, ob.chart_id
                FROM account_opening_balance AS ob
                INNER JOIN account_ledger AS ledger
                ON ledger.id = ob.ledger_id
                WHERE ob.financial_year_id = ?
                AND ob.chart_id = ?
                GROUP BY ob.ledger_id";

        $balances = DB::select(
            $sql,
            [
                $this->financial_year['id'],
                $chart_id
            ]
        );

        return !empty($balances) ? $balances : [];
    }

    /**
     * Retrieves balance from ledger_details of ledger
     *
     * @since 1.10.0
     *
     * @param int|string $chart_id
     *
     * @return array
     */
    private function get_ledger_details($chart_id)
    {

        $sql = "SELECT
                    ld.ledger_id,
                    SUM( ld.debit - ld.credit ) AS balance,
                    ledger.name,
                    ledger.chart_id
                FROM account_ledger_detail AS ld
                INNER JOIN account_ledger AS ledger
                ON ledger.id = ld.ledger_id
                WHERE ledger.chart_id = ?
                AND ld.trn_date BETWEEN ? AND ?
                GROUP BY ld.ledger_id";

        $details = DB::select(
            $sql,
            [
                $chart_id,
                $this->args['start_date'],
                $this->args['end_date']
            ]
        );

        return !empty($details) ? $details : [];
    }
}
