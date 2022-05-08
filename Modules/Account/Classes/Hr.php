<?php

namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;

class Hr
{

    /**
     * This method will count active users of hrm
     *
     * @since 1.6.4
     *
     * @return int
     */
    public function hrGetEmployees()
    {
       

        $employee_tbl = 'erp_hr_employees';

        $query = $wpdb->prepare(
            "select $employee_tbl.user_id from $employee_tbl
            left join {$wpdb->users} on $employee_tbl.user_id = {$wpdb->users}.ID
            where $employee_tbl.status != %s or $employee_tbl.deleted_at is not null",
            ['active']
        );

        return $wpdb->get_col($query);
    }
}
