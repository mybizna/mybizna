<?php

namespace Modules\Hrm\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class LeavePolicy extends Model
{

    protected $fillable = [
        'leave_id', 'description', 'days', 'color', 'apply_limit', 'employee_type', 'department_id',
        'location_id', 'designation_id', 'gender', 'marital', 'f_year', 'apply_for_new_users',
        'carryover_days', 'carryover_uses_limit', 'encashment_based_on', 'forward_default',
        'applicable_from_days', 'accrued_amount', 'accrued_max_days', 'halfday_enable'
    ];
    public $migrationDependancy = [];
    protected $table = "hrm_leave_policy";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {


        $table->increments('id');
        $table->unsignedSmallInteger('leave_id')->index('leave_id');
        $table->text('description')->nullable();
        $table->unsignedTinyInteger('days')->default(0);
        $table->string('color', 10)->nullable();
        $table->unsignedTinyInteger('apply_limit')->default(0);
        $table->enum('employee_type', ['-1', 'permanent', 'parttime', 'contract', 'temporary', 'trainee'])->default('permanent');
        $table->integer('department_id')->default(-1);
        $table->integer('location_id')->default(-1);
        $table->integer('designation_id')->default(-1);
        $table->enum('gender', ['-1', 'male', 'female', 'other'])->default('-1');
        $table->enum('marital', ['-1', 'single', 'married', 'widowed'])->default('-1');
        $table->unsignedSmallInteger('f_year')->nullable()->index('f_year');
        $table->unsignedTinyInteger('apply_for_new_users')->default(0);
        $table->unsignedTinyInteger('carryover_days')->default(0);
        $table->unsignedTinyInteger('carryover_uses_limit')->default(0);
        $table->unsignedTinyInteger('encashment_days')->default(0);
        $table->enum('encashment_based_on', ['pay_rate', 'basic', 'gross'])->nullable();
        $table->enum('forward_default', ['encashment', 'carryover'])->default('encashment');
        $table->unsignedSmallInteger('applicable_from_days')->default(0);
        $table->decimal('accrued_amount', 10, 2)->default(0.00);
        $table->unsignedSmallInteger('accrued_max_days')->default(0);
        $table->unsignedTinyInteger('halfday_enable')->default(0);
    }
}
