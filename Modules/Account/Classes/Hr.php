<?php
/**
 * Hr
 * 
 * @category HRM
 * @package  Hrm
 * @author   Dedan Irungu <dedanirungu@gmail.com>
 * @license  GPL v3
 * @link     http://www.mybizna.com
 */
namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;

/**
 * Hr
 * 
 * @category HRM
 * @package  Hrm
 * @author   Dedan Irungu <dedanirungu@gmail.com>
 * @license  GPL v3
 * @link     http://www.mybizna.com
 */
class Hr
{

    /**
     * This method will count active users of hrm
     *
     * @return int
     */
    public function hrGetEmployees()
    {


        $emp_tbl = 'erp_hr_employees';

        $query = "select $emp_tbl.user_id from $emp_tbl
            left join users on $emp_tbl.user_id = user.id
            where $emp_tbl.status != 'active' or $emp_tbl.deleted_at is not null";


        return DB::scalar($query);
    }
}
