<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class EmployeeRemoteWorkRequest extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_employee_remote_work_request";

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
        $table->date('start_date');
        $table->date('end_date');
        $table->unsignedSmallInteger('days')->default(0);
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamps();
        $table->unsignedBigInteger('updated_by')->nullable();
    }
}
