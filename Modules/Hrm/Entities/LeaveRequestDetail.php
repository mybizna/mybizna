<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LeaveRequestDetail extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_leave_request_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('leave_request_id')->index('leave_request_id');
        $table->unsignedBigInteger('leave_approval_status_id');
        $table->unsignedTinyInteger('workingday_status')->default(1);
        $table->unsignedBigInteger('user_id')->index('user_id');
        $table->smallInteger('f_year');
        $table->integer('leave_date');

        $table->index(['user_id', 'f_year', 'leave_date'], 'user_fyear_leave');
    }
}
