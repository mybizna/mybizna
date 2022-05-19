<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollAdditionalAllowanceDeduction extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_payroll_additional_allowance_deduction";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->integer('pay_item_id');
        $table->decimal('pay_item_amount', 10, 2);
        $table->integer('empid');
        $table->integer('pay_item_add_or_deduct');
        $table->integer('payrun_id');
        $table->string('note')->nullable();
    }
}
