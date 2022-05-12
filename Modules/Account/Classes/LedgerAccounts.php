<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\Transactions;
use Modules\Account\Classes\Reports\TrialBalance;

use Illuminate\Support\Facades\DB;

class LedgerAccounts
{

    /**
     * Get all chart of accounts
     *
     * @return array
     */
    public function getAllCharts()
    {


        $charts = DB::select("SELECT id, name AS label FROM erp_acct_chart_of_accounts");

        return $charts;
    }

    /**
     * Get Ledger name by id
     *
     * @param int $ledger_id Ledger Id
     *
     * @return mixed
     */
    public function getLedgerNameById($ledger_id)
    {


        $row = DB::select("SELECT id, name  FROM erp_acct_ledgers WHERE id = %d", [$ledger_id]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row->name;
    }

    /**
     * Get ledger categories
     *
     * @param int $chart_id Chart Id
     *
     * @return array
     */
    public function getLedgerCategories($chart_id)
    {


        $ledger_categories = DB::select("SELECT id, name AS label, chart_id, parent_id, system FROM erp_acct_ledger_categories WHERE chart_id = {$chart_id}");


        return $ledger_categories;
    }

    /**
     * Create ledger category
     *
     * @param array $args Data Filter
     *
     * @return array
     */
    public function createLedgerCategory($args)
    {


        $exist = DB::scalar("SELECT name FROM erp_acct_ledger_categories WHERE name = %s", [$args['name']]);

        if (!$exist) {
            $id = DB::table("erp_acct_ledger_categories")
                ->insertGetId(
                    [
                        'name'      => $args['name'],
                        'parent_id' => !empty($args['parent']) ? $args['parent'] : null,
                    ]
                );

            return $id;
        }


        return false;
    }

    /**
     * Update ledger category
     *
     * @param array $args Data Filter
     *
     * @return array
     */
    public function updateLedgerCategory($args)
    {


        $exist = DB::scalar("SELECT name FROM erp_acct_ledger_categories WHERE name = %s AND id <> %d", [$args['name'], $args['id']]);

        if (!$exist) {
            return DB::table("erp_acct_ledger_categories")
                ->where('id', $args['id'])
                ->update(
                    [
                        'name'      => $args['name'],
                        'parent_id' => !empty($args['parent']) ? $args['parent'] : null,
                    ]
                );
        }


        return false;
    }

    /**
     * Remove ledger category
     *
     * @param array $id        Id
     * @param array $parent_id Default Parent Id
     *
     * @return array
     */
    public function deleteLedgerCategory($id, $parent_id = '')
    {


        $parent_id = DB::scalar("SELECT parent_id FROM erp_acct_ledger_categories WHERE id = %d", [$id]);

        $table = "erp_acct_ledger_categories";

        DB::table($table)
            ->where('parent_id', $id)
            ->update(['parent_id' => $parent_id]);


        return DB::table($table)->where([['id' => $id]])->delete();
    }

    /**
     * Get Ledgers By Chart Id
     *
     * @param int $chart_id Chart Id
     *
     * @return array|object|null
     */
    public function getLedgersByChartId($chart_id)
    {


        $ledgers = DB::select("SELECT id, name FROM erp_acct_ledgers WHERE chart_id = {$chart_id} AND unused IS NULL");

        for ($i = 0; $i < count($ledgers); $i++) {
            $ledgers[$i]['balance'] = $this->getLedgerBalance($ledgers[$i]['id']);
        }

        return $ledgers;
    }

    /**
     * Get ledger transaction count
     *
     * @param int $ledger_id Ledger Id
     *
     * @return mixed
     */
    public function getLedgerTrnCount($ledger_id)
    {


        $ledger = DB::select("SELECT COUNT(*) as count FROM erp_acct_ledger_details WHERE ledger_id = %d", [$ledger_id]);

        $ledger = (!empty($ledger)) ? $ledger[0] : null;

        return $ledger['count'];
    }

    /**
     * Get ledger balance
     *
     * @param int $ledger_id Ledger Id
     *
     * @return mixed
     */
    public function getLedgerBalance($ledger_id)
    {


        $ledger = DB::select("SELECT ledger.id, ledger.name, SUM(ld.debit - ld.credit) as balance FROM erp_acct_ledgers AS ledger LEFT JOIN erp_acct_ledger_details as ld ON ledger.id = ld.ledger_id WHERE ledger.id = %d", [$ledger_id]);
        $ledger = (!empty($ledger)) ? $ledger[0] : null;

        return $ledger['balance'];
    }

    /**============
     * Ledger CRUD
     * ===============*/

    /**
     * Get a ledger by id
     *
     * @param int $id Id
     *
     * @return array|object|void|null
     */
    public function getLedger($id)
    {


        $row = DB::select("SELECT * FROM erp_acct_ledgers WHERE id = %d", [$id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Insert a ledger
     *
     * @param array $item Item
     *
     * @return array|object|void|null
     */
    public function insertLedger($item)
    {
        $common = CommonFunc();

        $id = DB::table("erp_acct_ledgers")
            ->insertGetId(
                [
                    'chart_id'    => $item['chart_id'],
                    'category_id' => $item['category_id'],
                    'name'        => $item['name'],
                    'slug'        => $common->slugify($item['name']),
                    'code'        => $item['code'],
                ]
            );

        return $this->getLedger($id);
    }

    /**
     * Update a ledger
     *
     * @param array $item Item
     * @param int   $id   Id
     *
     * @return array|object|void|null
     */
    public function updateLedger($item, $id)
    {


        $common = new CommonFunc();

        DB::table("erp_acct_ledgers")
            ->where('id', $id)
            ->update(
                [
                    'chart_id'    => $item['chart_id'],
                    'category_id' => $item['category_id'],
                    'name'        => $item['name'],
                    'slug'        => $common->slugify($item['name']),
                    'code'        => $item['code'],
                ]
            );

        return $this->getLedger($id);
    }

    /**
     * Get ledger opening balance data by financial year id
     *
     * @param int $id Chart Id
     *
     * @return string
     */
    public function ledgerOpeningBalanceByFnYearId($id)
    {


        $sql = "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_opening_balances AS opb ON ledger.id = opb.ledger_id
        WHERE opb.financial_year_id = {$id} AND opb.type = 'ledger' GROUP BY opb.ledger_id";

        return DB::select($sql);
    }

    /**
     * =====================
     * =========================
     * =============================
     */
    /**
     * Get ledger with balances
     *
     * @return array
     */
    public function getLedgersWithBalances()
    {

        $trialbal = new TrialBalance();

        $today = date('Y-m-d');

        $ledgers = DB::select(
            "SELECT ledger.id, ledger.chart_id, ledger.category_id, ledger.name, ledger.slug, ledger.code, ledger.system, chart_of_account.name as account_name FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_chart_of_accounts AS chart_of_account ON ledger.chart_id = chart_of_account.id WHERE ledger.unused IS NULL"
        );

        // get closest financial year id and start date
        $closest_fy_date = $trialbal->getClosestFnYearDate($today);

        // get opening balance data within that(^) financial year
        $opening_balance = $this->ledgerOpeningBalanceByFnYearId($closest_fy_date['id']);

        $sql2 = "SELECT ledger.id, ledger.name, SUM(ld.debit - ld.credit) as balance
        FROM erp_acct_ledgers AS ledger
        LEFT JOIN erp_acct_ledger_details as ld ON ledger.id = ld.ledger_id
        AND ld.trn_date BETWEEN '{$closest_fy_date['start_date']}' AND '{$today}' GROUP BY ld.ledger_id";

        $data = DB::select($sql2);

        return $this->ledgerBalanceWithOpeningBalance($ledgers, $data, $opening_balance);
    }

    /**
     * Ledgers opening balance
     *
     * @param int $id Year Id
     *
     * @return void
     */
    public function ledgersOpeningBalanceByFnYearId($id)
    {


        return DB::select(
            "SELECT ledger.id, ledger.name, SUM(opb.debit - opb.credit) AS balance FROM erp_acct_ledgers AS ledger LEFT JOIN erp_acct_opening_balances AS opb ON ledger.id = opb.ledger_id WHERE opb.financial_year_id = %d opb.type = 'ledger' GROUP BY opb.ledger_id",
            [$id]
        );
    }

    /**
     * Get ledger balance with opening balance for chart of accounts
     *
     * @param array $ledgers
     * @param array $data
     * @param array $opening_balance
     *
     * @return array
     */
    public function ledgerBalanceWithOpeningBalance($ledgers, $data, $opening_balance)
    {
        $temp_data         = [];
        $ledger_balance    = [];
        $transaction_count = [];

        /*
     * Generate ledger balance and transaction count according to ledger id
     */
        foreach ($data as $row) {
            if (!isset($ledger_balance[$row['id']])) {
                $ledger_balance[$row['id']]    = (float) $row['balance'];
                $transaction_count[$row['id']] = 1;
            } else {
                $ledger_balance[$row['id']]    += (float) $row['balance'];
                $transaction_count[$row['id']] += 1;
            }
        }

        foreach ($opening_balance as $op_balance) {
            if (!isset($ledger_balance[$op_balance['id']])) {
                $ledger_balance[$op_balance['id']] = 0.00;
            }

            $ledger_balance[$op_balance['id']] += (float) $op_balance['balance'];
        }

        foreach ($ledgers as $ledger) {
            $temp_data[] = [
                'id'          => $ledger['id'],
                'chart_id'    => $ledger['chart_id'],
                'category_id' => $ledger['category_id'],
                'name'        => $ledger['name'],
                'slug'        => $ledger['slug'],
                'code'        => $ledger['code'],
                'system'      => $ledger['system'],
                'trn_count'   => isset($transaction_count[$ledger['id']]) ? $transaction_count[$ledger['id']] : 0,
                'balance'     => isset($ledger_balance[$ledger['id']]) ? $ledger_balance[$ledger['id']] : 0.00,
            ];
        }

        return $temp_data;
    }

    /**
     * Get chart of account id by slug
     *
     * @param string $key Key
     *
     * @return int
     */
    public function getChartIdBySlug($key)
    {
        switch ($key) {
            case 'asset':
                $id = 1;
                break;

            case 'liability':
                $id = 2;
                break;

            case 'equity':
                $id = 3;
                break;

            case 'income':
                $id = 4;
                break;

            case 'expense':
                $id = 5;
                break;

            case 'asset_liability':
                $id = 6;
                break;

            case 'bank':
                $id = 7;
                break;
            default:
                $id = null;
        }

        return $id;
    }

    /**
     * Get ledgers
     *
     * @return array|object|null
     */
    public function getLedgers()
    {


        $ledgers = DB::select("SELECT id, name FROM erp_acct_ledgers WHERE unused IS NULL");

        return $ledgers;
    }
}
