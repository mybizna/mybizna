<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollPayitem extends Model
{

    protected $fillable = [];
    protected $table = "hrm_payroll_payitem";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->string('type');
        $table->string('payitem');
        $table->integer('pay_item_add_or_deduct');
    }
}
