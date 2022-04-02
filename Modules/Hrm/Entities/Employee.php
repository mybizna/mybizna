<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Employee extends Model
{

    protected $fillable = [];
    protected $table = "hrm_employee";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedBigInteger('id')->primary();
        $table->unsignedBigInteger('user_id')->default(0)->index('user_id');
        $table->string('employee_id', 20)->nullable()->index('employee_id');
        $table->unsignedInteger('designation')->default(0)->index('designation');
        $table->unsignedInteger('department')->default(0)->index('department');
        $table->unsignedInteger('location')->default(0);
        $table->string('hiring_source', 20);
        $table->date('hiring_date');
        $table->date('termination_date');
        $table->date('date_of_birth');
        $table->unsignedBigInteger('reporting_to')->default(0);
        $table->unsignedDecimal('pay_rate', 20, 2)->default(0.00);
        $table->string('pay_type', 20)->default('');
        $table->string('type', 20);
        $table->string('status', 10)->default('')->index('status');
        $table->dateTime('deleted_at')->nullable();
    }
}
