<?php



namespace Modules\Account\Classes;


use Modules\Account\Classes\Reports\TrialBalance;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\LedgerAccounts;

class Bank
{


    /**
     * Get all bank accounts
     *
     * @param boolean $show_balance If to show balance
     * @param boolean $with_cash    If has cash
     * @param boolean $no_bank      No Bank
     * 
     * @return array
     */
    function getBanks($show_balance = false, $with_cash = false, $no_bank = false)
    {
        $trialbal = new TrialBalance();
        $ledger = new LedgerAccounts();

        $args               = [];
        $args['start_date'] = date('Y-m-d');

        $closest_fy_date    = $trialbal->getClosestFnYearDate($args['start_date']);
        $args['start_date'] = $closest_fy_date['start_date'];
        $args['end_date']   = $closest_fy_date['end_date'];

        $ledgers   = 'erp_acct_ledgers';
        $show_all  = false;
        $cash_only = false;
        $bank_only = false;

        $chart_id    = 7;
        $cash_ledger = '';
        $where       = '';

        if ($with_cash && !$no_bank) {
            $where       = " WHERE chart_id = {$chart_id}";
            $cash_ledger = " OR slug = 'cash' ";
            $show_all    = true;
        }

        if ($with_cash && $no_bank) {
            $where       = ' WHERE';
            $cash_ledger = " slug = 'cash' ";
            $cash_only   = true;
        }

        if (!$with_cash && !$no_bank) {
            $where       = " WHERE chart_id = {$chart_id}";
            $cash_ledger = '';
            $bank_only   = true;
        }

        if (!$show_balance) {
            $query   = "SELECT * FROM $ledgers" . $where . $cash_ledger;
            $results = $wpdb->get_results($query, ARRAY_A);

            return $results;
        }

        $sub_query      = "SELECT id FROM $ledgers" . $where . $cash_ledger;
        $ledger_details = 'erp_acct_ledger_details';
        $query          = "Select l.id, ld.ledger_id, l.code, l.name, SUM(ld.debit - ld.credit) as balance
              From $ledger_details as ld
              LEFT JOIN $ledgers as l ON l.id = ld.ledger_id
              Where ld.ledger_id IN ($sub_query)
              Group BY ld.ledger_id";

        $temp_accts = $wpdb->get_results($query, ARRAY_A);

        if ($with_cash) {
            // little hack to solve -> opening_balance cash entry with no ledger_details cash entry
            $cash_ledger = '7';
            $no_cash     = true;

            foreach ($temp_accts as $temp_acct) {
                if ($temp_acct['ledger_id'] === $cash_ledger) {
                    $no_cash = false;
                    break;
                }
            }

            if ($no_cash) {
                $temp_accts[] = ['id' => 7];
            }
        }

        $accts      = [];
        $bank_accts = [];
        $uniq_accts = [];

        $ledger_map = \WeDevs\ERP\Accounting\Includes\Classes\Ledger_Map::get_instance();
        $ledger_id  = $ledger_map->get_ledger_id_by_slug('cash');

        $c_balance = get_ledger_balance_with_opening_balance($ledger_id, $args['start_date'], $args['end_date']);
        $balance   = isset($c_balance->balance) ? $c_balance->balance : 0;

        foreach ($temp_accts as $temp_acct) {
            $bank_accts[] = get_ledger_balance_with_opening_balance($temp_acct['id'], $args['start_date'], $args['end_date']);
        }

        if ($cash_only && !empty($accts)) {
            return $accts;
        }

        $banks = $ledger->getLedgersByChartId(7);

        if ($bank_only && empty($banks)) {
            return new WP_Error('rest_empty_accounts', __('Bank accounts are empty.'), ['status' => 204]);
        }

        foreach ($banks as $bank) {
            $bank_accts[] = get_ledger_balance_with_opening_balance($bank['id'], $args['start_date'], $args['end_date']);
        }

        $results = array_merge($accts, $bank_accts);

        foreach ($results as $index => $result) {
            if (!empty($uniq_accts) && in_array($result['id'], $uniq_accts, true)) {
                unset($results[$index]);
                continue;
            }
            $uniq_accts[] = $result['id'];
        }

        return $results;
    }

    /**
     * Get all accounts to show in dashboard
     *
     * @return mixed
     */
    function getDashboardBanks()
    {
        $trialbal = new TrialBalance();

        $args               = [];
        $args['start_date'] = date('Y-m-d');

        $closest_fy_date    = $trialbal->getClosestFnYearDate($args['start_date']);
        $args['start_date'] = $closest_fy_date['start_date'];
        $args['end_date']   = $closest_fy_date['end_date'];

        $results = [];

        $ledger_map = \WeDevs\ERP\Accounting\Includes\Classes\Ledger_Map::get_instance();
        $ledger_id  = $ledger_map->get_ledger_id_by_slug('cash');

        $c_balance = get_ledger_balance_with_opening_balance($ledger_id, $args['start_date'], $args['end_date']);

        $results[] = [
            'name'    => __('Cash', 'erp'),
            'balance' => isset($c_balance['balance']) ? $c_balance['balance'] : 0,
        ];

        $results[] = [
            'name'       => __('Cash at Bank', 'erp'),
            'balance'    => $trialbal->cashAtBank($args, 'balance'),
            'additional' => $trialbal->bankBalance($args, 'balance'),
        ];

        $results[] = [
            'name'       => __('Bank Loan', 'erp'),
            'balance'    => $trialbal->cashAtBank($args, 'loan'),
            'additional' => $trialbal->bankBalance($args, 'loan'),
        ];

        return $results;
    }

    /**
     * Get a single bank account
     *
     * @param int $bank_no Bank No
     *
     * @return mixed
     */
    function getBank($bank_no)
    {


        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}erp_acct_cash_at_banks WHERE ledger_id = %d", $bank_no), ARRAY_A);

        return $row;
    }

    /**
     * Insert a bank account
     *
     * @param array $data sPassed Data
     *
     * @return int
     */
    function insertBank($data)
    {


        $bank_data = $this->getFormattedBankData($data);

        try {
            $wpdb->query('START TRANSACTION');

            $wpdb->insert(
                'erp_acct_cash_at_banks',
                [
                    'ledger_id' => $bank_data['ledger_id'],
                ]
            );

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('bank-account-exception', $e->getMessage());
        }

        return $bank_data['ledger_id'];
    }

    /**
     * Delete a bank account
     *
     * @param int $id Bank Id
     *
     * @return int
     */
    function deleteBank($id)
    {


        try {
            $wpdb->query('START TRANSACTION');
            $wpdb->delete($wpdb->prefix . 'erp_acct_cash_at_banks', ['ledger_id' => $id]);
            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('bank-account-exception', $e->getMessage());
        }

        return $id;
    }

    /**
     * Get formatted bank data
     *
     * @param array $bank_data Bank Data
     *
     * @return mixed
     */

    function getFormattedBankData($bank_data)
    {
        $bank_data['ledger_id'] = !empty($bank_data['ledger_id']) ? $bank_data['ledger_id'] : 0;

        return $bank_data;
    }

    /**
     * Get balance of a single account
     *
     * @param int $ledger_id ledger Id
     * 
     * @return mixed
     */
    function getSingleAccountBalance($ledger_id)
    {


        $result = $wpdb->get_row($wpdb->prepare("SELECT ledger_id, SUM(credit) - SUM(debit) AS 'balance' FROM {$wpdb->prefix}erp_acct_ledger_details WHERE ledger_id = %d", $ledger_id), ARRAY_A);

        return $result;
    }

    /**
     * Get account debit credit
     * 
     * @param int $ledger_id Ledger Id
     *
     * @return array
     */
    function getAccountDebitCredit($ledger_id)
    {

        $dr_cr = [];

        $dr_cr['debit']  = $wpdb->get_var($wpdb->prepare("SELECT SUM(debit) FROM {$wpdb->prefix}erp_acct_ledger_details WHERE ledger_id = %d", $ledger_id));
        $dr_cr['credit'] = $wpdb->get_var($wpdb->prepare("SELECT SUM(credit) FROM {$wpdb->prefix}erp_acct_ledger_details WHERE ledger_id = %d", $ledger_id));

        return $dr_cr;
    }

    /**
     * Perform transfer amount between two account
     *
     * @param array $item Record to transfer
     * 
     * @return mixed
     */
    function performTransfer($item)
    {


        $common = new CommonFunc();
        $created_by =auth()->user()->id;
        $created_at = date('Y-m-d');
        $updated_at = date('Y-m-d');
        $updated_by = $created_by;
        $currency   = $common->getCurrency(true);

        try {
            $wpdb->query('START TRANSACTION');

            $wpdb->insert(
                'erp_acct_voucher_no',
                [
                    'type'       => 'transfer_voucher',
                    'currency'   => $currency,
                    'created_at' => $created_at,
                    'created_by' => $created_by,
                    'updated_at' => $updated_at,
                    'updated_by' => $updated_by,
                ]
            );

            $voucher_no = $wpdb->insert_id;

            // Inset transfer amount in ledger_details
            $wpdb->insert(
                'erp_acct_ledger_details',
                [
                    'ledger_id'   => $item['from_account_id'],
                    'trn_no'      => $voucher_no,
                    'particulars' => $item['particulars'],
                    'debit'       => 0,
                    'credit'      => $item['amount'],
                    'trn_date'    => $item['date'],
                    'created_at'  => $created_at,
                    'created_by'  => $created_by,
                    'updated_at'  => $updated_at,
                    'updated_by'  => $updated_by,
                ]
            );

            $wpdb->insert(
                'erp_acct_ledger_details',
                [
                    'ledger_id'   => $item['to_account_id'],
                    'trn_no'      => $voucher_no,
                    'particulars' => $item['particulars'],
                    'debit'       => $item['amount'],
                    'credit'      => 0,
                    'trn_date'    => $item['date'],
                    'created_at'  => $created_at,
                    'created_by'  => $created_by,
                    'updated_at'  => $updated_at,
                    'updated_by'  => $updated_by,
                ]
            );

            $wpdb->insert(
                'erp_acct_transfer_voucher',
                [
                    'voucher_no'  => $voucher_no,
                    'amount'      => $item['amount'],
                    'ac_from'     => $item['from_account_id'],
                    'ac_to'       => $item['to_account_id'],
                    'particulars' => $item['particulars'],
                    'trn_date'    => $item['date'],
                    'created_at'  => $created_at,
                    'created_by'  => $created_by,
                    'updated_at'  => $updated_at,
                    'updated_by'  => $updated_by,
                ]
            );

            $wpdb->query('COMMIT');
        } catch (\Exception $e) {
            $wpdb->query('ROLLBACK');

            return new WP_error('transfer-exception', $e->getMessage());
        }
    }

    /**
     * Sync dashboard account on transfer
     * 
     * @return mixed
     */
    function syncDashboardAccounts()
    {


        $accounts = $this->GetBanks(true, true, false);

        foreach ($accounts as $account) {
            $wpdb->update(
                'erp_acct_cash_at_banks',
                [
                    'balance' => $account['balance'],
                ],
                [
                    'ledger_id' => $account['ledger_id'],
                ]
            );
        }
    }

    /**
     * Get transferrable accounts
     * 
     * @return array
     */
    function getTransferAccounts($show_balance = false)
    {
        $results = $this->GetBanks(true, true, false);

        return $results;
    }

    /**
     * Get created Transfer voucher list
     *
     * @param array $args Vourchers Filters
     *
     * @return array
     */
    function getTransferVouchers($args = [])
    {


        $defaults = [
            'number'   => 20,
            'offset'   => 0,
            'order_by' => 'id',
            'order'    => 'DESC',
            'count'    => false,
            's'        => '',
        ];

        $args = wp_parse_args($args, $defaults);

        $limit = '';

        if (-1 !== $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}erp_acct_transfer_voucher ORDER BY %s %s %s", $args['order_by'], $args['order'], $limit), ARRAY_A);

        return $result;
    }

    /**
     * Get single voucher
     *
     * @param int $id Voucher id
     *
     * @return object Single voucher
     */
    function getSingleVoucher($id)
    {


        if (!$id) {
            return;
        }

        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}erp_acct_transfer_voucher WHERE id = %d", $id));

        return $result;
    }

    /**
     * Get balance by Ledger ID
     *
     * @param int $id Ledger Id
     *
     * @return array
     */
    function getBalanceByLedger($id)
    {
        if (is_array($id)) {
            $id = "'" . implode("','", $id) . "'";
        }


        $table_name = 'erp_acct_ledger_details';
        $query      = "Select ld.ledger_id,SUM(ld.debit - ld.credit) as balance From $table_name as ld Where ld.ledger_id IN ($id) Group BY ld.ledger_id ";
        $result     = $wpdb->get_results($query, ARRAY_A);

        return $result;
    }

    /**
     * Get bank accounts dropdown with cash
     *
     * @return array
     */
    function getBankDropdown()
    {
        $accounts = [];
        $banks    = $this->GetBanks(true, true, false);

        if ($banks) {
            foreach ($banks as $bank) {
                $accounts[$bank['id']] = sprintf('%s', $bank['name']);
            }
        }

        return $accounts;
    }
}
