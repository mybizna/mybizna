<?php

namespace Modules\Mrp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LeaveUnpaid extends Model
{

    protected $fillable = [];
    protected $table = "hrm_leave_unpaid";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedBigInteger('id')->primary();
        $table->unsignedSmallInteger('leave_id')->index('leave_id');
        $table->unsignedBigInteger('leave_request_id')->index('leave_request_id');
        $table->unsignedBigInteger('leave_approval_status_id')->index('leave_approval_status_id');
        $table->unsignedBigInteger('user_id')->index('user_id');
        $table->unsignedDecimal('days', 4, 1)->default(0.0);
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->decimal('total', 20, 2)->default(0.00);
        $table->unsignedSmallInteger('f_year')->index('f_year');
        $table->timestamps();
    }
}
