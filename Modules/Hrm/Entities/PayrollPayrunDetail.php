<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollPayrunDetail extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_payroll_payrun_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->unsignedInteger('payrun_id');
        $table->unsignedInteger('pay_cal_id');
        $table->date('payment_date')->nullable();
        $table->unsignedInteger('empid');
        $table->integer('pay_item_id');
        $table->decimal('pay_item_amount', 10, 2);
        $table->integer('pay_item_add_or_deduct');
        $table->string('note')->nullable();
        $table->unsignedInteger('approve_status')->default(0);
    }
}
