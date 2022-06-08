<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayrollPayitem extends Model
{

    protected $fillable = ['type', 'payitem', 'slug', 'pay_item_add_or_deduct'];
    public $migrationDependancy = [];
    protected $table = "hrm_payroll_payitem";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('type');
        $table->string('payitem');
        $table->string('slug');
        $table->integer('pay_item_add_or_deduct');
    }
}
