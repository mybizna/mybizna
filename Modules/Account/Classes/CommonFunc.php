<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\People;

use Illuminate\Support\Facades\DB;

class CommonFunc
{

    // Default formats, they are overridden by WP options or by arguments to date methods
    const DATEONLYFORMAT        = 'F j, Y';
    const TIMEFORMAT            = 'g:i A';
    const HOURFORMAT            = 'g';
    const MINUTEFORMAT          = 'i';
    const MERIDIANFORMAT        = 'A';
    const DBDATEFORMAT          = 'Y-m-d';
    const DBDATETIMEFORMAT      = 'Y-m-d H:i:s';
    const DBTZDATETIMEFORMAT    = 'Y-m-d H:i:s O';
    const DBTIMEFORMAT          = 'H:i:s';
    const DBYEARMONTHTIMEFORMAT = 'Y-m';

    /**
     * Default datepicker format index.
     *
     * @since 4.11.0.1
     *
     * @var int
     */
    private static $default_datepicker_format_index = 1;

    private static $localized_months_full = [];
    private static $localized_months_short = [];
    private static $localized_weekdays = [];
    private static $localized_months = [];

    /**
     * Get global currency
     *
     * @param array $get_only_id Get Only Id
     *
     * @return string
     */
    public function getCurrency($get_only_id = false)
    {


        $usd = 148;

        $currency_id = config('erp_currency', $usd);

        if ($get_only_id) {
            return $currency_id;
        }

        $currency_name = DB::scalar(
            "SELECT name FROM erp_acct_currency_info WHERE id = %d",
            [$currency_id]
        );

        return $currency_name;
    }

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
     * Get different array from two array
     *
     * @param array $new_data    New Data
     * @param array $old_data    Old Data
     * @param array $is_seriazie Serialize
     *
     * @return array
     */
    public function getArrayDiff($new_data, $old_data, $is_seriazie = false)
    {
        $old_value   = $new_value   = [];
        $changes_key = array_keys(array_diff_assoc($new_data, $old_data));

        foreach ($changes_key as $key => $change_field_key) {
            $old_value[$change_field_key] = $old_data[$change_field_key];
            $new_value[$change_field_key] = $new_data[$change_field_key];
        }

        if (!$is_seriazie) {
            return [
                'new_value' => $new_value ? base64_encode($new_value)  : '',
                'old_value' => $old_value ? base64_encode($old_value)  : '',
            ];
        } else {
            return [
                'new_value' => $new_value,
                'old_value' => $old_value,
            ];
        }
    }
    /**
     * Upload attachments
     *
     * @param array $files File
     *
     * @return array
     */
    public function uploadAttachments($files)
    {
        if (!function_exists('wp_handle_upload')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $attachments = [];
        $movefiles   = [];

        // Formatting request for upload
        for ($i = 0; $i < count($files['name']); $i++) {
            $attachments[] = [
                'name'     => stripslashes($files['name'][$i]),
                'type'     => $files['type'][$i],
                'tmp_name' => stripslashes($files['tmp_name'][$i]),
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i],
            ];
        }

        foreach ($attachments as $attachment) {
            $movefiles[] = wp_handle_upload($attachment, ['test_form' => false]);
        }

        return $movefiles;
    }

    /**
     * Get payable data for given month
     *
     * @param string $from From
     * @param string $to   To
     *
     * @return array|object|null
     */
    public function getPayables($from, $to)
    {


        $from_date = date('Y-m-d', strtotime($from));
        $to_date   = date('Y-m-d', strtotime($to));

        $purchases             = 'erp_acct_purchase';
        $purchase_acct_details = 'erp_acct_purchase_account_details';

        $purchase_query = "Select voucher_no, SUM(ad.debit - ad.credit) as due, due_date
        FROM $purchases LEFT JOIN $purchase_acct_details as ad
        ON ad.purchase_no = voucher_no  where due_date
        BETWEEN {$from_date} and {$to_date} Group BY voucher_no Having due < 0 ";

        $purchase_results = DB::select($purchase_query);

        $bills             = 'erp_acct_bills';
        $bill_acct_details = 'erp_acct_bill_account_details';
        $bills_query       = "Select voucher_no, SUM(ad.debit - ad.credit) as due, due_date
        FROM $bills LEFT JOIN $bill_acct_details as ad
        ON ad.bill_no = voucher_no  where due_date
        BETWEEN { $from_date} and {$to_date} Group BY voucher_no Having due < 0";

        $bill_results = DB::select($bills_query);

        if (!empty($purchase_results) && !empty($bill_results)) {
            return array_merge($bill_results, $purchase_results);
        }

        if (empty($bill_results)) {
            return $purchase_results;
        }

        if (empty($purchase_results)) {
            return $bill_results;
        }
    }

    /**
     * Get Payable overview data
     *
     * @return array
     */
    public function getPayablesOverview()
    {
        // get dates till coming 90 days
        $from_date = date('Y-m-d');
        $to_date   = date('Y-m-d', strtotime('+90 day', strtotime($from_date)));

        $data   = [];
        $amount = [
            'first'  => 0,
            'second' => 0,
            'third'  => 0,
        ];

        $result = $this->getPayables($from_date, $to_date);

        if (!empty($result)) {
            $from_date = new \DateTime($from_date);

            foreach ($result as $item_data) {
                $item  = (object) $item_data;
                $later = new \DateTime($item->due_date);
                $diff  = $later->diff($from_date)->format('%a');

                //segment by date difference
                switch ($diff) {
                    case 0 === $diff:
                        $data['first'][] = $item_data;
                        $amount['first'] = $amount['first'] + abs($item->due);
                        break;

                    case $diff <= 30:
                        $data['first'][] = $item_data;
                        $amount['first'] = $amount['first'] + abs($item->due);
                        break;

                    case $diff <= 60:
                        $data['second'][] = $item_data;
                        $amount['second'] = $amount['second'] + abs($item->due);
                        break;

                    case $diff <= 90:
                        $data['third'][] = $item_data;
                        $amount['third'] = $amount['third'] + abs($item->due);
                        break;

                    default:
                }
            }
        }

        return [
            'data'   => $data,
            'amount' => $amount,
        ];
    }

    /**
     * Insert check data
     *
     * @param array $check_data Check Data
     *
     * @return void
     */
    public function insertCheckData($check_data)
    {


        DB::table('erp_acct_expense_checks')
            ->insert(
                [
                    'trn_no'       => $check_data['voucher_no'],
                    'check_no'     => $check_data['check_no'],
                    'voucher_type' => $check_data['voucher_type'],
                    'amount'       => $check_data['amount'],
                    'bank'         => $check_data['bank'],
                    'name'         => $check_data['name'],
                    'pay_to'       => $check_data['pay_to'],
                    'created_at'   => $check_data['created_at'],
                    'created_by'   => $check_data['created_by'],
                    'updated_at'   => $check_data['updated_at'],
                    'updated_by'   => $check_data['updated_by'],
                ]
            );
    }

    /**
     * Update check data
     *
     * @param array $check_data Check Data
     * @param int   $check_no   Check Number
     *
     * @return void
     */
    public function updateCheckData($check_data, $check_no)
    {


        DB::table('erp_acct_expense_checks')
            ->insert(
                [
                    'trn_no'       => $check_data['voucher_no'],
                    'voucher_type' => $check_data['voucher_type'],
                    'amount'       => $check_data['amount'],
                    'bank'         => $check_data['bank'],
                    'name'         => $check_data['name'],
                    'pay_to'       => $check_data['pay_to'],
                    'created_at'   => $check_data['created_at'],
                    'created_by'   => $check_data['created_by'],
                    'updated_at'   => $check_data['updated_at'],
                    'updated_by'   => $check_data['updated_by'],
                ],
                [
                    'check_no' => $check_no,
                ]
            );
    }

    /**
     * Get people name, email by id
     *
     * @param int $people_id People Id
     *
     * @return array
     */
    public function getPeopleInfoById($people_id)
    {


        $row = DB::select("SELECT first_name, last_name, email FROM erp_peoples WHERE id = %d LIMIT 1", [$people_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Get ledger name, slug by id
     *
     * @param int $ledger_id Ledger Id
     *
     * @return array
     */
    public function getLedgerById($ledger_id)
    {


        $row = DB::select("SELECT name, slug, code FROM erp_acct_ledgers WHERE id = %d LIMIT 1", [$ledger_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Get sing ledger row data by id, slug or code
     *
     * @param string $field string id, code or slug field name to search by
     * @param string $value string $field value to search
     *
     * @return array
     */
    public function getLedgerBy($field = 'id', $value = '')
    {


        $field = sanitize_text_field($field);
        // validate fields
        if (!in_array($field, ['id', 'code', 'slug'])) {
            return null;
        }

        if (empty($value)) {
            return null;
        }

        $row = DB::select(
            "SELECT * FROM erp_acct_ledgers WHERE $field = %s LIMIT 1",
            [$value]
        );

        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Get product type by id
     *
     * @param int $product_type_id Product Type Id
     *
     * @return array
     */
    public function getProductTypeById($product_type_id)
    {

        $row = DB::select("SELECT name FROM erp_acct_product_types WHERE id = %d LIMIT 1", [$product_type_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Get product category by id
     *
     * @param int $cat_id Cat Id
     *
     * @return array
     */
    public function getProductCategoryById($cat_id)
    {


        $row = DB::select("SELECT name FROM erp_acct_product_categories WHERE id = %d LIMIT 1", [$cat_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Get tax agency name by id
     *
     * @param int $agency_id Agency Id
     *
     * @return array
     */
    public function getTaxAgencyById($agency_id)
    {


        $row = DB::select("SELECT name FROM erp_acct_tax_agencies WHERE id = %d LIMIT 1", [$agency_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row->name;
    }

    /**
     * Get tax category by id
     *
     * @param int $cat_id Cat Id
     *
     * @return array
     */
    public function getTaxCategoryById($cat_id)
    {


        if (null !== $cat_id) {
            return DB::scalar("SELECT name FROM erp_acct_tax_categories WHERE id = %d", [$cat_id]);
        }

        return '';
    }

    /**
     * Get transaction status by id
     *
     * @param int $trn_id Transaction Id
     *
     * @return string
     */
    public function getTrnStatusById($trn_id)
    {


        if (!$trn_id) {
            return 'pending';
        }

        $row = DB::select("SELECT type_name FROM erp_acct_trn_status_types WHERE id = %d", [$trn_id]);

        $row = (!empty($row)) ? $row[0] : null;

        return ucfirst(str_replace('_', ' ', $row->type_name));
    }

    /**
     * Get payment method by id
     *
     * @param int $method_id Method Id
     *
     * @return array
     */
    public function getPaymentMethodById($method_id)
    {


        $row = DB::select("SELECT name FROM erp_acct_payment_methods WHERE id = %d LIMIT 1", [$method_id]);

        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Get payment method by id
     *
     * @param int $method_id Method Id
     *
     * @return string
     */
    public function getPaymentMethodNameById($method_id)
    {


        $row = DB::select("SELECT name FROM erp_acct_payment_methods WHERE id = %d LIMIT 1", [$method_id]);

        $row = (!empty($row)) ? $row[0] : null;

        return $row->name;
    }

    /**
     * Get check transaction type by id
     *
     * @param int $trn_type_id Transaction Type Id
     *
     * @return array
     */
    public function getCheckTrnTypeById($trn_type_id)
    {


        $row = DB::select("SELECT name FROM erp_acct_check_trn_tables WHERE id = %d LIMIT 1", [$trn_type_id]);

        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Retrieves tax category with agency
     *
     * @param int $tax_id     Tax Id
     * @param int $tax_cat_id Tax Cat Id
     *
     * @return array
     */
    public function getTaxRateWithAgency($tax_id, $tax_cat_id)
    {


        return DB::select(
            "SELECT agency_id, tax_rate
            FROM erp_acct_tax_cat_agency
            where tax_id = {$tax_id} and tax_cat_id = {$tax_cat_id}"
        );
    }

    /**
     * Retrieves agency wise tax rate for invoice items
     *
     * @param int|string $invoice_details_id Invoice Detail Id
     *
     * @return array
     */
    public function getInvoiceItemsAgencyWiseTaxRate($invoice_details_id)
    {


        $result = DB::select(
            "SELECT agency_id, tax_rate
            FROM erp_acct_invoice_details_tax
            WHERE invoice_details_id = {$invoice_details_id}"
        );

        return $result;
    }

    /**
     * Get Accounting Quick Access Menus
     *
     * @return array
     */
    public function quickAccessMenu()
    {
        $menus = [
            'invoice'         => [
                'title' => 'Invoice',
                'slug'  => 'invoice',
                'url'   => 'invoices/new',
            ],
            'estimate'        => [
                'title' => 'Estimate',
                'slug'  => 'estimate',
                'url'   => 'estimates/new',
            ],
            'rec_payment'     => [
                'title' => 'Receive Payment',
                'slug'  => 'payment',
                'url'   => 'payments/new',
            ],
            'bill'            => [
                'title' => 'Bill',
                'slug'  => 'bill',
                'url'   => 'bills/new',
            ],
            'pay_bill'        => [
                'title' => 'Pay Bill',
                'slug'  => 'pay_bill',
                'url'   => 'pay-bills/new',
            ],
            'purchase-order'  => [
                'title' => 'Purchase Order',
                'slug'  => 'purchase-orders',
                'url'   => 'purchase-orders/new',
            ],
            'purchase'        => [
                'title' => 'Purchase',
                'slug'  => 'purchase',
                'url'   => 'purchases/new',
            ],
            'pay_purchase'    => [
                'title' => 'Pay Purchase',
                'slug'  => 'pay_purchase',
                'url'   => 'pay-purchases/new',
            ],
            'expense'         => [
                'title' => 'Expense',
                'slug'  => 'expense',
                'url'   => 'expenses/new',
            ],
            'check'           => [
                'title' => 'Check',
                'slug'  => 'check',
                'url'   => 'checks/new',
            ],
            'journal'         => [
                'title' => 'Journal',
                'slug'  => 'journal',
                'url'   => 'transactions/journals/new',
            ],
            'tax_rate'        => [
                'title' => 'Tax Payment',
                'slug'  => 'pay_tax',
                'url'   => 'pay-tax',
            ],
            'opening_balance' => [
                'title' => __('Opening Balance', 'erp'),
                'slug'  => 'opening_balance',
                'url'   => 'opening-balance',
            ],
        ];

        return apply_filters('erp_acct_quick_menu', $menus);
    }

    /**
     * Change a string to slug
     *
     * @param int $str String to slugify
     *
     * @return string
     */
    public function slugify($str)
    {
        // replace non letter or digits by _
        $str = preg_replace('~[^\pL\d]+~u', '_', $str);

        return strtolower($str);
    }

    /**
     * Check voucher edit state
     *
     * @param int $id Voucher Id
     *
     * @return bool
     */
    public function checkVoucherEditState($id)
    {
        $res = DB::scalar("SELECT editable FROM erp_acct_voucher_no WHERE id = %d", [$id]);

        return !empty($res) ? true : false;
    }

    /**
     * Check if people exists in given types
     *
     * @param string $email Person Email
     * @param array $types People Type
     *
     * @return bool
     */
    public function existPeople($email, $types = [])
    {

        $people = new People();
        $people = $people->getPeopleBy('email', $email);

        // this $email belongs to nobody
        if (!$people) {
            return false;
        }

        if (empty($types)) {
            $types = ['customer', 'vendor'];
        }

        foreach ($types as $type) {
            if (in_array($type, $people->types, true)) {
                return $type;
            }
        }

        return false;
    }

    /**
     * Get transaction id by status slug
     *
     * @param string $slug Status Slug
     *
     * @return int
     */
    public function trnStatusById($slug)
    {


        return DB::scalar("SELECT id FROM erp_acct_trn_status_types WHERE slug = %s", [$slug]);
    }

    /**
     * Get all transaction statuses
     *
     * @return array
     */
    public function getAllTrnStatuses()
    {


        return DB::select("SELECT id,type_name as name, slug FROM erp_acct_trn_status_types");
    }


    /**
     * Auto create customer when creating CRM contact/company
     *
     * @param int|string $customer_id ID of the people that has been created
     * @param array      $data        Data of the newly created people
     * @param string     $people_type Type of the newly created people
     *
     * @return mixed
     */
    public function customerCreateFromCrm($customer_id, $data, $people_type)
    {

        $people = new People();
        if ('contact' === $people_type || 'company' === $people_type) {
            $customer_auto_import = (int) config('customer_auto_import', false, 0);
            $crm_user_type        = config('crm_user_type', false, []); // Contact or Company
            // Check whether the email already exists in Accounting
            $exists_people        = $this->existPeople($data['email'], ['customer', 'vendor']);

            if (!$exists_people && $customer_auto_import && count($crm_user_type)) {
                // No need to add wordpress `user id` again
                // `user id` already added when contact is created
                $data['is_wp_user'] = false;
                $data['wp_user_id'] = '';
                $data['people_id'] = $customer_id;
                $data['type']      = 'customer';

                $people->convertToPeople($data);
            }
        }
    }

    /**
     * Insert Payment/s data into "Bank Transaction Charge"
     *
     * @param array $payment_data Payment Data Filter
     *
     * @return mixed
     */
    public function insertBankTransactionChargeIntoLedger($payment_data)
    {


        if (1 === $payment_data['status'] || (isset($payment_data['trn_by']) && 4 === $payment_data['trn_by'])) {
            return;
        }

        // Insert amount in ledger_details
        // get ledger id of "Bank Transaction Charge"
        $ledger_data = $this->getLedgerBy('slug', 'bank_transaction_charge');

        if (empty($ledger_data)) {
            return;
        }

        DB::table('erp_acct_ledger_details')
            ->insert(
                array(
                    'ledger_id'   => $ledger_data['id'],
                    'trn_no'      => $payment_data['voucher_no'],
                    'particulars' => $payment_data['particulars'],
                    'debit'       => $payment_data['bank_trn_charge'],
                    'credit'      => 0,
                    'trn_date'    => $payment_data['trn_date'],
                    'created_at'  => $payment_data['created_at'],
                    'created_by'  => $payment_data['created_by'],
                    'updated_at'  => $payment_data['updated_at'],
                    'updated_by'  => $payment_data['updated_by'],
                )
            );

        DB::table('erp_acct_ledger_details')
            ->insert(
                array(
                    'ledger_id'   => $payment_data['trn_by_ledger_id'],
                    'trn_no'      => $payment_data['voucher_no'],
                    'particulars' => $payment_data['particulars'],
                    'debit'       => 0,
                    'credit'      => $payment_data['bank_trn_charge'],
                    'trn_date'    => $payment_data['trn_date'],
                    'created_at'  => $payment_data['created_at'],
                    'created_by'  => $payment_data['created_by'],
                    'updated_at'  => $payment_data['updated_at'],
                    'updated_by'  => $payment_data['updated_by'],
                )
            );
    }

    /**
     * Get State name by country and state code
     *
     * @param string $country Country
     * @param string $state   State
     *
     * @return string
     */
    public function getStateName($country, $state)
    {
        $load_cuntries_states = Countries::instance();
        $states               = $load_cuntries_states->states;

        // Handle full state name
        $full_state = ($country && $state && isset($states[$country][$state])) ? $states[$country][$state] : $state;

        return $full_state;
    }

    /**
     * Get Country name by country code
     *
     * @param string $country Code
     *
     * @return string
     */
    public function getCountryName($country)
    {
        $load_cuntries_states = Countries::instance();
        $countries            = $load_cuntries_states->countries;

        // Handle full country name
        if ('-1' != $country) {
            $full_country = (isset($countries[$country])) ? $countries[$country] : $country;
        } else {
            $full_country = '—';
        }

        return $full_country;
    }


    /**
     * Get the datepickerFormat index.
     *
     * @since 4.11.0.1
     *
     * @return int
     */
    public static function get_datepicker_format_index()
    {
        /**
         * Filter the datepickerFormat index.
         *
         * @since 4.11.0.1
         *
         * @param int $format_index Index of datepickerFormat.
         */
        return apply_filters('mybizna_datepicker_format_index', config('datepickerFormat', static::$default_datepicker_format_index));
    }

    /**
     * Try to format a Date to the Default Datepicker format
     *
     * @since  4.5.12
     *
     * @param  string      $date       Original Date that came from a datepicker
     * @param  string|int  $datepicker Datepicker format
     * @return string
     */
    public static function maybe_format_from_datepicker($date, $datepicker = null)
    {
        if (!is_numeric($datepicker)) {
            $datepicker = self::get_datepicker_format_index();
        }

        if (is_numeric($datepicker)) {
            $datepicker = self::datepicker_formats($datepicker);
        }

        $default_datepicker = self::datepicker_formats(1);

        // If the current datepicker is the default we don't care
        if ($datepicker === $default_datepicker) {
            return $date;
        }

        return self::datetime_from_format($datepicker, $date);
    }

    /**
     * Get the datepicker format, that is used to translate the option from the DB to a string
     *
     * @param  int $translate The db Option from datepickerFormat
     * @return string|array            If $translate is not set returns the full array, if not returns the `Y-m-d`
     */
    public static function datepicker_formats($translate = null)
    {

        // The datepicker has issues when a period separator and no leading zero is used. Those formats are purposefully omitted.
        $formats = [
            0     => 'Y-m-d',
            1     => 'n/j/Y',
            2     => 'm/d/Y',
            3     => 'j/n/Y',
            4     => 'd/m/Y',
            5     => 'n-j-Y',
            6     => 'm-d-Y',
            7     => 'j-n-Y',
            8     => 'd-m-Y',
            9     => 'Y.m.d',
            10    => 'm.d.Y',
            11    => 'd.m.Y',
            'm0'  => 'Y-m',
            'm1'  => 'n/Y',
            'm2'  => 'm/Y',
            'm3'  => 'n/Y',
            'm4'  => 'm/Y',
            'm5'  => 'n-Y',
            'm6'  => 'm-Y',
            'm7'  => 'n-Y',
            'm8'  => 'm-Y',
            'm9'  => 'Y.m',
            'm10' => 'm.Y',
            'm11' => 'm.Y',
        ];

        if (is_null($translate)) {
            return $formats;
        }

        return isset($formats[$translate]) ? $formats[$translate] : $formats[static::get_datepicker_format_index()];
    }

    /**
     * As PHP 5.2 doesn't have a good version of `date_parse_from_format`, this is how we deal with
     * possible weird datepicker formats not working
     *
     * @param  string $format The weird format you are using
     * @param  string $date   The date string to parse
     *
     * @return string         A DB formated Date, includes time if possible
     */
    public static function datetime_from_format($format, $date)
    {
        // Reverse engineer the relevant date formats
        $keys = [
            // Year with 4 Digits
            'Y' => ['year', '\d{4}'],

            // Year with 2 Digits
            'y' => ['year', '\d{2}'],

            // Month with leading 0
            'm' => ['month', '\d{2}'],

            // Month without the leading 0
            'n' => ['month', '\d{1,2}'],

            // Month ABBR 3 letters
            'M' => ['month', '[A-Z][a-z]{2}'],

            // Month Name
            'F' => ['month', '[A-Z][a-z]{2,8}'],

            // Day with leading 0
            'd' => ['day', '\d{2}'],

            // Day without leading 0
            'j' => ['day', '\d{1,2}'],

            // Day ABBR 3 Letters
            'D' => ['day', '[A-Z][a-z]{2}'],

            // Day Name
            'l' => ['day', '[A-Z][a-z]{5,8}'],

            // Hour 12h formatted, with leading 0
            'h' => ['hour', '\d{2}'],

            // Hour 24h formatted, with leading 0
            'H' => ['hour', '\d{2}'],

            // Hour 12h formatted, without leading 0
            'g' => ['hour', '\d{1,2}'],

            // Hour 24h formatted, without leading 0
            'G' => ['hour', '\d{1,2}'],

            // Minutes with leading 0
            'i' => ['minute', '\d{2}'],

            // Seconds with leading 0
            's' => ['second', '\d{2}'],
        ];

        $date_regex = "/{$keys['Y'][1]}-{$keys['m'][1]}-{$keys['d'][1]}( {$keys['H'][1]}:{$keys['i'][1]}:{$keys['s'][1]})?$/";

        // if the date is already in Y-m-d or Y-m-d H:i:s, just return it
        if (preg_match($date_regex, $date)) {
            return $date;
        }


        // Convert format string to regex
        $regex = '';
        $chars = str_split($format);
        foreach ($chars as $n => $char) {
            $last_char = isset($chars[$n - 1]) ? $chars[$n - 1] : '';
            $skip_current = '\\' == $last_char;
            if (!$skip_current && isset($keys[$char])) {
                $regex .= '(?P<' . $keys[$char][0] . '>' . $keys[$char][1] . ')';
            } elseif ('\\' == $char) {
                $regex .= $char;
            } else {
                $regex .= preg_quote($char);
            }
        }

        $dt = [];

        // Now try to match it
        if (preg_match('#^' . $regex . '$#', $date, $dt)) {
            // Remove unwanted Indexes
            foreach ($dt as $k => $v) {
                if (is_int($k)) {
                    unset($dt[$k]);
                }
            }

            // We need at least Month + Day + Year to work with
            if (!checkdate($dt['month'], $dt['day'], $dt['year'])) {
                return false;
            }
        } else {
            return false;
        }

        $dt['month'] = str_pad($dt['month'], 2, '0', STR_PAD_LEFT);
        $dt['day'] = str_pad($dt['day'], 2, '0', STR_PAD_LEFT);

        $formatted = '{year}-{month}-{day}' . (isset($dt['hour'], $dt['minute'], $dt['second']) ? ' {hour}:{minute}:{second}' : '');
        foreach ($dt as $key => $value) {
            $formatted = str_replace('{' . $key . '}', $value, $formatted);
        }

        return $formatted;
    }

    /**
     * Returns the date only.
     *
     * @param int|string $date        The date (timestamp or string).
     * @param bool       $isTimestamp Is $date in timestamp format?
     * @param string|null $format The format used
     *
     * @return string The date only in DB format.
     */
    public static function date_only($date, $isTimestamp = false, $format = null)
    {
        $date = $isTimestamp ? $date : strtotime($date);

        if (is_null($format)) {
            $format = self::DBDATEFORMAT;
        }

        return date($format, $date);
    }

    /**
     * Returns as string the nearest half a hour for a given valid string datetime.
     *
     * @since  4.10.2
     *
     * @param string $date Valid DateTime string.
     *
     * @return string Rounded datetime string
     */
    public static function round_nearest_half_hour($date)
    {
        $date_object = static::build_date_object($date);
        $rounded_minutes = floor($date_object->format('i') / 30) * 30;

        return $date_object->format('Y-m-d H:') . $rounded_minutes . ':00';
    }

    /**
     * Returns the time only.
     *
     * @param string $date The date.
     *
     * @return string The time only in DB format.
     */
    public static function time_only($date)
    {
        $date = is_numeric($date) ? $date : strtotime($date);
        return date(self::DBTIMEFORMAT, $date);
    }

    /**
     * Returns the hour only.
     *
     * @param string $date The date.
     *
     * @return string The hour only.
     */
    public static function hour_only($date)
    {
        $date = is_numeric($date) ? $date : strtotime($date);
        return date(self::HOURFORMAT, $date);
    }

    /**
     * Returns the minute only.
     *
     * @param string $date The date.
     *
     * @return string The minute only.
     */
    public static function minutes_only($date)
    {
        $date = is_numeric($date) ? $date : strtotime($date);
        return date(self::MINUTEFORMAT, $date);
    }

    /**
     * Returns the meridian (am or pm) only.
     *
     * @param string $date The date.
     *
     * @return string The meridian only in DB format.
     */
    public static function meridian_only($date)
    {
        $date = is_numeric($date) ? $date : strtotime($date);
        return date(self::MERIDIANFORMAT, $date);
    }

    /**
     * Returns the number of seconds (absolute value) between two dates/times.
     *
     * @param string $date1 The first date.
     * @param string $date2 The second date.
     *
     * @return int The number of seconds between the dates.
     */
    public static function time_between($date1, $date2)
    {
        return abs(strtotime($date1) - strtotime($date2));
    }

    /**
     * The number of days between two arbitrary dates.
     *
     * @param string $date1 The first date.
     * @param string $date2 The second date.
     *
     * @return int The number of days between two dates.
     */
    public static function date_diff($date1, $date2)
    {
        // Get number of days between by finding seconds between and dividing by # of seconds in a day
        $days = self::time_between($date1, $date2) / (60 * 60 * 24);

        return $days;
    }

    /**
     * Returns the last day of the month given a php date.
     *
     * @param int $timestamp THe timestamp.
     *
     * @return string The last day of the month.
     */
    public static function get_last_day_of_month($timestamp)
    {
        $curmonth  = date('n', $timestamp);
        $curYear   = date('Y', $timestamp);
        $nextmonth = mktime(0, 0, 0, $curmonth + 1, 1, $curYear);
        $lastDay   = strtotime(date(self::DBDATETIMEFORMAT, $nextmonth) . ' - 1 day');

        return date('j', $lastDay);
    }

    /**
     * Returns true if the timestamp is a weekday.
     *
     * @param int $curDate A timestamp.
     *
     * @return bool If the timestamp is a weekday.
     */
    public static function is_weekday($curdate)
    {
        return in_array(date('N', $curdate), [1, 2, 3, 4, 5]);
    }

    /**
     * Returns true if the timestamp is a weekend.
     *
     * @param int $curDate A timestamp.
     *
     * @return bool If the timestamp is a weekend.
     */
    public static function is_weekend($curdate)
    {
        return in_array(date('N', $curdate), [6, 7]);
    }

    /**
     * Gets the last day of the week in a month (ie the last Tuesday).  Passing in -1 gives you the last day in the month.
     *
     * @param int $curdate     A timestamp.
     * @param int $day_of_week The index of the day of the week.
     *
     * @return int The timestamp of the date that fits the qualifications.
     */
    public static function get_last_day_of_week_in_month($curdate, $day_of_week)
    {
        $nextdate = mktime(date('H', $curdate), date('i', $curdate), date('s', $curdate), date('n', $curdate), self::get_last_day_of_month($curdate), date('Y', $curdate));;

        while (date('N', $nextdate) != $day_of_week && $day_of_week != -1) {
            $nextdate = strtotime(date(self::DBDATETIMEFORMAT, $nextdate) . ' - 1 day');
        }

        return $nextdate;
    }

    /**
     * Gets the first day of the week in a month (ie the first Tuesday).
     *
     * @param int $curdate     A timestamp.
     * @param int $day_of_week The index of the day of the week.
     *
     * @return int The timestamp of the date that fits the qualifications.
     */
    public static function get_first_day_of_week_in_month($curdate, $day_of_week)
    {
        $nextdate = mktime(0, 0, 0, date('n', $curdate), 1, date('Y', $curdate));

        while (
            !($day_of_week > 0 && date('N', $nextdate) == $day_of_week) &&
            !($day_of_week == -1 && self::is_weekday($nextdate)) &&
            !($day_of_week == -2 && self::is_weekend($nextdate))
        ) {
            $nextdate = strtotime(date(self::DBDATETIMEFORMAT, $nextdate) . ' + 1 day');
        }

        return $nextdate;
    }

    /**
     * From http://php.net/manual/en/function.date.php
     *
     * @param int $number A number.
     *
     * @return string The ordinal for that number.
     */
    public static function number_to_ordinal($number)
    {
        $output = $number . (((strlen($number) > 1) && (substr($number, -2, 1) == '1')) ?
            'th' : date('S', mktime(0, 0, 0, 0, substr($number, -1), 0)));

        return apply_filters('mybizna_events_number_to_ordinal', $output, $number);
    }

    /**
     * check if a given string is a timestamp
     *
     * @param $timestamp
     *
     * @return bool
     */
    public static function is_timestamp($timestamp)
    {
        if (is_numeric($timestamp) && (int) $timestamp == $timestamp && date('U', $timestamp) == $timestamp) {
            return true;
        }

        return false;
    }

    /**
     * Accepts a string representing a date/time and attempts to convert it to
     * the specified format, returning an empty string if this is not possible.
     *
     * @param $dt_string
     * @param $new_format
     *
     * @return string
     */
    public static function reformat($dt_string, $new_format)
    {
        $timestamp = self::is_timestamp($dt_string) ? $dt_string : strtotime($dt_string);
        $revised   = date($new_format, $timestamp);

        return $revised ? $revised : '';
    }

    /**
     * Accepts a numeric offset (such as "4" or "-6" as stored in the gmt_offset
     * option) and converts it to a strtotime() style modifier that can be used
     * to adjust a DateTime object, etc.
     *
     * @param $offset
     *
     * @return string
     */
    public static function get_modifier_from_offset($offset)
    {
        $modifier = '';
        $offset   = (float) $offset;

        // Separate out hours, minutes, polarity
        $hours    = (int) $offset;
        $minutes  = (int) (($offset - $hours) * 60);
        $polarity = ($offset >= 0) ? '+' : '-';

        // Correct hours and minutes to positive values
        if ($hours < 0)   $hours *= -1;
        if ($minutes < 0) $minutes *= -1;

        // Form the modifier string
        if ($hours >= 0)  $modifier  = "$polarity $hours hours ";
        if ($minutes > 0) $modifier .= "$minutes minutes";

        return $modifier;
    }

    /**
     * Returns the weekday of the 1st day of the month in
     * "w" format (ie, Sunday is 0 and Saturday is 6) or
     * false if this cannot be established.
     *
     * @param  mixed $month
     * @return int|bool
     */
    public static function first_day_in_month($month)
    {
        try {
            $date  = new \DateTime($month);
            $day_1 = new \DateTime($date->format('Y-m-01 '));
            return $day_1->format('w');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns the weekday of the last day of the month in
     * "w" format (ie, Sunday is 0 and Saturday is 6) or
     * false if this cannot be established.
     *
     * @param  mixed $month
     * @return int|bool
     */
    public static function last_day_in_month($month)
    {
        try {
            $date  = new \DateTime($month);
            $day_1 = new \DateTime($date->format('Y-m-t'));
            return $day_1->format('w');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns the day of the week the week ends on, expressed as a "w" value
     * (ie, Sunday is 0 and Saturday is 6).
     *
     * @param  int $week_starts_on
     *
     * @return int
     */
    public static function week_ends_on($week_starts_on)
    {
        if (--$week_starts_on < 0) $week_starts_on = 6;
        return $week_starts_on;
    }

    /**
     * Helper method to convert EventAllDay values to a boolean
     *
     * @param mixed $all_day_value Value to check for "all day" status. All day values: (true, 'true', 'TRUE', 'yes')
     *
     * @return boolean Is value considered "All Day"?
     */
    public static function is_all_day($all_day_value)
    {
        $all_day_value = trim($all_day_value);

        return ('true' === strtolower($all_day_value)
            || 'yes' === strtolower($all_day_value)
            || true === $all_day_value
            || 1 == $all_day_value
        );
    }

    /**
     * Given 2 datetime ranges, return whether the 2nd one occurs during the 1st one
     * Note: all params should be unix timestamps
     *
     * @param integer $range_1_start timestamp for start of the first range
     * @param integer $range_1_end timestamp for end of the first range
     * @param integer $range_2_start timestamp for start of the second range
     * @param integer $range_2_end timestamp for end of the second range
     *
     * @return bool
     */
    public static function range_coincides($range_1_start, $range_1_end, $range_2_start, $range_2_end)
    {

        // Initialize the return value
        $range_coincides = false;

        /**
         * conditions:
         * range 2 starts during range 1 (range 2 start time is between start and end of range 1 )
         * range 2 ends during range 1 (range 2 end time is between start and end of range 1 )
         * range 2 encloses range 1 (range 2 starts before range 1 and ends after range 1)
         */

        $range_2_starts_during_range_1 = $range_2_start >= $range_1_start && $range_2_start < $range_1_end;
        $range_2_ends_during_range_1   = $range_2_end > $range_1_start && $range_2_end <= $range_1_end;
        $range_2_encloses_range_1      = $range_2_start < $range_1_start && $range_2_end > $range_1_end;

        if ($range_2_starts_during_range_1 || $range_2_ends_during_range_1 || $range_2_encloses_range_1) {
            $range_coincides = true;
        }

        return $range_coincides;
    }

    /**
     * Converts a locally-formatted date to a unix timestamp. This is a drop-in
     * replacement for `strtotime()`, except that where strtotime assumes GMT, this
     * assumes local time (as described below). If a timezone is specified, this
     * function defers to strtotime().
     *
     * If there is a timezone_string available, the date is assumed to be in that
     * timezone, otherwise it simply subtracts the value of the 'gmt_offset'
     * option.
     *
     * @see  strtotime()
     * @uses get_option() to retrieve the value of 'gmt_offset'
     *
     * @param string $string A date/time string. See `strtotime` for valid formats
     *
     * @return int UNIX timestamp.
     */
    public static function wp_strtotime($string)
    {
        // If there's a timezone specified, we shouldn't convert it
        try {
            $test_date = new \DateTime($string);
            if ('UTC' != $test_date->getTimezone()->getName()) {
                return strtotime($string);
            }
        } catch (\Exception $e) {
            return strtotime($string);
        }

        $tz = config('timezone_string');
        if (!empty($tz)) {
            $date = date_create($string, new \DateTimeZone($tz));
            if (!$date) {
                return strtotime($string);
            }
            $date->setTimezone(new \DateTimeZone('UTC'));
            return $date->format('U');
        } else {
            $offset = (float) config('gmt_offset');
            $seconds = intval($offset * 3600);
            $timestamp = strtotime($string) - $seconds;
            return $timestamp;
        }
    }

    /**
     * Returns an array of localized full month names.
     *
     * @return array
     */
    public static function get_localized_months_full()
    {
        global $wp_locale;

        if (empty(self::$localized_months)) {
            self::build_localized_months();
        }

        if (empty(self::$localized_months_full)) {
            self::$localized_months_full = [
                'January'   => self::$localized_months['full']['01'],
                'February'  => self::$localized_months['full']['02'],
                'March'     => self::$localized_months['full']['03'],
                'April'     => self::$localized_months['full']['04'],
                'May'       => self::$localized_months['full']['05'],
                'June'      => self::$localized_months['full']['06'],
                'July'      => self::$localized_months['full']['07'],
                'August'    => self::$localized_months['full']['08'],
                'September' => self::$localized_months['full']['09'],
                'October'   => self::$localized_months['full']['10'],
                'November'  => self::$localized_months['full']['11'],
                'December'  => self::$localized_months['full']['12'],
            ];
        }

        return self::$localized_months_full;
    }

    /**
     * Returns an array of localized short month names.
     *
     * @return array
     */
    public static function get_localized_months_short()
    {
        global $wp_locale;

        if (empty(self::$localized_months)) {
            self::build_localized_months();
        }

        if (empty(self::$localized_months_short)) {
            self::$localized_months_short = [
                'Jan' => self::$localized_months['short']['01'],
                'Feb' => self::$localized_months['short']['02'],
                'Mar' => self::$localized_months['short']['03'],
                'Apr' => self::$localized_months['short']['04'],
                'May' => self::$localized_months['short']['05'],
                'Jun' => self::$localized_months['short']['06'],
                'Jul' => self::$localized_months['short']['07'],
                'Aug' => self::$localized_months['short']['08'],
                'Sep' => self::$localized_months['short']['09'],
                'Oct' => self::$localized_months['short']['10'],
                'Nov' => self::$localized_months['short']['11'],
                'Dec' => self::$localized_months['short']['12'],
            ];
        }

        return self::$localized_months_short;
    }

    /**
     * Returns an array of localized full week day names.
     *
     * @return array
     */
    public static function get_localized_weekdays_full()
    {
        if (empty(self::$localized_weekdays)) {
            self::build_localized_weekdays();
        }

        return self::$localized_weekdays['full'];
    }

    /**
     * Returns an array of localized short week day names.
     *
     * @return array
     */
    public static function get_localized_weekdays_short()
    {
        if (empty(self::$localized_weekdays)) {
            self::build_localized_weekdays();
        }

        return self::$localized_weekdays['short'];
    }

    /**
     * Returns an array of localized week day initials.
     *
     * @return array
     */
    public static function get_localized_weekdays_initial()
    {
        if (empty(self::$localized_weekdays)) {
            self::build_localized_weekdays();
        }

        return self::$localized_weekdays['initial'];
    }

    /**
     * Builds arrays of localized full, short and initialized weekdays.
     */
    private static function build_localized_weekdays()
    {
        global $wp_locale;

        for ($i = 0; $i <= 6; $i++) {
            $day = $wp_locale->get_weekday($i);
            self::$localized_weekdays['full'][$i]    = $day;
            self::$localized_weekdays['short'][$i]   = $wp_locale->get_weekday_abbrev($day);
            self::$localized_weekdays['initial'][$i] = $wp_locale->get_weekday_initial($day);
        }
    }

    /**
     * Builds arrays of localized full and short months.
     *
     * @since 4.4.3
     */
    private static function build_localized_months()
    {
        global $wp_locale;

        for ($i = 1; $i <= 12; $i++) {
            $month_number = str_pad($i, 2, '0', STR_PAD_LEFT);
            $month        = $wp_locale->get_month($month_number);
            self::$localized_months['full'][$month_number]  = $month;
            self::$localized_months['short'][$month_number] = $wp_locale->get_month_abbrev($month);
        }
    }

    /**
     * Return a WP Locale weekday in the specified format
     *
     * @since 4.4.3
     *
     * @param int|string $weekday Day of week
     * @param string $format Weekday format: full, weekday, initial, abbreviation, abbrev, abbr, short
     *
     * @return string
     */
    public static function wp_locale_weekday($weekday, $format = 'weekday')
    {
        $weekday = trim($weekday);

        $valid_formats = [
            'full',
            'weekday',
            'initial',
            'abbreviation',
            'abbrev',
            'abbr',
            'short',
        ];

        // if there isn't a valid format, bail without providing a localized string
        if (!in_array($format, $valid_formats)) {
            return $weekday;
        }

        if (empty(self::$localized_weekdays)) {
            self::build_localized_weekdays();
        }

        // if the weekday isn't numeric, we need to convert to numeric in order to
        // leverage self::localized_weekdays
        if (!is_numeric($weekday)) {
            $days_of_week = [
                'Sun',
                'Mon',
                'Tue',
                'Wed',
                'Thu',
                'Fri',
                'Sat',
            ];

            $day_index = array_search(ucwords(substr($weekday, 0, 3)), $days_of_week);

            if (false === $day_index) {
                return $weekday;
            }

            $weekday = $day_index;
        }

        switch ($format) {
            case 'initial':
                $type = 'initial';
                break;
            case 'abbreviation':
            case 'abbrev':
            case 'abbr':
            case 'short':
                $type = 'short';
                break;
            case 'weekday':
            case 'full':
            default:
                $type = 'full';
                break;
        }

        return self::$localized_weekdays[$type][$weekday];
    }

    /**
     * Return a WP Locale month in the specified format
     *
     * @since 4.4.3
     *
     * @param int|string $month Month of year
     * @param string $format Month format: full, month, abbreviation, abbrev, abbr, short
     *
     * @return string
     */
    public static function wp_locale_month($month, $format = 'month')
    {
        $month = trim($month);

        $valid_formats = [
            'full',
            'month',
            'abbreviation',
            'abbrev',
            'abbr',
            'short',
        ];

        // if there isn't a valid format, bail without providing a localized string
        if (!in_array($format, $valid_formats)) {
            return $month;
        }

        if (empty(self::$localized_months)) {
            self::build_localized_months();
        }

        // make sure numeric months are valid
        if (is_numeric($month)) {
            $month_num = (int) $month;

            // if the month num falls out of range, bail without localizing
            if (0 > $month_num || 12 < $month_num) {
                return $month;
            }
        } else {
            $months = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec',
            ];

            // convert the provided month to a 3-character month and find it in the months array so we
            // can build an appropriate month number
            $month_num = array_search(ucwords(substr($month, 0, 3)), $months);

            // if we can't find the provided month in our month list, bail without localizing
            if (false === $month_num) {
                return $month;
            }

            // let's increment the num because months start at 01 rather than 00
            $month_num++;
        }

        $month_num = str_pad($month_num, 2, '0', STR_PAD_LEFT);

        $type = ('full' === $format || 'month' === $format) ? 'full' : 'short';

        return self::$localized_months[$type][$month_num];
    }

    // DEPRECATED METHODS
    // @codingStandardsIgnoreStart
    /**
     * Deprecated camelCase version of self::date_only
     *
     * @param int|string $date        The date (timestamp or string).
     * @param bool       $isTimestamp Is $date in timestamp format?
     *
     * @return string The date only in DB format.
     */
    public static function dateOnly($date, $isTimestamp = false)
    {
        return self::date_only($date, $isTimestamp);
    }

    /**
     * Deprecated camelCase version of self::time_only
     *
     * @param string $date The date.
     *
     * @return string The time only in DB format.
     */
    public static function timeOnly($date)
    {
        return self::time_only($date);
    }

    /**
     * Deprecated camelCase version of self::hour_only
     *
     * @param string $date The date.
     *
     * @return string The hour only.
     */
    public static function hourOnly($date)
    {
        return self::hour_only($date);
    }

    /**
     * Deprecated camelCase version of self::minutes_only
     *
     * @param string $date The date.
     *
     * @return string The minute only.
     */
    public static function minutesOnly($date)
    {
        return self::minutes_only($date);
    }

    /**
     * Deprecated camelCase version of self::meridian_only
     *
     * @param string $date The date.
     *
     * @return string The meridian only in DB format.
     */
    public static function meridianOnly($date)
    {
        return self::meridian_only($date);
    }

    /**
     * Returns the end of a given day.
     *
     * @deprecated since 3.10 - use mybizna_event_end_of_day()
     * @todo       remove in 4.1
     *
     * @param int|string $date        The date (timestamp or string).
     * @param bool       $isTimestamp Is $date in timestamp format?
     *
     * @return string The date and time of the end of a given day
     */
    public static function endOfDay($date, $isTimestamp = false)
    {

        if ($isTimestamp) {
            $date = date(self::DBDATEFORMAT, $date);
        }

        return mybizna_event_end_of_day($date, self::DBDATETIMEFORMAT);
    }

    /**
     * Returns the beginning of a given day.
     *
     * @deprecated since 3.10
     * @todo       remove in 4.1
     *
     * @param int|string $date        The date (timestamp or string).
     * @param bool       $isTimestamp Is $date in timestamp format?
     *
     * @return string The date and time of the beginning of a given day.
     */
    public static function eventBeginningOfDay($date, $isTimestamp = false)
    {

        if ($isTimestamp) {
            $date = date(self::DBDATEFORMAT, $date);
        }

        return mybizna_event_beginning_of_day($date, self::DBDATETIMEFORMAT);
    }

    /**
     * Deprecated camelCase version of self::time_between
     *
     * @param string $date1 The first date.
     * @param string $date2 The second date.
     *
     * @return int The number of seconds between the dates.
     */
    public static function timeBetween($date1, $date2)
    {
        return self::time_between($date1, $date2);
    }

    /**
     * Deprecated camelCase version of self::date_diff
     *
     * @param string $date1 The first date.
     * @param string $date2 The second date.
     *
     * @return int The number of days between two dates.
     */
    public static function dateDiff($date1, $date2)
    {
        return self::date_diff($date1, $date2);
    }

    /**
     * Deprecated camelCase version of self::get_last_day_of_month
     *
     * @param int $timestamp THe timestamp.
     *
     * @return string The last day of the month.
     */
    public static function getLastDayOfMonth($timestamp)
    {
        return self::get_last_day_of_month($timestamp);
    }

    /**
     * Deprecated camelCase version of self::is_weekday
     *
     * @param int $curDate A timestamp.
     *
     * @return bool If the timestamp is a weekday.
     */
    public static function isWeekday($curdate)
    {
        return self::is_weekday($curdate);
    }

    /**
     * Deprecated camelCase version of self::is_weekend
     *
     * @param int $curDate A timestamp.
     *
     * @return bool If the timestamp is a weekend.
     */
    public static function isWeekend($curdate)
    {
        return self::is_weekend($curdate);
    }

    /**
     * Deprecated camelCase version of self::get_last_day_of_week_in_month
     *
     * @param int $curdate     A timestamp.
     * @param int $day_of_week The index of the day of the week.
     *
     * @return int The timestamp of the date that fits the qualifications.
     */
    public static function getLastDayOfWeekInMonth($curdate, $day_of_week)
    {
        return self::get_last_day_of_week_in_month($curdate, $day_of_week);
    }

    /**
     * Deprecated camelCase version of self::get_first_day_of_week_in_month
     *
     * @param int $curdate     A timestamp.
     * @param int $day_of_week The index of the day of the week.
     *
     * @return int The timestamp of the date that fits the qualifications.
     */
    public static function getFirstDayOfWeekInMonth($curdate, $day_of_week)
    {
        return self::get_first_day_of_week_in_month($curdate, $day_of_week);
    }

    /**
     * Deprecated camelCase version of self::number_to_ordinal
     *
     * @param int $number A number.
     *
     * @return string The ordinal for that number.
     */
    public static function numberToOrdinal($number)
    {
        return self::number_to_ordinal($number);
    }

    /**
     * Deprecated camelCase version of self::is_timestamp
     *
     * @param $timestamp
     *
     * @return bool
     */
    public static function isTimestamp($timestamp)
    {
        return self::is_timestamp($timestamp);
    }

    /**
     * Gets the timestamp of a day in week, month and year context.
     *
     * Kudos to [icedwater StackOverflow user](http://stackoverflow.com/users/1091386/icedwater) in
     * [his answer](http://stackoverflow.com/questions/924246/get-the-first-or-last-friday-in-a-month).
     *
     * Usage examples:
     * "The second Wednesday of March 2015" - `get_day_timestamp( 3, 2, 3, 2015, 1)`
     * "The last Friday of December 2015" - `get_day_timestamp( 5, 1, 12, 2015, -1)`
     * "The first Monday of April 2016 - `get_day_timestamp( 1, 1, 4, 2016, 1)`
     * "The penultimate Thursday of January 2012" - `get_day_timestamp( 4, 2, 1, 2012, -1)`
     *
     * @param int $day_of_week    The day representing the number in the week, Monday is `1`, Tuesday is `2`, Sunday is `7`
     * @param int $week_in_month  The week number in the month; first week is `1`, second week is `2`; when direction is reverse
     *                  then `1` is last week of the month, `2` is penultimate week of the month and so on.
     * @param int $month          The month number in the year, January is `1`
     * @param int $year           The year number, e.g. "2015"
     * @param int $week_direction Either `1` or `-1`; the direction for the search referring to the week, defaults to `1`
     *                       to specify weeks in natural order so:
     *                       $week_direction `1` and $week_in_month `1` means "first week of the month"
     *                       $week_direction `1` and $week_in_month `3` means "third week of the month"
     *                       $week_direction `-1` and $week_in_month `1` means "last week of the month"
     *                       $week_direction `-1` and $week_in_month `2` means "penultimmate week of the month"
     *
     * @return int The day timestamp
     */
    public static function get_weekday_timestamp($day_of_week, $week_in_month, $month, $year, $week_direction = 1)
    {
        if (
            !(is_numeric($day_of_week)
                && is_numeric($week_in_month)
                && is_numeric($month)
                && is_numeric($year)
                && is_numeric($week_direction)
                && in_array($week_direction, [-1, 1])
            )
        ) {
            return false;
        }

        if ($week_direction > 0) {
            $startday = 1;
        } else {
            $startday = date('t', mktime(0, 0, 0, $month, 1, $year));
        }

        $start   = mktime(0, 0, 0, $month, $startday, $year);
        $weekday = date('N', $start);

        if ($week_direction * $day_of_week >= $week_direction * $weekday) {
            $offset = -$week_direction * 7;
        } else {
            $offset = 0;
        }

        $offset += $week_direction * ($week_in_month * 7) + ($day_of_week - $weekday);

        return mktime(0, 0, 0, $month, $startday + $offset, $year);
    }

    /**
     * Unescapes date format strings to be used in functions like `date`.
     *
     * Double escaping happens when storing a date format in the database.
     *
     * @param mixed $date_format A date format string.
     *
     * @return mixed Either the original input or an unescaped date format string.
     */
    public static function unescape_date_format($date_format)
    {
        if (!is_string($date_format)) {
            return $date_format;
        }

        // Why so simple? Let's handle other cases as those come up. We have tests in place!
        return str_replace('\\\\', '\\', $date_format);
    }

    /**
     * Builds a date object from a given datetime and timezone.
     *
     * @since 4.9.5
     *
     * @param string|DateTime|int      $datetime      A `strtotime` parse-able string, a DateTime object or
     *                                                a timestamp; defaults to `now`.
     * @param string|DateTimeZone|null $timezone      A timezone string, UTC offset or DateTimeZone object;
     *                                                defaults to the site timezone; this parameter is ignored
     *                                                if the `$datetime` parameter is a DatTime object.
     * @param bool                     $with_fallback Whether to return a DateTime object even when the date data is
     *                                                invalid or not; defaults to `true`.
     *
     * @return DateTime|false A DateTime object built using the specified date, time and timezone; if `$with_fallback`
     *                        is set to `false` then `false` will be returned if a DateTime object could not be built.
     */
    public static function build_date_object($datetime = 'now', $timezone = null, $with_fallback = true)
    {
        if ($datetime instanceof \DateTime) {
            return clone $datetime;
        }

        if (class_exists('DateTimeImmutable') && $datetime instanceof \DateTimeImmutable) {
            // Return the mutable version of the date.
            return Date_I18n::createFromImmutable($datetime);
        }

        $timezone_object = null;
        $datetime = empty($datetime) ? 'now' : $datetime;

        try {
            // PHP 5.2 will not throw an exception but will generate an error.
            $utc = new \DateTimeZone('UTC');
            $timezone_object = Tribe__Timezones::build_timezone_object($timezone);

            if (self::is_timestamp($datetime)) {
                $timestamp_timezone = $timezone ? $timezone_object : $utc;

                return new Date_I18n('@' . $datetime, $timestamp_timezone);
            }

            set_error_handler('mybizna_catch_and_throw');
            $date = new Date_I18n($datetime, $timezone_object);
            restore_error_handler();
        } catch (\Exception $e) {
            // If we encounter an error, we need to restore after catching.
            restore_error_handler();

            if ($timezone_object === null) {
                $timezone_object = Tribe__Timezones::build_timezone_object($timezone);
            }

            return $with_fallback
                ? new Date_I18n('now', $timezone_object)
                : false;
        }

        return $date;
    }

    /**
     * Validates a date string to make sure it can be used to build DateTime objects.
     *
     * @since 4.9.5
     *
     * @param string $date The date string that should validated.
     *
     * @return bool Whether the date string can be used to build DateTime objects, and is thus parse-able by functions
     *              like `strtotime`, or not.
     */
    public static function is_valid_date($date)
    {
        static $cache_var_name = __FUNCTION__;

        $cache_date_check = mybizna_get_var($cache_var_name, []);

        if (isset($cache_date_check[$date])) {
            return $cache_date_check[$date];
        }

        $cache_date_check[$date] = self::build_date_object($date, null, false) instanceof DateTimeInterface;

        mybizna_set_var($cache_var_name, $cache_date_check);

        return $cache_date_check[$date];
    }

    /**
     * Returns the DateTime object representing the start of the week for a date.
     *
     * @since 4.9.21
     *
     * @throws Exception
     *
     * @param string|int|\DateTime $date          The date string, timestamp or object.
     * @param int|null             $start_of_week The number representing the start of week day as handled by
     *                                            WordPress: `0` (for Sunday) through `6` (for Saturday).
     *
     * @return array An array of objects representing the week start and end days, or `false` if the
     *                        supplied date is invalid. The timezone of the returned object is set to the site one.
     *                        The week start has its time set to `00:00:00`, the week end will have its time set
     *                        `23:59:59`.
     */
    public static function get_week_start_end($date, $start_of_week = null)
    {
        static $cache_var_name = __FUNCTION__;

        $cache_week_start_end = mybizna_get_var($cache_var_name, []);

        $date_obj = static::build_date_object($date);
        $date_obj->setTime(0, 0, 0);

        $date_string = $date_obj->format(static::DBDATEFORMAT);

        // `0` (for Sunday) through `6` (for Saturday), the way WP handles the `start_of_week` option.
        $week_start_day = null !== $start_of_week
            ? (int) $start_of_week
            : (int) config('start_of_week', 0);

        $memory_cache_key = "{$date_string}:{$week_start_day}";

        if (isset($cache_week_start_end[$memory_cache_key])) {
            return $cache_week_start_end[$memory_cache_key];
        }

        $cache_key = md5(
            __METHOD__ . serialize([$date_obj->format(static::DBDATEFORMAT), $week_start_day])
        );
        $cache = tribe('cache');

        if (false !== $cached = $cache[$cache_key]) {
            return $cached;
        }

        // `0` (for Sunday) through `6` (for Saturday), the way WP handles the `start_of_week` option.
        $date_day = (int) $date_obj->format('w');

        $week_offset = 0;
        if (0 === $date_day && 0 !== $week_start_day) {
            $week_offset = 0;
        } elseif ($date_day < $week_start_day) {
            // If the current date of the week is before the start of the week, move back a week.
            $week_offset = -1;
        } elseif (0 === $date_day) {
            // When start of the week is on a sunday we add a week.
            $week_offset = 1;
        }

        $week_start = clone $date_obj;

        /*
			 * From the PHP docs, the `W` format stands for:
			 * - ISO-8601 week number of year, weeks starting on Monday
			 */
        $week_start->setISODate(
            (int) $week_start->format('o'),
            (int) $week_start->format('W') + $week_offset,
            $week_start_day
        );

        $week_end = clone $week_start;
        // Add 6 days, then move at the end of the day.
        $week_end->add(new DateInterval('P6D'));
        $week_end->setTime(23, 59, 59);

        $week_start = static::immutable($week_start);
        $week_end   = static::immutable($week_end);

        $cache[$cache_key]                       = [$week_start, $week_end];
        $cache_week_start_end[$memory_cache_key] = [$week_start, $week_end];

        mybizna_set_var($cache_var_name, $cache_week_start_end);

        return [$week_start, $week_end];
    }

    /**
     * Given a specific DateTime we determine the end of that day based on our Internal End of Day Cut-off.
     *
     * @since 4.11.2
     *
     * @param string|DateTimeInterface $date    Date that we are getting the end of day from.
     * @param null|string              $cutoff  Which cutoff to use.
     *
     * @return DateTimeInterface|false Returns a DateTimeInterface when a valid date is given or false.
     */
    public static function get_shifted_end_of_day($date, $cutoff = null)
    {
        $date_obj = static::build_date_object($date);

        if (!$date_obj) {
            return false;
        }

        $start_of_day = clone $date_obj;
        $end_of_day   = clone $date_obj;

        if (empty($cutoff) || !is_string($cutoff) || false === strpos($cutoff, ':')) {
            $cutoff = config('multiDayCutoff', '00:00');
        }

        list($hours_to_add, $minutes_to_add) = array_map('absint', explode(':', $cutoff));

        $seconds_to_add = ($hours_to_add * 3600) + ($minutes_to_add * 60);
        if (0 !== $seconds_to_add) {
            $interval = static::interval("PT{$seconds_to_add}S");
        }

        $start_of_day->setTime('0', '0', '0');
        $end_of_day->setTime('23', '59', '59');

        if (0 !== $seconds_to_add) {
            $start_of_day->add($interval);
            $end_of_day->add($interval);
        }

        if ($end_of_day >= $date_obj && $date_obj >= $start_of_day) {
            return $end_of_day;
        }

        $start_of_day->sub(static::interval('P1D'));

        if ($start_of_day < $date_obj) {
            $end_of_day->sub(static::interval('P1D'));
        }

        return $end_of_day;
    }

    /**
     * Given a specific DateTime we determine the start of that day based on our Internal End of Day Cut-off.
     *
     * @since 4.11.2
     *
     * @param string|DateTimeInterface $date    Date that we are getting the start of day from.
     * @param null|string              $cutoff  Which cutoff to use.
     *
     * @return DateTimeInterface|false Returns a DateTimeInterface when a valid date is given or false.
     */
    public static function get_shifted_start_of_day($date, $cutoff = null)
    {
        $date_obj = static::build_date_object($date);

        if (!$date_obj) {
            return false;
        }

        $start_of_day = clone $date_obj;
        $end_of_day   = clone $date_obj;

        if (empty($cutoff) || !is_string($cutoff) || false === strpos($cutoff, ':')) {
            $cutoff = config('multiDayCutoff', '00:00');
        }

        list($hours_to_add, $minutes_to_add) = array_map('absint', explode(':', $cutoff));

        $seconds_to_add = ($hours_to_add * 3600) + ($minutes_to_add * 60);
        if (0 !== $seconds_to_add) {
            $interval = static::interval("PT{$seconds_to_add}S");
        }

        $start_of_day->setTime('0', '0', '0');
        $end_of_day->setTime('23', '59', '59');

        if (0 !== $seconds_to_add) {
            $start_of_day->add($interval);
            $end_of_day->add($interval);
        }

        if ($end_of_day <= $date_obj && $date_obj >= $start_of_day) {
            return $start_of_day;
        }

        $end_of_day->sub(static::interval('P1D'));

        if ($end_of_day > $date_obj) {
            $start_of_day->sub(static::interval('P1D'));
        }

        return $start_of_day;
    }

    /**
     * Builds and returns a `DateInterval` object from the interval specification.
     *
     * For performance purposes the use of `DateInterval` specifications is preferred, so `P1D` is better than
     * `1 day`.
     *
     * @since 4.10.2
     *
     * @return DateInterval The built date interval object.
     */
    public static function interval($interval_spec)
    {
        try {
            $interval = new \DateInterval($interval_spec);
        } catch (\Exception $e) {
            $interval = \DateInterval::createFromDateString($interval_spec);
        }

        return $interval;
    }

    /**
     * Builds the immutable version of a date from a string, integer (timestamp) or \DateTime object.
     *
     * It's the immutable version of the `Tribe__Date_Utils::build_date_object` method.
     *
     * @since 4.10.2
     *
     * @param string|DateTime|int      $datetime      A `strtotime` parse-able string, a DateTime object or
     *                                                a timestamp; defaults to `now`.
     * @param string|DateTimeZone|null $timezone      A timezone string, UTC offset or DateTimeZone object;
     *                                                defaults to the site timezone; this parameter is ignored
     *                                                if the `$datetime` parameter is a DatTime object.
     * @param bool                     $with_fallback Whether to return a DateTime object even when the date data is
     *                                                invalid or not; defaults to `true`.
     *
     * @return DateTimeImmutable|false A DateTime object built using the specified date, time and timezone; if
     *                                 `$with_fallback` is set to `false` then `false` will be returned if a
     *                                 DateTime object could not be built.
     */
    static function immutable($datetime = 'now', $timezone = null, $with_fallback = true)
    {
        if ($datetime instanceof \DateTimeImmutable) {
            return $datetime;
        }

        if ($datetime instanceof \DateTime) {
            return Date_I18n_Immutable::createFromMutable($datetime);
        }

        $mutable = static::build_date_object($datetime, $timezone, $with_fallback);

        if (false === $mutable) {
            return false;
        }

        $cache_key = md5((__METHOD__ . $mutable->getTimezone()->getName() . $mutable->getTimestamp()));
        $cache     = tribe('cache');

        if (false !== $cached = $cache[$cache_key]) {
            return $cached;
        }

        $immutable = Date_I18n_Immutable::createFromMutable($mutable);

        $cache[$cache_key] = $immutable;

        return $immutable;
    }

    /**
     * Builds a date object from a given datetime and timezone.
     *
     * An alias of the `Tribe__Date_Utils::build_date_object` function.
     *
     * @since 4.10.2
     *
     * @param string|DateTime|int      $datetime      A `strtotime` parse-able string, a DateTime object or
     *                                                a timestamp; defaults to `now`.
     * @param string|DateTimeZone|null $timezone      A timezone string, UTC offset or DateTimeZone object;
     *                                                defaults to the site timezone; this parameter is ignored
     *                                                if the `$datetime` parameter is a DatTime object.
     * @param bool                     $with_fallback Whether to return a DateTime object even when the date data is
     *                                                invalid or not; defaults to `true`.
     *
     * @return DateTime|false A DateTime object built using the specified date, time and timezone; if `$with_fallback`
     *                        is set to `false` then `false` will be returned if a DateTime object could not be built.
     */
    public static function mutable($datetime = 'now', $timezone = null, $with_fallback = true)
    {
        return static::build_date_object($datetime, $timezone, $with_fallback);
    }

    /**
     * Returns formatted date for the official beginning of the day according to the Multi-day cutoff time option
     *
     * @category Events
     *
     * @param string $date   The date to find the beginning of the day, defaults to today
     * @param string $format Allows date and time formatting using standard php syntax (http://php.net/manual/en/function.date.php)
     *
     * @return string
     */
    function beginningOfDay($date = null, $format = 'Y-m-d H:i:s')
    {

        $multiday_cutoff = explode(':', config('multiDayCutoff', '00:00'));
        $hours_to_add    = $multiday_cutoff[0];
        $minutes_to_add  = $multiday_cutoff[1];
        if (is_null($date) || empty($date)) {
            $date = date($format, strtotime(date('Y-m-d') . ' +' . $hours_to_add . ' hours ' . $minutes_to_add . ' minutes'));
        } else {
            $date      = $this->is_timestamp($date) ? $date : strtotime($date);
            $timestamp = strtotime(date('Y-m-d', $date) . ' +' . $hours_to_add . ' hours ' . $minutes_to_add . ' minutes');
            $date      = date($format, $timestamp);
        }

        /**
         * Deprecated filter mybizna_event_beginning_of_day in 4.0 in favor of beginningOfDay. Remove in 5.0
         */
        $date = apply_filters('mybizna_event_beginning_of_day', $date);

        /**
         * Filters the beginning of day date
         *
         * @param string $date
         */
        return apply_filters('mybizna_beginning_of_day', $date);
    }

    /**
     * Formatted Date
     *
     * Returns formatted date
     *
     * @category Events
     *
     * @param string $date         String representing the datetime, assumed to be UTC (relevant if timezone conversion is used)
     * @param bool   $display_time If true shows date and time, if false only shows date
     * @param string $date_format  Allows date and time formating using standard php syntax (http://php.net/manual/en/function.date.php)
     *
     * @return string
     */
    function mybizna_format_date($date, $display_time = true, $date_format = '')
    {

        if (!Tribe__Date_Utils::is_timestamp($date)) {
            $date = strtotime($date);
        }

        if ($date_format) {
            $format = $date_format;
        } else {
            $date_year = date('Y', $date);
            $cur_year  = date('Y', current_time('timestamp'));

            // only show the year in the date if it's not in the current year
            $with_year = $date_year == $cur_year ? false : true;

            if ($display_time) {
                $format = mybizna_get_datetime_format($with_year);
            } else {
                $format = mybizna_get_date_format($with_year);
            }
        }

        $date = date_i18n($format, $date);

        /**
         * Deprecated mybizna_event_formatted_date in 4.0 in favor of mybizna_formatted_date. Remove in 5.0
         */
        $date = apply_filters('mybizna_event_formatted_date', $date, $display_time, $date_format);

        return apply_filters('mybizna_formatted_date', $date, $display_time, $date_format);
    }
    /**
     * Returns formatted date for the official beginning of the day according to the Multi-day cutoff time option
     *
     * @category Events
     *
     * @param string $date   The date to find the beginning of the day, defaults to today
     * @param string $format Allows date and time formatting using standard php syntax (http://php.net/manual/en/function.date.php)
     *
     * @return string
     */
    function mybizna_beginning_of_day($date = null, $format = 'Y-m-d H:i:s')
    {
        $multiday_cutoff = explode(':', config('multiDayCutoff', '00:00'));
        $hours_to_add    = $multiday_cutoff[0];
        $minutes_to_add  = $multiday_cutoff[1];
        if (is_null($date) || empty($date)) {
            $date = date($format, strtotime(date('Y-m-d') . ' +' . $hours_to_add . ' hours ' . $minutes_to_add . ' minutes'));
        } else {
            $date      = Tribe__Date_Utils::is_timestamp($date) ? $date : strtotime($date);
            $timestamp = strtotime(date('Y-m-d', $date) . ' +' . $hours_to_add . ' hours ' . $minutes_to_add . ' minutes');
            $date      = date($format, $timestamp);
        }

        /**
         * Deprecated filter mybizna_event_beginning_of_day in 4.0 in favor of mybizna_beginning_of_day. Remove in 5.0
         */
        $date = apply_filters('mybizna_event_beginning_of_day', $date);

        /**
         * Filters the beginning of day date
         *
         * @param string $date
         */
        return apply_filters('mybizna_beginning_of_day', $date);
    }
    /**
     * Returns formatted date for the official end of the day according to the Multi-day cutoff time option
     *
     * @category Events
     *
     * @param string $date   The date to find the end of the day, defaults to today
     * @param string $format Allows date and time formating using standard php syntax (http://php.net/manual/en/function.date.php)
     *
     * @return string
     */
    function mybizna_end_of_day($date = null, $format = 'Y-m-d H:i:s')
    {
        $multiday_cutoff = explode(':', config('multiDayCutoff', '00:00'));
        $hours_to_add    = $multiday_cutoff[0];
        $minutes_to_add  = $multiday_cutoff[1];
        if (is_null($date) || empty($date)) {
            $date = date($format, strtotime('tomorrow  +' . $hours_to_add . ' hours ' . $minutes_to_add . ' minutes') - 1);
        } else {
            $date      = Tribe__Date_Utils::is_timestamp($date) ? $date : strtotime($date);
            $timestamp = strtotime(date('Y-m-d', $date) . ' +1 day ' . $hours_to_add . ' hours ' . $minutes_to_add . ' minutes') - 1;
            $date      = date($format, $timestamp);
        }

        /**
         * Deprecated filter mybizna_event_end_of_day in 4.0 in favor of mybizna_end_of_day. Remove in 5.0
         */
        $date = apply_filters('mybizna_event_end_of_day', $date);

        /**
         * Filters the end of day date
         *
         * @param string $date
         */
        return apply_filters('mybizna_end_of_day', $date);
    }
    /**
     * Get the datetime saparator from the database option with escaped characters or not ;)
     *
     * @param string $default Default Separator if it's blank on the Database
     * @param bool   $esc     If it's going to be used on a `date` function or method it needs to be escaped
     *
     * @filter mybizna_datetime_separator
     *
     * @return string
     */
    function mybizna_get_datetime_separator($default = ' @ ', $esc = false)
    {
        $separator = (string) config('dateTimeSeparator', $default);
        if ($esc) {
            $separator = (array) str_split($separator);
            $separator = (!empty($separator) ? '\\' : '') . implode('\\', $separator);
        }

        return apply_filters('mybizna_datetime_separator', $separator);
    }
    /**
     * Start Time
     *
     * Returns the event start time
     *
     * @category Events
     *
     * @param int    $event       (optional)
     * @param string $date_format Allows date and time formating using standard php syntax (http://php.net/manual/en/function.date.php)
     * @param string $timezone    Timezone in which to present the date/time (or default behaviour if not set)
     *
     * @return string|null Time
     */
    function mybizna_get_start_time($event = null, $date_format = '', $timezone = null)
    {
        if (is_null($event)) {
            global $post;
            $event = $post;
        }

        if (is_numeric($event)) {
            $event = get_post($event);
        }

        if (!is_object($event)) {
            return;
        }

        if (Tribe__Date_Utils::is_all_day(get_post_meta($event->ID, '_EventAllDay', true))) {
            return;
        }

        // @todo [BTRIA-584]: Move timezones to Common.
        if (class_exists('Tribe__Events__Timezones')) {
            $start_date = Tribe__Events__Timezones::event_start_timestamp($event->ID, $timezone);
        }

        if ('' == $date_format) {
            $date_format = mybizna_get_time_format();
        }

        /**
         * Filters the returned event start time
         *
         * @param string  $start_date
         * @param WP_Post $event
         */
        return apply_filters('mybizna_get_start_time', mybizna_format_date($start_date, false, $date_format), $event);
    }
    /**
     * End Time
     *
     * Returns the event end time
     *
     * @category Events
     *
     * @param int    $event       (optional)
     * @param string $date_format Allows date and time formating using standard php syntax (http://php.net/manual/en/function.date.php)
     * @param string $timezone    Timezone in which to present the date/time (or default behaviour if not set)
     *
     * @return string|null Time
     */
    function mybizna_get_end_time($event = null, $date_format = '', $timezone = null)
    {
        if (is_null($event)) {
            global $post;
            $event = $post;
        }

        if (is_numeric($event)) {
            $event = get_post($event);
        }

        if (!is_object($event)) {
            return;
        }

        if (Tribe__Date_Utils::is_all_day(get_post_meta($event->ID, '_EventAllDay', true))) {
            return;
        }

        // @todo [BTRIA-584]: Move timezones to Common.
        if (class_exists('Tribe__Events__Timezones')) {
            $end_date = Tribe__Events__Timezones::event_end_timestamp($event->ID, $timezone);
        }

        if ('' == $date_format) {
            $date_format = mybizna_get_time_format();
        }

        /**
         * Filters the returned event end time
         *
         * @param string  $end_date
         * @param WP_Post $event
         */
        return apply_filters('mybizna_get_end_time', mybizna_format_date($end_date, false, $date_format), $event);
    }
    /**
     * Start Date
     *
     * Returns the event start date and time
     *
     * @category Events
     *
     * @since 4.7.6 Deprecated the $timezone parameter.
     *
     * @param int    $event        (optional)
     * @param bool   $display_time If true shows date and time, if false only shows date
     * @param string $date_format  Allows date and time formating using standard php syntax (http://php.net/manual/en/function.date.php)
     * @param string $timezone     Deprecated. Timezone in which to present the date/time (or default behaviour if not set)
     *
     * @return string|null Date
     */
    function mybizna_get_start_date($event = null, $display_time = true, $date_format = '', $timezone = null)
    {
        static $cache_var_name = __FUNCTION__;

        if (is_null($event)) {
            global $post;
            $event = $post;
        }

        if (is_numeric($event)) {
            $event = get_post($event);
        }

        if (!is_object($event)) {
            return '';
        }

        $start_dates = mybizna_get_var($cache_var_name, []);
        $cache_key = "{$event->ID}:{$display_time}:{$date_format}:{$timezone}";

        if (!isset($start_dates[$cache_key])) {
            if (Tribe__Date_Utils::is_all_day(get_post_meta($event->ID, '_EventAllDay', true))) {
                $display_time = false;
            }

            // @todo [BTRIA-584]: Move timezones to Common.
            if (class_exists('Tribe__Events__Timezones')) {
                $start_date = Tribe__Events__Timezones::event_start_timestamp($event->ID, $timezone);
            } else {
                return null;
            }

            $start_dates[$cache_key] = mybizna_format_date($start_date, $display_time, $date_format);
            mybizna_set_var($cache_var_name, $start_dates);
        }

        /**
         * Filters the returned event start date and time
         *
         * @param string  $start_date
         * @param WP_Post $event
         */
        return apply_filters('mybizna_get_start_date', $start_dates[$cache_key], $event);
    }
    /**
     * End Date
     *
     * Returns the event end date
     *
     * @category Events
     *
     * @since 4.7.6 Deprecated the $timezone parameter.
     *
     * @param int    $event        (optional)
     * @param bool   $display_time If true shows date and time, if false only shows date
     * @param string $date_format  Allows date and time formating using standard php syntax (http://php.net/manual/en/function.date.php)
     * @param string $timezone     Deprecated. Timezone in which to present the date/time (or default behaviour if not set)
     *
     * @return string|null Date
     */
    function mybizna_get_end_date($event = null, $display_time = true, $date_format = '', $timezone = null)
    {
        static $cache_var_name = __FUNCTION__;

        if (is_null($event)) {
            global $post;
            $event = $post;
        }

        if (is_numeric($event)) {
            $event = get_post($event);
        }

        if (!is_object($event)) {
            return '';
        }

        $end_dates = mybizna_get_var($cache_var_name, []);
        $cache_key = "{$event->ID}:{$display_time}:{$date_format}:{$timezone}";

        if (!isset($end_dates[$cache_key])) {
            if (Tribe__Date_Utils::is_all_day(get_post_meta($event->ID, '_EventAllDay', true))) {
                $display_time = false;
            }

            // @todo [BTRIA-584]: Move timezones to Common.
            if (class_exists('Tribe__Events__Timezones')) {
                $end_date = Tribe__Events__Timezones::event_end_timestamp($event->ID);
            } else {
                return null;
            }

            $end_dates[$cache_key] = mybizna_format_date($end_date, $display_time, $date_format);
            mybizna_set_var($cache_var_name, $end_dates);
        }

        /**
         * Filters the returned event end date and time
         *
         * @param string  $end_date
         * @param WP_Post $event
         */
        return apply_filters('mybizna_get_end_date', $end_dates[$cache_key], $event);
    }
    /**
     * Normalizes a manual UTC offset string.
     *
     * @param string $utc_offset
     *
     * @return string The normalized manual UTC offset.
     *                e.g. 'UTC+3', 'UTC-4.5', 'UTC+2.75'
     */
    function mybizna_normalize_manual_utc_offset($utc_offset)
    {
        $matches = [];
        if (preg_match('/^UTC\\s*((\\+|-)(\\d{1,2}))((:|.|,)(\\d{1,2})+)*/ui', $utc_offset, $matches)) {
            if (!empty($matches[6])) {
                $minutes = $matches[6] > 10 && $matches[6] <= 60 ? $minutes = $matches[6] / 60 : $matches[6];
                $minutes = str_replace('0.', '', $minutes);
            }

            $utc_offset = sprintf('UTC%s%s', $matches[1], !empty($minutes) ? '.' . $minutes : '');
        }

        return $utc_offset;
    }
    /**
     * Return a WP Locale weekday in the specified format
     *
     * @param int|string $weekday Day of week
     * @param string $format Weekday format: full, weekday, initial, abbreviation, abbrev, abbr, short
     *
     * @return string
     */
    function mybizna_wp_locale_weekday($weekday, $format)
    {
        return Tribe__Date_Utils::wp_locale_weekday($weekday, $format);
    }
    /**
     * Return a WP Locale month in the specified format
     *
     * @param int|string $month Month of year
     * @param string $format month format: full, month, abbreviation, abbrev, abbr, short
     *
     * @return string
     */
    function mybizna_wp_locale_month($month, $format)
    {
        return Tribe__Date_Utils::wp_locale_month($month, $format);
    }
    /**
     * Handy function for easily detecting if this site's using the 24-hour time format.
     *
     * @since 4.7.1
     *
     * @return boolean
     */
    function mybizna_is_site_using_24_hour_time()
    {
        $time_format = config('time_format');
        return strpos($time_format, 'H') !== false;
    }

        /**
     * Retrievesclosest financial year by start date
     *
     * @param $start_date
     *
     * @return array
     */
    public static function closest_financial_year($start_date)
    {
        global $wpdb;

        $start_date = !empty($start_date)
            ? erp_current_datetime()->modify($start_date)->format('Y-m-d')
            : erp_current_datetime()->format('Y-m-d');

        $sql = "SELECT id, name, start_date, end_date
                FROM {$wpdb->prefix}erp_acct_financial_years
                WHERE start_date <= '%s'
                ORDER BY start_date DESC
                LIMIT 1";

        $year = $wpdb->get_row($wpdb->prepare($sql, $start_date), ARRAY_A);

        return !is_wp_error($year) ? $year : [];
    }
}
