<?php

namespace Modules\Hrm\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollPayrunDetail extends Model
{

    protected $fillable = [
        'payrun_id', 'pay_cal_id','payment_date','empid','pay_item_id','pay_item_amount',
        'pay_item_add_or_deduct','note','approve_status'
       ];
    public $migrationDependancy = [];
    protected $table = "hrm_payroll_payrun_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
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
