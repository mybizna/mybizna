<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class EmployeeResignRequest extends Model
{

    protected $fillable = ['user_id', 'reason', 'date', 'status'];
    protected $migrationOrder = 10;
    protected $table = "hrm_employee_resign_request";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id')->default(0)->index('user_id');
        $table->string('reason')->nullable();
        $table->date('date');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    }
}
