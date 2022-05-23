<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollPayCalendar extends Model
{

    protected $fillable = ['pay_calendar_name', 'pay_calendar_type'];
    protected $migrationOrder = 5;
    protected $table = "hrm_payroll_pay_calendar";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('pay_calendar_name', 64)->nullable();
        $table->string('pay_calendar_type', 16);
    }
}
