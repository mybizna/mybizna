<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;

use Illuminate\Support\Facades\DB;

class Taxes
{

    /**
     * Get all taxes
     * 
     * @param array $args Tax Rates
     *
     * @return mixed
     */
    public function getAllTaxRates($args = [])
    {


        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'tax.id',
            'order'   => 'ASC',
            'count'   => false,
            's'       => '',
        ];

        $args = array_merge($defaults, $args);

        $limit = '';

        if (-1 !== $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $sql  = 'SELECT';
        $sql .= $args['count'] ? ' COUNT( DISTINCT tax.id ) as total_number ' : ' DISTINCT tax.id, tax.tax_rate_name, tax.tax_number, tax.default ';
        $sql .= "FROM erp_acct_taxes AS tax INNER JOIN erp_acct_tax_cat_agency as cat_agency on tax.id = cat_agency.tax_id ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            $tax_rates_count = DB::scalar($sql);
        } else {
            $tax_rates = DB::select($sql);
        }

        if ($args['count']) {
            return $tax_rates_count;
        }

        return $tax_rates;
    }

    /**
     * Get an single tax
     *
     * @param int $tax_no Tax Number
     *
     * @return mixed
     */
    public function getTaxRate($tax_no)
    {


        $sql = "SELECT

                tax.id,
                tax.tax_rate_name,
                tax.tax_number,
                tax.default,
                tax.created_at,
                tax.created_by,
                tax.updated_at,
                tax.updated_by,

                tax_item.tax_id,
                tax_item.component_name,
                tax_item.agency_id,
                tax_item.tax_cat_id

            FROM erp_acct_taxes AS tax
            LEFT JOIN erp_acct_tax_cat_agency AS tax_item ON tax.id = tax_item.tax_id

            WHERE tax.id = {$tax_no} LIMIT 1";

        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        $row = DB::select($sql);
        $row = (!empty($row)) ? $row[0] : null;
        $row['tax_components'] =$this->formatTaxLineItems($tax_no);

        for ($i = 0; $i < count($row['tax_components']); $i++) { //
            $row['tax_components'][$i]['agency']   = null; // we'll fill that later from VUE
            $row['tax_components'][$i]['category'] = null; // we'll fill that later from VUE

            $row['tax_components'][$i]['agency_name']  = $tax_agencies->getTaxAgencyById($row['tax_components'][$i]['agency_id']);
            $row['tax_components'][$i]['tax_cat_name'] = $tax_cats->getTaxCategoryById($row['tax_components'][$i]['tax_cat_id']);
        }

        return $row;
    }

    /**
     * Insert tax data
     *
     * @param array $data Data
     *
     * @return array
     */
    public function insertTaxRate($data)
    {


        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;

        $tax_data =$this->getFormattedTaxData($data);
        $items    = $data['tax_components'];
        $tax_id   = (int) $data['tax_rate_name'];
        $inserted = [];

        foreach ($items as $item) {
            $id = DB::table('erp_acct_tax_cat_agency')
                ->insertGetId(
                    [
                        'tax_id'         => $tax_id,
                        'component_name' => $item['component_name'],
                        'tax_cat_id'     => $item['tax_category_id'],
                        'agency_id'      => $item['agency_id'],
                        'tax_rate'       => $item['tax_rate'],
                        'created_at'     => $tax_data['created_at'],
                        'created_by'     => $tax_data['created_by'],
                        'updated_at'     => $tax_data['updated_at'],
                        'updated_by'     => $tax_data['updated_by'],
                    ]
                );

            if ($id) {
                $inserted[] = $id;
            }
        }


        return $inserted;
    }

    /**
     * Update tax data
     *
     * @param array $data Data
     *
     * @return int
     */
    public function updateTaxRate($data, $id)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data =$this->getFormattedTaxData($data);

        DB::table('erp_acct_taxes')
            ->where('id', $id)
            ->update(
                [
                    'tax_rate_id' => $tax_data['tax_rate_id'],
                    'tax_number'  => $tax_data['tax_number'],
                    'default'     => $tax_data['default'],
                    'updated_at'  => $tax_data['updated_at'],
                    'updated_by'  => $tax_data['updated_by'],
                ]
            );

        if (!empty($tax_data['default']) && $tax_data['default']) {
            $results = DB::update('UPDATE ' . 'erp_acct_taxes' . ' SET `default`=0');
        }

        $items = $data['tax_components'];

        foreach ($items as $key => $item) {
            DB::table('erp_acct_tax_cat_agency')
                ->where('tax_id', $id)
                ->update(
                    [
                        'component_name' => $item['component_name'],
                        'tax_cat_id'     => $item['tax_cat_id'],
                        'agency_id'      => $item['agency_id'],
                        'tax_rate'       => $item['tax_rate'],
                        'updated_at'     => $tax_data['updated_at'],
                        'updated_by'     => $tax_data['updated_by'],
                    ]
                );
        }


        return $id;
    }

    /**
     * Update tax data
     *
     * @param int $data Data
     *
     * @return int
     */
    public function quickEditTaxRate($data, $id)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data =$this->getFormattedTaxData($data);

        if (!empty($tax_data['default']) && 1 === $tax_data['default']) {
            $results = DB::update('UPDATE ' . 'erp_acct_taxes' . ' SET `default`=0');
        }

        DB::table('erp_acct_taxes')

            ->where('id', $id)
            ->update(
                [
                    'tax_number' => $tax_data['tax_number'],
                    'default'    => $tax_data['default'],
                    'updated_at' => $tax_data['updated_at'],
                    'updated_by' => $tax_data['updated_by'],
                ]
            );


        return $id;
    }

    /**
     * Add line item of a tax rate
     *
     * @param int $data Data
     *
     * @return int
     */
    public function addTaxRateLine($data)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $this->getFormattedTaxLineData($data);

        DB::table('erp_acct_tax_cat_agency')
            ->insert(
                [
                    'tax_id'         => $tax_data['tax_id'],
                    'component_name' => $tax_data['component_name'],
                    'tax_cat_id'     => $tax_data['tax_cat_id'],
                    'agency_id'      => $tax_data['agency_id'],
                    'tax_rate'       => $tax_data['tax_rate'],
                    'created_at'     => $tax_data['created_at'],
                    'created_by'     => $tax_data['created_by'],
                    'updated_at'     => $tax_data['updated_at'],
                    'updated_by'     => $tax_data['updated_by'],
                ]
            );


        return $tax_data['tax_id'];
    }

    /**
     * Update line item of a tax rate
     *
     * @param array $data Filter Data
     *
     * @return int
     */
    public function editTaxRateLine($data)
    {


        $updated_by         = auth()->user()->id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $updated_by;

        $tax_data = $this->getFormattedTaxLineData($data);

        DB::table('erp_acct_tax_cat_agency')
            ->where('id', $tax_data['db_id'])
            ->update(
                [
                    'component_name' => $tax_data['component_name'],
                    'tax_cat_id'     => $tax_data['tax_cat_id'],
                    'agency_id'      => $tax_data['agency_id'],
                    'tax_rate'       => $tax_data['tax_rate'],
                    'updated_at'     => $tax_data['updated_at'],
                    'updated_by'     => $tax_data['updated_by'],
                ]
            );


        return $tax_data['db_id'];
    }

    /**
     * Delete an tax rate line
     *
     * @param int $line_no Line Number
     *
     * @return int
     */
    public function deleteTaxRateLine($line_no)
    {


        DB::table('erp_acct_tax_cat_agency')->where([['id' => $line_no]])->delete();


        return $line_no;
    }

    /**
     * Delete an tax
     *
     * @param int $tax_no Tax Number
     *
     * @return int
     */
    public function deleteTaxRate($tax_no)
    {


        DB::table('erp_acct_taxes')->where([['id' => $tax_no]])->delete();


        return $tax_no;
    }

    /**
     * Get all tax payments
     * 
     * @param array $args Data Filter
     *
     * @return mixed
     */
    public function getTaxPayRecords($args = [])
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

        if (-1 !== $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $sql  = 'SELECT';
        $sql .= $args['count'] ? ' COUNT( id ) as total_number ' : ' * ';
        $sql .= "FROM erp_acct_tax_pay ORDER BY {$args['orderby']} {$args['order']} {$limit}";

        if ($args['count']) {
            $tax_pay_count = DB::scalar($sql);
        } else {
            $tax_pay = DB::select($sql);
        }

        if ($args['count']) {
            return $tax_pay_count;
        }

        return $tax_pay;
    }

    /**
     * Get a single tax payment
     *
     * @param int $voucher_no Voucher Number
     * 
     * @return mixed
     */
    public function getTaxPayRecord($voucher_no)
    {


        $row = DB::select(

            "SELECT
            tax.id,
            tax.voucher_no,
            tax.particulars,
            tax.amount,
            tax.trn_date,
            tax.voucher_type,
            tax.trn_by,
            tax.agency_id,
            tax.ledger_id,
            tax.created_at
            FROM erp_acct_tax_pay AS tax
            WHERE tax.voucher_no = %d LIMIT 1",
            [$voucher_no]
        );

        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Make a tax payment
     *
     * @param array $data Data Filter
     *
     * @return array
     */
    public function payTax($data)
    {

        $common = new CommonFunc();

        $created_by         = auth()->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $created_by;
        $currency           = $common->getCurrency(true);

        $voucher_no = DB::table('erp_acct_voucher_no')
            ->insertGetId(
                [
                    'type'       => 'tax_payment',
                    'currency'   => $currency,
                    'created_at' => $data['created_at'],
                    'created_by' => $data['created_by'],
                    'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : null,
                    'updated_by' => isset($data['updated_by']) ? $data['updated_by'] : null,
                ]
            );

        $tax_data =$this->getFormattedTaxData($data);

        DB::table('erp_acct_tax_pay')
            ->insert(
                [
                    'voucher_no'   => $voucher_no,
                    'trn_date'     => $tax_data['trn_date'],
                    // translators: %s: voucher_no
                    'particulars'  => !empty($tax_data['particulars']) ? $tax_data['particulars'] : sprintf(__('Invoice created with voucher no %s', 'erp'), $voucher_no),
                    'amount'       => $tax_data['amount'],
                    'voucher_type' => $tax_data['voucher_type'],
                    'trn_by'       => $tax_data['trn_by'],
                    'agency_id'    => $tax_data['agency_id'],
                    'ledger_id'    => $tax_data['ledger_id'],
                    'created_at'   => $tax_data['created_at'],
                    'created_by'   => $tax_data['created_by'],
                    'updated_at'   => $tax_data['updated_at'],
                    'updated_by'   => $tax_data['updated_by'],
                ]
            );

        if ('debit' === $tax_data['voucher_type']) {
            $debit  = $tax_data['amount'];
            $credit = 0;
        } else {
            $debit  = 0;
            $credit = $tax_data['amount'];
        }

        // insert data into erp_acct_tax_agency_details
        DB::table('erp_acct_tax_agency_details')
            ->insert(
                [
                    'agency_id'   => $tax_data['agency_id'],
                    'trn_no'      => $voucher_no,
                    'trn_date'    => $tax_data['trn_date'],
                    // translators: %s: voucher_no
                    'particulars' => !empty($tax_data['particulars']) ? $tax_data['particulars'] : sprintf(__('Invoice created with voucher no %s', 'erp'), $voucher_no),
                    'debit'       => $debit,
                    'credit'      => $credit,
                    'created_at'  => $tax_data['created_at'],
                    'created_by'  => $tax_data['created_by'],
                ]
            );

        $tax_data['voucher_no'] = $voucher_no;

       $this->insertTaxPayDataIntoLedger($tax_data);

        $tax_pay =$this->getTaxPayRecord($voucher_no);


        return $tax_pay;
    }

    /**
     * Insert Tax pay data into ledger
     *
     * @param array $tax_data Tax Data
     *
     * @return mixed
     */
    public function insertTaxPayDataIntoLedger($tax_data)
    {


        if ('debit' === $tax_data['voucher_type']) {
            $debit  = 0;
            $credit = $tax_data['amount'];
        } else {
            $debit  = $tax_data['amount'];
            $credit = 0;
        }

        // Insert amount in ledger_details
        DB::table('erp_acct_ledger_details')
            ->insert(
                [
                    'ledger_id'   => $tax_data['ledger_id'],
                    'trn_no'      => $tax_data['voucher_no'],
                    'particulars' => $tax_data['particulars'],
                    'debit'       => $debit,
                    'credit'      => $credit,
                    'trn_date'    => $tax_data['trn_date'],
                    'created_at'  => $tax_data['created_at'],
                    'created_by'  => $tax_data['created_by'],
                    'updated_at'  => $tax_data['updated_at'],
                    'updated_by'  => $tax_data['updated_by'],
                ]
            );
    }

    /**
     * Format payment line items
     *
     * @param string $tax Tax Criteria
     *
     * @return array
     */
    public function formatTaxLineItems($tax = 'all')
    {


        $sql = 'SELECT id as db_id, tax_id, component_name, agency_id, tax_cat_id, tax_rate';

        if ('all' === $tax) {
            $tax_sql = '';
        } else {
            $tax_sql = 'WHERE tax_id = ' . $tax;
        }
        $sql .= " FROM erp_acct_tax_cat_agency {$tax_sql} ORDER BY tax_id";

        $results = DB::select($sql);

        return $results;
    }

    /**
     * Get formatted tax data
     *
     * @param array $data Filter Data
     *
     * @return mixed
     */
    public function getFormattedTaxData($data)
    {
        $tax_data = [];

        $tax_data['tax_rate_id']     = isset($data['tax_rate_name']) ? $data['tax_rate_name'] : '';
        $tax_data['tax_rate']        = isset($data['tax_rate']) ? $data['tax_rate'] : 0;
        $tax_data['tax_id']          = isset($data['tax_id']) ? $data['tax_id'] : 0;
        $tax_data['trn_by']          = isset($data['trn_by']) ? $data['trn_by'] : '';
        $tax_data['tax_category_id'] = isset($data['tax_category_id']) ? $data['tax_category_id'] : 0;
        $tax_data['agency_id']       = isset($data['agency_id']) ? $data['agency_id'] : 0;
        $tax_data['agency_name']     = isset($data['agency_name']) ? $data['agency_name'] : '';
        $tax_data['tax_cat_name']    = isset($data['tax_cat_name']) ? $data['tax_cat_name'] : '';
        $tax_data['tax_components']  = isset($data['tax_components']) ? $data['tax_components'] : [];
        $tax_data['created_at']      = date('Y-m-d');
        $tax_data['created_by']      = isset($data['created_by']) ? $data['created_by'] : '';
        $tax_data['updated_at']      = isset($data['updated_at']) ? $data['updated_at'] : null;
        $tax_data['updated_by']      = isset($data['updated_by']) ? $data['updated_by'] : '';
        $tax_data['name']            = isset($data['name']) ? $data['name'] : '';
        $tax_data['description']     = isset($data['description']) ? $data['description'] : '';
        $tax_data['voucher_no']      = isset($data['voucher_no']) ? $data['voucher_no'] : '';
        $tax_data['trn_date']        = isset($data['trn_date']) ? $data['trn_date'] : date('Y-m-d');
        $tax_data['tax_period']      = isset($data['tax_period']) ? $data['tax_period'] : '';
        $tax_data['particulars']     = isset($data['particulars']) ? $data['particulars'] : '';
        $tax_data['amount']          = isset($data['amount']) ? $data['amount'] : '';
        $tax_data['ledger_id']       = isset($data['ledger_id']) ? $data['ledger_id'] : '';
        $tax_data['voucher_type']    = isset($data['voucher_type']) ? $data['voucher_type'] : '';

        return $tax_data;
    }

    /**
     * Get formatted tax data
     *
     * @param array $data Data Filter
     *
     * @return mixed
     */
    public function getFormattedTaxLineData($data)
    {
        $tax_data = [];

        $tax_data['tax_id']         = isset($data['tax_id']) ? $data['tax_id'] : '';
        $tax_data['db_id']          = isset($data['db_id']) ? $data['db_id'] : '';
        $tax_data['rate_id']        = isset($data['rate_id']) ? $data['rate_id'] : '';
        $tax_data['component_name'] = isset($data['component_name']) ? $data['component_name'] : '';
        $tax_data['agency_id']      = isset($data['agency_id']) ? $data['agency_id'] : 0;
        $tax_data['tax_cat_id']     = isset($data['tax_cat_id']) ? $data['tax_cat_id'] : 0;
        $tax_data['tax_rate']       = isset($data['tax_rate']) ? $data['tax_rate'] : 0;
        $tax_data['created_at']     = isset($data['created_at']) ? $data['created_at'] : '';
        $tax_data['created_by']     = isset($data['created_by']) ? $data['created_by'] : '';
        $tax_data['updated_at']     = isset($data['updated_at']) ? $data['updated_at'] : null;
        $tax_data['updated_by']     = isset($data['updated_by']) ? $data['updated_by'] : '';

        return $tax_data;
    }

    /**
     * Tax summary
     * 
     * @return void
     */
    public function taxSummary()
    {


        //config()->set('database.connections.mysql.strict', false);
        //config()->set('database.connections.mysql.strict', true);

        return DB::select(
            "SELECT
        tax.id AS tax_rate_id,
        tax.tax_rate_name,
        tax.default,
        tca.tax_cat_id,
        sum(tca.tax_rate) AS tax_rate
        FROM erp_acct_tax_cat_agency AS tca
        INNER JOIN erp_acct_taxes AS tax ON tax.id = tca.tax_id
        GROUP BY tca.tax_cat_id, tax.id order by tax_cat_id"
        );
    }

    /**
     * Get default tax rate name id
     * 
     * @return void
     */
    public function getDefaultTaxRateNameId()
    {


        return DB::scalar("SELECT id FROM erp_acct_taxes WHERE `default` = 1");
    }

    /**
     * Inserts synced tax data
     *
     * @param array $args Data Filter
     *
     * @return int|string|null
     */
    public function insertSyncedTax($args = [])
    {


        $defaults = [
            'system_id'   => null,
            'sync_type'   => '',
            'sync_source' => '',
            'sync_id'     => null,
            'sync_slug'   => '',
        ];

        $args = array_merge($defaults, $args);

        if (empty($args['system_id']) || (empty($args['sync_slug']) && empty($args['sync_id']))) {
            return new \messageBag()->add('inconsistent-data', __('Inconsistent data provided', 'erp'));
        }

        $inserted = DB::table("erp_acct_synced_taxes", $args, ['%d', '%s', '%s', '%d', '%s']);

        return $inserted;
    }

    /**
     * Retrieves system id of synced tax data
     *
     * @param string     $sync_type   Sync Type
     * @param string     $sync_source Sync Source Type
     * @param int|string $sync_id     sync Id
     * @param string     $sync_slug   Sync Slug
     *
     * @return int|null
     */
    public function getSyncedTaxSystemId($sync_type, $sync_source, $sync_id = false, $sync_slug = false)
    {


        $sql  = "SELECT system_id
            FROM erp_acct_synced_taxes
            WHERE sync_type = %s
            AND sync_source = %s";

        $args = [$sync_type, $sync_source];

        if (false !== $sync_id) {
            $sql   .= " AND sync_id = %d";
            $args[] = $sync_id;
        }

        if (false !== $sync_slug) {
            $sql   .= " AND sync_slug = %s";
            $args[] = $sync_slug;
        }

        $system_id = DB::scalar($sql, $args);

        return $system_id;
    }
}
