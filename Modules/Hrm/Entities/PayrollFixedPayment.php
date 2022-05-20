<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollFixedPayment extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_payroll_fixed_payment";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->increments('id');
        $table->integer('pay_item_id');
        $table->decimal('pay_item_amount', 10, 2);
        $table->integer('empid');
        $table->integer('pay_item_add_or_deduct');
        $table->string('note')->nullable();
    }
}
