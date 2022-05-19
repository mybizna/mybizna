<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollCalendarTypeSetting extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_payroll_calendar_type_setting";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->integer('pay_calendar_id');
        $table->integer('cal_type')->default(0);
        $table->integer('pay_day')->default(0);
        $table->integer('custom_month_day')->default(0);
        $table->integer('pay_day_mode')->default(0);
    }
}
