<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollPayrun extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_payroll_payrun";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->unsignedInteger('id')->primary();
        $table->unsignedInteger('pay_cal_id');
        $table->date('payment_date')->nullable();
        $table->date('from_date')->nullable();
        $table->date('to_date')->nullable();
        $table->unsignedInteger('approve_status')->default(0);
        $table->unsignedInteger('jr_tran_id')->default(0);
        $table->timestamp('updated_at')->useCurrent();
    }
}
