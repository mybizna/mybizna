<?php

namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;

class People
{

    /**
     * Insert employee data as people
     *
     * @param $data
     * @param $update
     *
     * @return int
     */
    function addEmployeeAsPeople($data, $update = false)
    {

        $people_id = null;

        if ($this->isEmployeePeople($data['user_id'])) {
            return;
        }

        $company = new \WeDevs\ERP\Company();

        if ($update) {
            DB::table('erp_peoples')
                ->where('user_id', $data['user_id'])
                ->update(
                    [
                        'first_name'    => $data['personal']['first_name'],
                        'last_name'     => $data['personal']['last_name'],
                        'company'       => $company->name,
                        'email'         => $data['user_email'],
                        'phone'         => $data['personal']['phone'],
                        'mobile'        => $data['personal']['mobile'],
                        'other'         => '',
                        'website'       => '',
                        'fax'           => '',
                        'notes'         => $data['personal']['description'],
                        'street_1'      => $data['personal']['street_1'],
                        'street_2'      => $data['personal']['street_2'],
                        'city'          => $data['personal']['city'],
                        'state'         => $data['personal']['state'],
                        'postal_code'   => $data['personal']['postal_code'],
                        'country'       => $data['personal']['country'],
                        'currency'      => '',
                        'life_stage'    => '',
                        'contact_owner' => '',
                        'hash'          => '',
                        'created_by'    => auth()->user()->id,
                        'created'       => '',
                    ]
                );
        } else {
            $people_id = DB::table('erp_peoples')
                ->insertGetId(
                    [
                        'user_id'       => $data['user_id'],
                        'first_name'    => $data['personal']['first_name'],
                        'last_name'     => $data['personal']['last_name'],
                        'company'       => $company->name,
                        'email'         => $data['user_email'],
                        'phone'         => $data['personal']['phone'],
                        'mobile'        => $data['personal']['mobile'],
                        'other'         => '',
                        'website'       => '',
                        'fax'           => '',
                        'notes'         => $data['personal']['description'],
                        'street_1'      => $data['personal']['street_1'],
                        'street_2'      => $data['personal']['street_2'],
                        'city'          => $data['personal']['city'],
                        'state'         => $data['personal']['state'],
                        'postal_code'   => $data['personal']['postal_code'],
                        'country'       => $data['personal']['country'],
                        'currency'      => '',
                        'life_stage'    => '',
                        'contact_owner' => '',
                        'hash'          => '',
                        'created_by'    => auth()->user()->id,
                        'created'       => '',
                    ]
                );
        }


        return $people_id;
    }

    /**
     * Inserts accounting people
     *
     * @since 1.8.5
     *
     * @param array $args
     *
     * @return mixed
     */
    function insertPeople($args)
    {
        $people = $this->getPeopleBy('email', $args['email']);

        // this $email belongs to nobody
        if (!$people) {
            return $this->insertPeopleDB($args);
        }

        foreach ($args as $key => $value) {
            if (empty($args[$key])) {
                unset($args[$key]);
            }
        }

        $args = wp_parse_args((array) $people, $args);
        $id   = $this->insertPeopleDB($args);

        if (!is_wp_error($id)) {


            $type_id = $this->getPeopleTypeIdByName($args['type']);

            DB::table("erp_people_type_relations")
                ->insert(
                    ['people_id' => $id, 'people_types_id' => $type_id],
                );
        }

        return $id;
    }

    /**
     * Get transaction by date
     *
     * @param int   $people_id
     * @param array $args
     *
     * @return array
     */
    function peopleFilterTransaction($people_id, $args = [])
    {

        $start_date = isset($args['start_date']) ? $args['start_date'] : '';
        $end_date   = isset($args['end_date']) ? $args['start_date'] : '';

        $rows = DB::select("SELECT * FROM erp_acct_people_account_details WHERE trn_date >= '{$start_date}' AND trn_date <= '{$end_date}' AND people_id = {$people_id}", ARRAY_A);

        return $rows;
    }

    /**
     * Get address of a people
     *
     * @param $people_id
     *
     * @return mixed
     */
    function getPeopleAddress($people_id)
    {


        $row = [];

        $row = DB::select(
                "SELECT street_1, street_2, city, state, postal_code, country FROM erp_peoples WHERE id = %d",
                [$people_id]
        );

        $row = (!empty($row)) ? $row[0] : null;

        return $row;
    }

    /**
     * Format people address
     */
    function formatPeopleAddress($address = [])
    {
        $add = '';

        $keys   = array_keys($address);
        $values = array_values($address);

        for ($idx = 0; $idx < count($address); $idx++) {
            $add .= $keys[$idx] . ': ' . $values[$idx] . '; ';
        }

        return $add;
    }

    /**
     * Get all transactions
     *
     * @return mixed
     */
    function getPeopleTransactions($args = [])
    {


        $defaults = [
            'number' => 20,
            'offset' => 0,
            'order'  => 'ASC',
            'count'  => false,
            's'      => '',
        ];

        $args           = array_merge($defaults, $args);
        $limit          = '';
        $where          = '';
        $fy_start_date  = !empty($args['start_date']) ? $args['start_date'] : date('Y-m-d');
        $financial_year = \WeDevs\ERP\Accounting\Includes\Classes\Common::closest_financial_year($fy_start_date);

        if (!empty($args['people_id'])) {
            $where .= " AND people.people_id = {$args['people_id']} ";
        }

        if (empty($args['start_date'])) {
            $args['start_date']  =   $financial_year['start_date'];
        }

        if (empty($args['end_date'])) {
            $args['end_date'] = date('Y-m-d', strtotime('last day of this month'));
        }


        if (!empty($args['start_date'])) {
            $where .= " AND people.trn_date BETWEEN '{$args['start_date']}' AND '{$args['end_date']}'";
        }

        if ('-1' === $args['number']) {
            $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
        }

        $sql = 'SELECT';

        if ($args['count']) {
            $sql .= ' COUNT( DISTINCT people.voucher_no ) AS total_number';
        } else {
            $sql .= '
            voucher.id as voucher_no,
            people.people_id,
            people.voucher_no,
            people.trn_date,
            people.debit,
            people.credit,
            people.particulars,
            people.created_at';
        }

        $sql .= " FROM erp_acct_voucher_no AS voucher
        INNER JOIN erp_acct_people_trn_details AS people ON voucher.id = people.voucher_no
        {$where} ORDER BY people.trn_date {$args['order']} {$limit}";

        if ($args['count']) {
            DB::select($sql);

            return $wpdb->num_rows;
        }


        $results = DB::select($sql, ARRAY_A);

        $previous_balance_data  = [
            'start_date'        => $financial_year['start_date'],
            'end_date'          =>  date('Y-m-d', strtotime('-1 day', strtotime($args['start_date']))),
            'people_id'         => $args['people_id'],
            'financial_year_id' => $financial_year['id']
        ];

        $previousBalance     = $this->getPeoplePreviousBalance($previous_balance_data);  // get previous balance from financial year start date to previous date of start date



        /*    if ( $previousBalance > 0 ) {
        $dr_total = (float) $o_balance;
        $temp     = $o_balance . ' Dr';
    } else {
        $cr_total = (float) $o_balance;
        $temp     = $o_balance . ' Cr';
    }*/

        /*   */
        $total_debit  = 0;
        $total_credit  = 0;
        $balance =  (float)$previousBalance;

        foreach ($results as $index => $result) {

            $total_debit   += (float) $result['debit'];
            $total_credit  += (float) $result['credit'];

            $debit   = (float)$result['debit'] + $balance;
            $balance = $debit - (float)$result['credit'];

            $results[$index]['debit'] =  abs((float)$result['debit']);
            $results[$index]['credit'] =  abs((float)$result['credit']);
            $results[$index]['balance'] =  abs($balance) . ($balance > 0 ? __(' Dr', 'erp') : __(' Cr', 'erp'));
        }

        array_unshift(
            $results,
            [
                'voucher_no'  => null,
                'particulars' => 'Opening Balance',
                'people_id'   => null,
                'trn_no'      => null,
                'trn_date'    => null,
                'created_at'  => null,
                'debit'       => null,
                'credit'      => null,
                'balance'     => abs($previousBalance) . ($previousBalance > 0 ? ' Dr' : ' Cr'),
            ]
        );

        array_push(
            $results,
            [
                'voucher_no'  => null,
                'particulars' => 'Total',
                'people_id'   => null,
                'trn_no'      => null,
                'trn_date'    => null,
                'created_at'  => null,
                'debit'       => $total_debit,
                'credit'      => $total_credit,
                'balance'     => abs($balance) . ($balance > 0 ? ' Dr' : ' Cr'),
            ]
        );

        return $results;
    }


    /**
     * Get opening balance
     *
     * @param array $args
     *
     * @return mixed
     */
    function getPeoplePreviousBalance($args = [])
    {


        $opening_balance_query     = "SELECT SUM(debit - credit) AS opening_balance FROM erp_acct_opening_balances where type = 'people' AND ledger_id = %d AND financial_year_id = %d";
        $opening_balance_result    = DB::select($opening_balance_query, [ $args['people_id'], $args['financial_year_id']]);
        $opening_balance_result = (!empty($opening_balance_result)) ? $opening_balance_result[0] : null;
        $opening_balance           =  isset($opening_balance_result['opening_balance']) ? $opening_balance_result['opening_balance'] : 0;

        $people_transaction_query  =  "SELECT SUM(debit - credit) AS balance FROM erp_acct_people_trn_details where   people_id = %d AND trn_date BETWEEN %s AND %s";
        $people_transaction_result = DB::select($people_transaction_query, [$args['people_id'], $args['start_date'], $args['end_date']]);
        $people_transaction_result = (!empty($people_transaction_result)) ? $people_transaction_result[0] : null;
        $balance                   =  isset($people_transaction_result['balance']) ? $people_transaction_result['balance'] : 0;

        return ($balance + $opening_balance);
    }

    /**
     * Get People type by people id
     *
     * @param $people_id
     *
     * @return mixed
     */
    function getPeopleTypeById($people_id)
    {


        $row = DB::select("SELECT people_types_id FROM erp_people_type_relations WHERE people_id = %d LIMIT 1", [$people_id]);
        $row = (!empty($row)) ? $row[0] : null;
        return $this->getPeopleTypeByTypeId($row->people_types_id);
    }

    /**
     * Get people type by type id
     *
     * @param $type_id
     *
     * @return mixed
     */
    function getPeopleTypeByTypeId($type_id)
    {


        $row = DB::select("SELECT name FROM erp_people_types WHERE id = %d LIMIT 1", [$type_id]);
        $row = (!empty($row)) ? $row[0] : null;
        return $row->name;
    }

    /**
     * Get people type name by type id
     *
     * @since 1.8.5
     *
     * @param $type_name
     *
     * @return int|string
     */
    function getPeopleTypeIdByName($type_name)
    {


        $row = DB::select(
                "SELECT id
            FROM erp_people_types
            WHERE name = %s LIMIT 1",
                [$type_name]
        );

        $row = (!empty($row)) ? $row[0] : null;

        return $row->id;
    }

    /**
     * Get people id by user id
     *
     * @return mixed
     */
    function getPeopleIdByUserId($user_id)
    {


        $row = DB::select("SELECT id FROM erp_peoples WHERE user_id = %d LIMIT 1", [$user_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row->id;
    }

    /**
     * Get people id by people_id
     *
     * @return mixed
     */
    function getPeopleNameByPeopleId($people_id)
    {


        $row = DB::select("SELECT first_name, last_name FROM erp_peoples WHERE id = %d LIMIT 1", [$people_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row->first_name . ' ' . $row->last_name;
    }

    /**
     * Checks if an employee is people
     *
     * @param $user_id
     *
     * @return bool
     */
    function isEmployeePeople($user_id)
    {


        if (!$user_id) {
            return false;
        }

        $res = DB::scalar(("SELECT COUNT(1) FROM erp_peoples WHERE user_id = %d", [$user_id]);

        if ('1' === $res) {
            return true;
        }

        return false;
    }

    /**
     * Get $user_id by $people_id
     *
     * @param $people_id
     *
     * @return mixed
     */
    function getUserIdByPeopleId($people_id)
    {


        $row = DB::select("SELECT user_id FROM erp_peoples WHERE id = %d LIMIT 1", [$people_id]);
        $row = (!empty($row)) ? $row[0] : null;

        return $row->user_id;
    }

    /**
     * Get Customer or Vendors
     */
    function getAccountingPeople($args = [])
    {


        $defaults = [
            'type'       => 'all',
            'number'     => 20,
            'offset'     => 0,
            'orderby'    => 'id',
            'order'      => 'DESC',
            'trashed'    => false,
            'meta_query' => [],
            'count'      => false,
            'life_stage' => '',
            'include'    => [],
            'exclude'    => [],
            's'          => '',
            'no_object'  => false,
        ];
        $args     = array_merge($defaults, $args);

        $people_type = is_array($args['type']) ? implode('-', $args['type']) : $args['type'];



        $pep_tb      = 'erp_peoples';
        $pepmeta_tb  = 'erp_peoplemeta';
        $types_tb    = 'erp_people_types';
        $type_rel_tb = 'erp_people_type_relations';

        extract($args);

        $sql         = [];
        $trashed_sql = $trashed ? '`deleted_at` is not null' : '`deleted_at` is null';

        if (is_array($type)) {
            $type_sql = "and `name` IN ( '" . implode("','", $type) . "' )";
        } else {
            $type_sql = ('all' !== $type) ? "and `name` = '" . $type . "'" : '';
        }

        $wrapper_select = 'SELECT people.*, ';

        $sql['select'][] = "GROUP_CONCAT( DISTINCT t.name SEPARATOR ',') AS types";
        $sql['join'][]   = "LEFT JOIN $type_rel_tb AS r ON people.id = r.people_id LEFT JOIN $types_tb AS t ON r.people_types_id = t.id";
        $sql_from_tb     = "FROM $pep_tb AS people";
        $sql_people_type = "where ( select count(*) from $types_tb
            inner join  $type_rel_tb
                on $types_tb.`id` = $type_rel_tb.`people_types_id`
                where $type_rel_tb.`people_id` = people.`id` $type_sql and $trashed_sql
          ) >= 1";
        $sql['where']    = [''];

        $sql_group_by = 'GROUP BY `people`.`id`';
        $sql_order_by = "ORDER BY $orderby $order";

        // Check if want all data without any pagination
        $sql_limit = ('-1' !== $number && !$count) ? "LIMIT $number OFFSET $offset" : '';

        if ($meta_query) {
            $sql['join'][] = "LEFT JOIN $pepmeta_tb as people_meta on people.id = people_meta.`erp_people_id`";

            $meta_key   = isset($meta_query['meta_key']) ? $meta_query['meta_key'] : '';
            $meta_value = isset($meta_query['meta_value']) ? $meta_query['meta_value'] : '';
            $compare    = isset($meta_query['compare']) ? $meta_query['compare'] : '=';

            $sql['where'][] = "AND people_meta.meta_key='$meta_key' and people_meta.meta_value='$meta_value'";
        }

        // Check if the row want to search
        if (!empty($s)) {
            $search_like = '%' . $wpdb->esc_like($s) . '%';
            $words       = explode(' ', $s);

            if ($type == 'customer' || $type == 'vendor') {
                if (defined('DOING_AJAX') && DOING_AJAX) {
                    if ($type === 'customer') {
                        $sql['where'][] =
                            'AND ( people.first_name ) LIKE '.$search_like.' OR ' .
                                '( people.last_name ) LIKE '.$search_like;

                    } else {
                        $sql['where'][] = 'AND ( people.company ) LIKE '.$search_like;
                    }
                } else {
                    $sql['where'][] =
                        'AND ( people.first_name ) LIKE '.$search_like.' OR ' .
                            '( people.last_name ) LIKE '.$search_like.' OR ' .
                            '( people.email ) LIKE '.$search_like.' OR ' .
                            '( people.company ) LIKE '.$search_like
                }
            } elseif (is_array($type)) {
                $sql['where'][] =
                    'AND ( people.first_name ) LIKE '.$search_like.' OR ' .
                        '( people.last_name ) LIKE '.$search_like,
            }
        }

        // Check if args count true, then return total count customer according to above filter
        if ($count) {
            $sql_order_by   = '';
            $sql_group_by   = '';
            $wrapper_select = 'SELECT COUNT( DISTINCT people.id ) as total_number';
            unset($sql['select'][0]);
        }

        $sql = apply_filters('get_people_pre_query', $sql, $args);

        $post_where_queries = '';

        if (!empty($sql['post_where_queries'])) {
            $post_where_queries = 'AND ( 1 = 1 '
                . implode(' ', $sql['post_where_queries'])
                . ' )';
        }

        $final_query = $wrapper_select . ' '
            . implode(' ', $sql['select']) . ' '
            . $sql_from_tb . ' '
            . implode(' ', $sql['join']) . ' '
            . $sql_people_type . ' '
            . 'AND ( 1=1 '
            . implode(' ', $sql['where']) . ' '
            . ' )'
            . $post_where_queries
            . $sql_group_by . ' '
            . $sql_order_by . ' '
            . $sql_limit;

        if ($count) {
            // Only filtered total count of people
            $items = DB::scalar(apply_filters('get_people_total_count_query', $final_query, $args));
        } else {
            // Fetch results from people table
            $results = DB::select(apply_filters('get_people_total_query', $final_query, $args), ARRAY_A);
            array_walk(
                $results,
                function (&$results) {
                    $results['types'] = explode(',', $results['types']);
                }
            );

            $items = ($no_object) ? $results : (object)$results;
        }

        return $items;
    }

    /**
     * Check if transaction associated with this people
     *
     * @param int $id
     */
    function checkAssociatedTranasaction($people_id)
    {


        return DB::scalar(
                "SELECT id FROM erp_acct_people_trn_details WHERE people_id = %d",
                [$people_id]

        );
    }


    /**
     * Get all peoples
     *
     * @since 1.0
     * @since 1.1.14 Add `post_where_queries`
     * @since 1.2.2  Use `erpadvancefilter` filter for $arg['s'] filter
     *
     * @param $args array
     *
     * @return array
     */
    function getPeoples($args = [])
    {


        $defaults = [
            'type'       => 'all',
            'number'     => 20,
            'offset'     => 0,
            'orderby'    => 'id',
            'order'      => 'DESC',
            'trashed'    => false,
            'meta_query' => [],
            'count'      => false,
            'life_stage' => '',
            'include'    => [],
            'exclude'    => [],
            's'          => '',
            'no_object'  => false,
        ];

        $args                 = array_merge($defaults, $args);
        $args['crm_agent_id'] = get_current_user_id();

        $people_type  = is_array($args['type']) ? implode('-', $args['type'])       : $args['type'];
        $items        = false;
        $pep_tb       = 'erp_peoples';
        $pepmeta_tb   = 'erp_peoplemeta';
        $types_tb     = 'erp_people_types';
        $type_rel_tb  = 'erp_people_type_relations';

        extract($args);

        $sql         = [];
        $trashed_sql = $trashed ? '`deleted_at` is not null' : '`deleted_at` is null';

        if (is_array($type)) {
            $type_sql = "and `name` IN ( '" . implode("','", $type) . "' )";
        } else {
            $type_sql = ($type !== 'all') ? "and `name` = '" . $type . "'" : '';
        }

        $wrapper_select = 'SELECT people.*, ';

        $sql['select'][] = "GROUP_CONCAT( DISTINCT t.name SEPARATOR ',') AS types";
        $sql['join'][]   = "LEFT JOIN $type_rel_tb AS r ON people.id = r.people_id LEFT JOIN $types_tb AS t ON r.people_types_id = t.id";
        $sql_from_tb     = "FROM $pep_tb AS people";
        $sql_people_type = "where ( select count(*) from $types_tb
            inner join  $type_rel_tb
                on $types_tb.`id` = $type_rel_tb.`people_types_id`
                where $type_rel_tb.`people_id` = people.`id` $type_sql and $trashed_sql
          ) >= 1";
        $sql['where']    = [''];

        $sql_group_by = 'GROUP BY `people`.`id`';
        $sql_order_by = "ORDER BY $orderby $order";

        // Check if want all data without any pagination
        $sql_limit = ($number != '-1' && !$count) ? "LIMIT $number OFFSET $offset" : '';

        if ($meta_query) {
            $sql['join'][] = "LEFT JOIN $pepmeta_tb as people_meta on people.id = people_meta.`erp_people_id`";

            $meta_key   = isset($meta_query['meta_key']) ? $meta_query['meta_key'] : '';
            $meta_value = isset($meta_query['meta_value']) ? $meta_query['meta_value'] : '';
            $compare    = isset($meta_query['compare']) ? $meta_query['compare'] : '=';

            $sql['where'][] = "AND people_meta.meta_key='$meta_key' and people_meta.meta_value='$meta_value'";
        }

        if (!empty($life_stage)) {
            $sql['where'][] = "AND people.life_stage='$life_stage'";
        }

        if (!empty($contact_owner)) {
            $sql['where'][] = "AND people.contact_owner='$contact_owner'";
        }


        // Check if the row want to search
        if (!empty($s)) {
            $search_like = '%' . $wpdb->esc_like($s) . '%';
            $words       = explode(' ', $s);

            if ($type === 'contact') {
                $args['erpadvancefilter'] = 'first_name[]=~' . implode('&or&first_name[]=~', $words)
                    . '&or&last_name[]=~' . implode('&or&last_name[]=~', $words)
                    . '&or&email[]=~' . implode('&or&email[]=~', $words);
            } elseif ($type === 'company') {
                $args['erpadvancefilter'] = 'company[]=~' . implode('&or&company[]=~', $words)
                    . '&or&email[]=~' . implode('&or&email[]=~', $words);
            } elseif (is_array($type)) {
                $sql['where'][] =
                    'AND ( people.first_name ) LIKE '.$search_like.' OR ' .
                        '( people.last_name ) LIKE '.$search_like
            } elseif ($type === 'customer' || $type === 'vendor') {
                if (defined('DOING_AJAX') && DOING_AJAX) {
                    if ($type === 'customer') {
                        $sql['where'][] =
                            'AND ( people.first_name ) LIKE '.$search_like.' OR ' .
                                '( people.last_name ) LIKE '.$search_like
                    } else {
                        $sql['where'][] = 'AND ( people.company ) LIKE '.$search_like;
                    }
                } else {
                    $sql['where'][] =
                        'AND ( people.first_name ) LIKE '.$search_like.' OR ' .
                            '( people.last_name ) LIKE '.$search_like.' OR ' .
                            '( people.email ) LIKE '.$search_like.' OR ' .
                            '( people.company ) LIKE '.$search_like
                    );
                }
            }
        }

        // Check if args count true, then return total count customer according to above filter
        if ($count) {
            $sql_order_by   = '';
            $sql_group_by   = '';
            $wrapper_select = 'SELECT COUNT( DISTINCT people.id ) as total_number';
            unset($sql['select'][0]);
        }

        $sql = apply_filters('get_people_pre_query', $sql, $args);

        $post_where_queries = '';

        if (!empty($sql['post_where_queries'])) {
            $post_where_queries = 'AND ( 1 = 1 '
                . implode(' ', $sql['post_where_queries'])
                . ' )';
        }

        $final_query = $wrapper_select . ' '
            . implode(' ', $sql['select']) . ' '
            . $sql_from_tb . ' '
            . implode(' ', $sql['join']) . ' '
            . $sql_people_type . ' '
            . 'AND ( 1=1 '
            . implode(' ', $sql['where']) . ' '
            . ' )'
            . $post_where_queries
            . $sql_group_by . ' '
            . $sql_order_by . ' '
            . $sql_limit;

        if ($count) {
            // Only filtered total count of people
            $items = DB::scalar(apply_filters('get_people_total_count_query', $final_query, $args));
        } else {
            // Fetch results from people table
            $results = DB::select(apply_filters('get_people_total_query', $final_query, $args), ARRAY_A);
            array_walk($results, function (&$results) {
                $results['types'] = explode(',', $results['types']);
            });

            $items = ($no_object) ? $results : (object)$results;
        }

        return $items;
    }

    /**
     * People data delete
     *
     * @since 1.0
     *
     * @param array $data
     *
     * @return void
     */
    function deletePeople($data = [])
    {
        if (empty($data['id'])) {
            return new WP_Error('not-ids', __('No data found', 'erp'));
        }

        if (empty($data['type'])) {
            return new WP_Error('not-types', __('No type found', 'erp'));
        }

        $people_ids = [];

        if (is_array($data['id'])) {
            foreach ($data['id'] as $key => $id) {
                $people_ids[] = $id;
            }
        } elseif (is_int($data['id'])) {
            $people_ids[] = $data['id'];
        }

        // still do we have any ids to delete?
        if (!$people_ids) {
            return;
        }

        // seems like we got some
        foreach ($people_ids as $people_id) {
            do_action('erp_before_delete_people', $people_id, $data);

            if ($data['hard']) {
                $people   = \WeDevs\ERP\Framework\Models\People::find($people_id);
                $type_obj = \WeDevs\ERP\Framework\Models\PeopleTypes::name($data['type'])->first();
                $people->removeType($type_obj);

                $types = wp_list_pluck($people->types->toArray(), 'name');

                if (empty($types)) {
                    $people->delete();
                    \WeDevs\ERP\Framework\Models\Peoplemeta::where('erp_people_id', $people_id)->delete();
                    \WeDevs\ERP\CRM\Models\ContactSubscriber::where('user_id', $people_id)->delete();
                }
            } else {
                $people   = \WeDevs\ERP\Framework\Models\People::with('types')->find($people_id);
                $type_obj = \WeDevs\ERP\Framework\Models\PeopleTypes::name($data['type'])->first();
                $people->softDeleteType($type_obj);
            }

            do_action('erp_after_delete_people', $people_id, $data);
            do_action("erp_acct_delete_{$data['type']}", $data);
        }
    }

    /**
     * People Restore
     *
     * @since 1.0
     *
     * @param array $data
     *
     * @return void
     */
    function restorePeople($data)
    {
        if (empty($data['id'])) {
            return new WP_Error('not-ids', __('No data found', 'erp'));
        }

        if (empty($data['type'])) {
            return new WP_Error('not-types', __('No type found', 'erp'));
        }

        $people_ids = [];

        if (is_array($data['id'])) {
            foreach ($data['id'] as $key => $id) {
                $people_ids[] = $id;
            }
        } elseif (is_int($data['id'])) {
            $people_ids[] = $data['id'];
        }

        // still do we have any ids to delete?
        if (!$people_ids) {
            return;
        }

        // seems like we got some
        foreach ($people_ids as $people_id) {
            do_action('erp_before_restoring_people', $people_id, $data);

            $people   = \WeDevs\ERP\Framework\Models\People::with('types')->find($people_id);
            $type_obj = \WeDevs\ERP\Framework\Models\PeopleTypes::name($data['type'])->first();
            $people->restore($type_obj);

            do_action('erp_after_restoring_people', $people_id, $data);
        }
    }

    /**
     * Get users as array
     *
     * @since 1.0
     *
     * @param array $args
     *
     * @return array
     */
    function getPeoplesArray($args = [])
    {
        $users   = [];
        $peoples = $this->getPeoples($args);

        foreach ($peoples as $user) {
            $users[$user->id] = (in_array('company', $user->types, true)) ? $user->company : $user->first_name . ' ' . $user->last_name;
        }

        return $users;
    }

    /**
     * Fetch people count from database
     *
     * @since 1.0
     *
     * @param string $type
     *
     * @return int
     */
    function getPeoplesCount($type = 'contact')
    {
        $count = WeDevs\ERP\Framework\Models\People::type($type)->count();

        return intval($count);
    }

    /**
     * Fetch a single people from database
     *
     * @since 1.0
     *
     * @param int $id
     *
     * @return array
     */
    function getPeople($id = 0)
    {
        return $this->getPeopleBy('id', $id);
    }

    /**
     * Retrieve people info by a given field
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return object
     */
    function getPeopleBy($field, $value)
    {


        if (empty($field)) {
            return new WP_Error('no-field', __('No field provided', 'erp'));
        }

        if (empty($value)) {
            return new WP_Error('no-value', __('No value provided', 'erp'));
        }


        $sql = 'SELECT people.*, ';
        $sql .= "GROUP_CONCAT(DISTINCT p_types.name) as types
        FROM erp_peoples as people
        LEFT JOIN erp_people_type_relations as p_types_rel on p_types_rel.people_id = people.id
        LEFT JOIN erp_people_types as p_types on p_types.id = p_types_rel.people_types_id
        ";

        if (is_array($value)) {
            $separeted_values = "'" . implode("','", $value) . "'";
            $sql .= " WHERE `people`.$field IN ( $separeted_values )";
        } else {
            $sql .= " WHERE `people`.$field = '$value'";
        }

        $sql .= ' GROUP BY people.id ';

        $results = DB::select($sql);

        $results = array_map(function ($item) {
            $item->types = explode(',', $item->types);

            return $item;
        }, $results);

        if (is_array($value)) {
            $people = (object)$results;
        } else {
            $people = (!empty($results)) ? $results[0] : false;
        }


        return $people;
    }

    /**
     * Insert a new people
     *
     * @since 1.0.0
     * @since 1.2.2  Insert people hash key if not exists one
     * @since 1.2.7  contact_owner, life_stage, hash brought to main table
     * @since 1.2.7  Assign first name as company name for accounting customer search
     * @since 1.3.13 Pass $people_type in create and update people hooks
     * @since 1.6.7 Added validation for almost all input fields
     *
     * @param array $args insert_people
     *
     * @return mixed integer on success, false otherwise
     */
    function insertPeopleDB($args = [], $return_object = false)
    {
        if (empty($args['id'])) {
            $args['id'] = 0;
        }

        $existing_people = \WeDevs\ERP\Framework\Models\People::firstOrNew(['id' => $args['id']]);

        $defaults = [
            'id'            => $existing_people->id,
            'first_name'    => $existing_people->first_name,
            'last_name'     => $existing_people->last_name,
            'email'         => $existing_people->email,
            'company'       => $existing_people->company,
            'phone'         => $existing_people->phone,
            'mobile'        => $existing_people->mobile,
            'other'         => $existing_people->other,
            'website'       => $existing_people->website,
            'fax'           => $existing_people->fax,
            'notes'         => $existing_people->notes,
            'street_1'      => $existing_people->street_1,
            'street_2'      => $existing_people->street_2,
            'city'          => $existing_people->city,
            'state'         => $existing_people->state,
            'postal_code'   => $existing_people->postal_code,
            'country'       => $existing_people->country,
            'currency'      => $existing_people->currency,
            'user_id'       => $existing_people->user_id,
            'contact_owner' => $existing_people->contact_owner,
            'life_stage'    => $existing_people->life_stage,
            'hash'          => $existing_people->hash,
            'type'          => '',
        ];

        $args           = array_merge($defaults, $args);
        $errors         = [];
        $unchanged_data = [];
        $people_type    = $args['type'];

        unset($args['type'], $args['created']);

        //sensitization
        $args['email'] = strtolower(trim($args['email']));

        if (!empty($args['phone'])) {
            $args['phone'] = $args['phone'];
        }

        if (!empty($args['mobile'])) {
            $args['mobile'] = $args['mobile'];
        }

        // Assign first name as company name for accounting customer search
        if ($people_type === 'company') {
            $args['first_name'] = $args['company'];
            $args['last_name']  = '(company)';
        }

        if (!$existing_people->id) {
            // if an empty type provided
            if ('' === $people_type) {
                return new WP_Error('no-type', __('No user type provided.', 'erp'));
            }

            // Some validation
            $type_obj = \WeDevs\ERP\Framework\Models\PeopleTypes::name($people_type)->first();

            // check if a valid people type exists in the database
            if (null === $type_obj) {
                return new WP_Error('no-type_found', __('The people type is invalid.', 'erp'));
            }
        }

        if ('contact' === $people_type) {
            if (empty($args['user_id'])) {
                // Check if contact first name or email or phone provided or not or provided name is valid
                if (empty($args['first_name']) || empty($args['email'])) {
                    return new WP_Error('no-basic-data', esc_attr__('You must need to fill up both first name and email fields', 'erp'));
                } else {
                    if (!erp_is_valid_name($args['first_name'])) {
                        return new WP_Error('invalid-first-name', esc_attr__('Please provide a valid first name', 'erp'));
                    }

                    if (!empty($args['last_name']) && !erp_is_valid_name($args['last_name'])) {
                        return new WP_Error('invalid-last-name', esc_attr__('Please provide a valid last name', 'erp'));
                    }
                }
            }
        }

        // Check if company name provide or not or provided name is valid
        if ('company' === $people_type) {
            if (empty($args['company']) || empty($args['email'])) {
                return new WP_Error('no-company', esc_attr__('You must need to fill up both Company name and email fields', 'erp'));
            } else {
                if (erp_contains_disallowed_chars($args['company'])) {
                    return new WP_Error('invalid-company', esc_attr__('Please provide a valid company name', 'erp'));
                }
            }
        }

        // Check if not empty and valid email
        if (!empty($args['email']) && !is_email($args['email'])) {
            return new WP_Error('invalid-email', esc_attr__('Please provide a valid email address', 'erp'));
        }


        if (!empty($args['phone']) && !erp_is_valid_contact_no($args['phone'])) {
            return new WP_Error('invalid-phone', esc_attr__('Please provide a valid phone number', 'erp'));
        }

        if (!empty($args['date_of_birth']) && !erp_is_valid_date($args['date_of_birth'])) {
            return new WP_Error('invalid-date-of-birth', esc_attr__('Please provide a valid date of birth', 'erp'));
        }

        if (!empty($args['contact_age']) && !erp_is_valid_age($args['contact_age'])) {
            return new WP_Error('invalid-age', esc_attr__('Please provide a valid age', 'erp'));
        }

        if (!empty($args['mobile']) && !erp_is_valid_contact_no($args['mobile'])) {
            return new WP_Error('invalid-mobile', esc_attr__('Please provide a valid mobile number', 'erp'));
        }

        if (!empty($args['website']) && !erp_is_valid_url($args['website'])) {
            return new WP_Error('invalid-website', esc_attr__('Please provide a valid website', 'erp'));
        }

        if (!empty($args['fax']) && !erp_is_valid_contact_no($args['fax'])) {
            return new WP_Error('invalid-fax', esc_attr__('Please provide a valid fax number', 'erp'));
        }


        if (!empty($args['postal_code']) && !erp_is_valid_zip_code($args['postal_code'])) {
            return new WP_Error('invalid-postal-code', esc_attr__('Please provide a valid postal code', 'erp'));
        }

        $errors = apply_filters('erp_people_validation_error', [], $args);

        if (!empty($errors)) {
            return $errors;
        }

        if ($args['user_id']) {
            $user = \get_user_by('id', $args['user_id']);
        } else {
            $user = \get_user_by('email', $args['email']);
        }

        if (!$existing_people->id) {
            if (!$user) {
                $user             = new stdClass();
                $user->ID         = 0;
                $user->user_url   = '';
                $user->user_email = '';
            }

            $args['created_by'] = auth()->user()->id ? auth()->user()->id : 1;
            $args['hash']       = sha1(microtime() . 'erp-unique-hash-id' . $args['email']);

            $existing_people_by_email = \WeDevs\ERP\Framework\Models\People::where('email', $args['email'])->first();

            if (!empty($existing_people_by_email->email) && $existing_people_by_email->hasType($people_type)) {
                $is_existing_people = true;
                $people             = $existing_people_by_email;
            } elseif (!empty($existing_people_by_email->email) && !$existing_people_by_email->hasType($people_type)) {
                $is_existing_people = true;
                $people             = $existing_people_by_email;
                $people->first_name = $args['first_name'];
                $people->last_name  = $args['last_name'];
            } else {
                $people = \WeDevs\ERP\Framework\Models\People::create([
                    'user_id'       => $user->ID,
                    'first_name'    => $args['first_name'],
                    'last_name'     => $args['last_name'],
                    'email'         => !empty($args['email']) ? $args['email'] : $user->user_email,
                    'website'       => !empty($args['website']) ? $args['website'] : $user->user_url,
                    'hash'          => $args['hash'],
                    'contact_owner' => $args['contact_owner'],
                    'created_by'    => $args['created_by'],
                    'created'       => current_time('mysql'),
                ]);
            }

            if (!$people->id) {
                return new WP_Error('people-not-created', __('Something went wrong, please try again', 'erp'));
            }
        } else {
            $existing_people_by_email = \WeDevs\ERP\Framework\Models\People::type($people_type)->where('email', $args['email'])->first();

            if (!empty($existing_people_by_email->email) && intval($existing_people_by_email->id) !== intval($existing_people->id)) {
                $is_existing_people = true;
            }

            $people = $existing_people;
        }

        if (isset($user->ID) && $user->ID) {
            // Set data for updating record
            $user_id = wp_update_user([
                'ID'         => $user->ID,
                'user_url'   => !empty($args['website']) ? $args['website'] : $user->user_url,
                'user_email' => !empty($args['email']) ? $args['email'] : $user->user_email,
            ]);

            if (is_wp_error($user_id)) {
                return new WP_Error('update-user', $user_id->get_error_message());
            } else {
                $people->update(['user_id' => $user_id, 'email' => $args['email'], 'website' => $args['website'], 'contact_owner' => $args['contact_owner']]);

                unset($args['id'], $args['user_id'], $args['email'], $args['website'], $args['contact_owner'], $args['created_by'], $args['hash']);

                wp_cache_delete('erp_people_id_user_' . $user->ID, 'erp');

                if ('employee' !== $people_type) {
                    foreach ($args as $key => $value) {
                        if (!update_user_meta($user_id, $key, $value)) {
                            $unchanged_data[$key] = $value;
                        }
                    }
                }
            }
        } else {
            $unchanged_data = $args;
        }

        $main_fields = [];
        $meta_fields = [];

        if ($unchanged_data) {
            foreach ($unchanged_data as $key => $value) {
                if (array_key_exists($key, $defaults)) {
                    $main_fields[$key] = $value;
                } else {
                    $meta_fields[$key] = $value;
                }
            }
        }

        if (!empty($main_fields)) {
            $people->update($main_fields);
        }

        if (!empty($people_type) && !$people->hasType($people_type)) {
            if (empty($is_existing_people) || ($people->hasType('employee') && 'contact' === $people_type)) {
                $people->assignType($type_obj);
            }
        }

        //unset created_by from meta
        unset($meta_fields['created_by']);

        if (!empty($meta_fields)) {
            $people_metada = array_keys($this->peopleGetMeta($people->id));

            foreach ($people_metada as $single_data) {
                if (!array_key_exists($single_data, $meta_fields)) {
                    $this->peopleDeleteMeta($people->id, $single_data);
                }
            }

            foreach ($meta_fields as $key => $value) {
                if ('raw_data' !== $key) {
                    $this->peopleUpdateMeta($people->id, $key, $value);
                }
            }
        }

        if (!$existing_people->id) {
            do_action('erp_create_new_people', $people->id, $args, $people_type);
            do_action("erp_acct_after_new_{$people_type}", $people->id, $args);
        } else {
            do_action('erp_update_people', $people->id, $args, $people_type);
        }

        if (!empty($is_existing_people)) {
            $people->exists = true;
        }

        $hash = $people->hash;

        if (empty($hash)) {
            $hash_id = sha1(microtime() . 'erp-unique-hash-id' . $people->email);
            $people->update(['hash', $hash_id]);
        }


        /*
     * Action hook to trigger any event when a people is created.
     *
     * @since 1.10.3
     */
        do_action('erp_people_created', $people->id, $people, $people_type);

        return $return_object ? $people : $people->id;
    }

    /**
     * Add meta data field to a people.
     *
     * @since 1.0
     *
     * @param int    $people_id  people id
     * @param string $meta_key   metadata name
     * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
     * @param bool   $unique     Optional. Whether the same key should not be added.
     *                           Default false.
     *
     * @return int|false meta id on success, false on failure
     */
    function peopleAddMeta($people_id, $meta_key, $meta_value, $unique = false)
    {
        return add_metadata('erp_people', $people_id, $meta_key, $meta_value, $unique);
    }

    /**
     * Retrieve people meta field for a people.
     *
     * @since 1.0
     *
     * @param int    $people_id people id
     * @param string $key       Optional. The meta key to retrieve. By default, returns
     *                          data for all keys. Default empty.
     * @param bool   $single    Optional. Whether to return a single value. Default false.
     *
     * @return mixed Will be an array if $single is false. Will be value of meta data
     *               field if $single is true.
     */
    function peopleGetMeta($people_id, $key = '', $single = false)
    {
        return get_metadata('erp_people', $people_id, $key, $single);
    }

    /**
     * Update people meta field based on people id.
     *
     * Use the $prev_value parameter to differentiate between meta fields with the
     * same key and people id.
     *
     * If the meta field for the people does not exist, it will be added.
     *
     * @since 1.0
     *
     * @param int    $people_id  people id
     * @param string $meta_key   metadata key
     * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
     * @param mixed  $prev_value Optional. Previous value to check before removing.
     *                           Default empty.
     *
     * @return int|bool meta id if the key didn't exist, true on successful update,
     *                  false on failure
     */
    function peopleUpdateMeta($people_id, $meta_key, $meta_value, $prev_value = '')
    {
        return update_metadata('erp_people', $people_id, $meta_key, $meta_value, $prev_value);
    }

    /**
     * Remove metadata matching criteria from a people.
     *
     * You can match based on the key, or key and value. Removing based on key and
     * value, will keep from removing duplicate metadata with the same key. It also
     * allows removing all metadata matching key, if needed.
     *
     * @since 1.0
     *
     * @param int    $people_id  people id
     * @param string $meta_key   metadata name
     * @param mixed  $meta_value Optional. Metadata value. Must be serializable if
     *                           non-scalar. Default empty.
     *
     * @return bool true on success, false on failure
     */
    function peopleDeleteMeta($people_id, $meta_key, $meta_value = '')
    {
        return delete_metadata('erp_people', $people_id, $meta_key, $meta_value);
    }

    /**
     * Get people all main db fields
     *
     * @since 1.1.7
     *
     * @return array
     */
    function getPeopleMainField()
    {
        return [
            'user_id',
            'first_name',
            'last_name',
            'company',
            'email',
            'phone',
            'mobile',
            'other',
            'website',
            'fax',
            'notes',
            'street_1',
            'street_2',
            'city',
            'state',
            'postal_code',
            'country',
            'currency',
            'created_by',
            'life_stage',
            'created',
        ];
    }

    /**
     * Convert to ERP People
     *
     * Convert one people type to another or convert wp user to erp people
     *
     * @since 1.1.12
     *
     * @param array $args
     *
     * @return int|object people_id on success and WP_Error object on fail
     */
    function convertToPeople($args = [])
    {
        $type = !empty($args['type']) ? $args['type'] : 'contact';

        if ($args['is_wp_user'] && $args['wp_user_id']) {
            $wp_user = \get_user_by('id', $args['wp_user_id']);

            $params = [
                'first_name'  => $wp_user->first_name,
                'last_name'   => $wp_user->last_name,
                'email'       => $wp_user->user_email,
                'company'     => 'contact' === $type ? get_user_meta($wp_user->ID, 'company', true) : $wp_user->first_name,
                'phone'       => get_user_meta($wp_user->ID, 'phone', true),
                'mobile'      => get_user_meta($wp_user->ID, 'mobile', true),
                'other'       => get_user_meta($wp_user->ID, 'other', true),
                'website'     => $wp_user->user_url,
                'fax'         => get_user_meta($wp_user->ID, 'fax', true),
                'notes'       => get_user_meta($wp_user->ID, 'notes', true),
                'street_1'    => get_user_meta($wp_user->ID, 'street_1', true),
                'street_2'    => get_user_meta($wp_user->ID, 'street_2', true),
                'city'        => get_user_meta($wp_user->ID, 'city', true),
                'state'       => get_user_meta($wp_user->ID, 'state', true),
                'postal_code' => get_user_meta($wp_user->ID, 'postal_code', true),
                'country'     => get_user_meta($wp_user->ID, 'country', true),
                'currency'    => get_user_meta($wp_user->ID, 'currency', true),
                'user_id'     => $wp_user->ID,
                'type'        => $type,
                'photo_id'    => get_user_meta($wp_user->ID, 'photo_id', true),
            ];

            $people_id = $this->insertPeopleDB($params);

            if (is_wp_error($people_id)) {
                return $people_id;
            }
        } else {
            $people_obj = \WeDevs\ERP\Framework\Models\People::find($args['people_id']);

            if (empty($people_obj)) {
                return new \WP_Error('no-erp-people', __('People not exists', 'erp'));
            }

            $type_obj = \WeDevs\ERP\Framework\Models\PeopleTypes::name($type)->first();
            $people_obj->assignType($type_obj);
            $people_id = $people_obj->id;
        }


        return $people_id;
    }

    /**
     * Get people email
     *
     * Get people email by id
     *
     * @since 1.4.7
     *
     * @param array $id
     *
     * @return string
     */
    function getPeopleEmail($id)
    {


        $sql = "SELECT email FROM erp_peoples WHERE id = " .absint($id);

        return DB::scalar($sql);
    }

    /**
     * Checks a people is trashed or not
     *
     * @since 1.7.1
     *
     * @param int $id
     *
     * @return bool
     */
    function isPeopleTrashed($id)
    {


        $trashed = DB::scalar(
            "SELECT deleted_at FROM erp_people_type_relations WHERE people_id = %d", [absint($id)]
        );

        if ($trashed) {
            return true;
        }

        return false;
    }
}
