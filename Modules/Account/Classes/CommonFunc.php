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

        $currency_id = config('currency', $usd);

        if ($get_only_id) {
            return $currency_id;
        }

        $currency_name = DB::scalar(
            "SELECT name FROM account_currency_info WHERE id = %d",
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
            require_once base_path() . 'wp-admin/includes/file.php';
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

        $purchases             = 'purchase';
        $purchase_acct_details = 'purchase_account_details';

        $purchase_query = "Select voucher_no, SUM(ad.debit - ad.credit) as due, due_date
        FROM $purchases LEFT JOIN $purchase_acct_details as ad
        ON ad.purchase_no = voucher_no  where due_date
        BETWEEN {$from_date} and {$to_date} Group BY voucher_no Having due < 0 ";

        $purchase_results = DB::select($purchase_query);

        $bills             = 'bill';
        $bill_acct_details = 'bill_account_detail';
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


        DB::table('expense_check')
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


        DB::table('expense_check')
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


        $row = DB::select("SELECT first_name, last_name, email FROM `partner` WHERE id = %d LIMIT 1", [$people_id]);
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


        $row = DB::select("SELECT name, slug, code FROM account_ledger WHERE id = %d LIMIT 1", [$ledger_id]);
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
            "SELECT * FROM account_ledger WHERE $field = %s LIMIT 1",
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

        $row = DB::select("SELECT name FROM product_type WHERE id = %d LIMIT 1", [$product_type_id]);
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


        $row = DB::select("SELECT name FROM product_category WHERE id = %d LIMIT 1", [$cat_id]);
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


        $row = DB::select("SELECT name FROM account_tax_agency WHERE id = %d LIMIT 1", [$agency_id]);
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
            return DB::scalar("SELECT name FROM account_tax_category WHERE id = %d", [$cat_id]);
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

        $row = DB::select("SELECT type_name FROM account_transaction_status_type WHERE id = %d", [$trn_id]);

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


        $row = DB::select("SELECT name FROM payment_method WHERE id = %d LIMIT 1", [$method_id]);

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


        $row = DB::select("SELECT name FROM payment_method WHERE id = %d LIMIT 1", [$method_id]);

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


        $row = DB::select("SELECT name FROM expense_check WHERE id = %d LIMIT 1", [$trn_type_id]);

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
            FROM account_tax_category_agency
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
            FROM invoice_detail_tax
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
                'title' => __('Opening Balance'),
                'slug'  => 'opening_balance',
                'url'   => 'opening-balance',
            ],
        ];

        return apply_filters('quick_menu', $menus);
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
        $res = DB::scalar("SELECT editable FROM purchase_voucher_no WHERE id = %d", [$id]);

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


        return DB::scalar("SELECT id FROM account_transaction_status_type WHERE slug = %s", [$slug]);
    }

    /**
     * Get all transaction statuses
     *
     * @return array
     */
    public function getAllTrnStatuses()
    {


        return DB::select("SELECT id,type_name as name, slug FROM account_transaction_status_type");
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

        DB::table('account_ledger_detail')
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

        DB::table('account_ledger_detail')
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
     * Retrievesclosest financial year by start date
     *
     * @param $start_date
     *
     * @return array
     */
    public static function closest_financial_year($start_date)
    {

        $start_date = !empty($start_date)
            ?  (new \DateTime())->modify($start_date)->format('Y-m-d')
            : (new \DateTime())->format('Y-m-d');

        $sql = "SELECT id, name, start_date, end_date
                FROM account_financial_year
                WHERE start_date <= '%s'
                ORDER BY start_date DESC
                LIMIT 1";

        $year = DB::select($sql, [$start_date]);

        return !empty($year) ? $year : [];
    }

    /**
     * Return url from a absolute path
     *
     * @param int $voucher_no Voucher Number
     *
     * @return string
     */
    public function pdfAbsPathToUrl($voucher_no)
    {
        $upload_url = wp_upload_dir();
        $url        = $upload_url['baseurl'] . '/erp-pdfs/' . "voucher_{$voucher_no}.pdf";

        return esc_url_raw($url);
    }
}
