<?php

namespace Modules\Hrm\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class PayrollPayrun extends BaseModel
{

    protected $fillable = ['pay_cal_id', 'payment_date', 'from_date', 'to_date', 'approve_status', 'jr_tran_id'];
    public $migrationDependancy = [];
    protected $table = "hrm_payroll_payrun";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->unsignedInteger('pay_cal_id');
        $table->date('payment_date')->nullable();
        $table->date('from_date')->nullable();
        $table->date('to_date')->nullable();
        $table->unsignedInteger('approve_status')->default(0);
        $table->unsignedInteger('jr_tran_id')->default(0);
    }
}
