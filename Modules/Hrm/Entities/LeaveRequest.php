<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LeaveRequest extends Model
{

    protected $fillable = [
        'user_id', 'leave_id', 'leave_entitlement_id', 'day_status_id', 'days',
        'start_date', 'end_date', 'reason', 'last_status'
    ];
    protected $migrationOrder = 5;
    protected $table = "leave_request";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id')->index('user_id');
        $table->unsignedSmallInteger('leave_id');
        $table->unsignedBigInteger('leave_entitlement_id')->default(0)->index('leave_entitlement_id');
        $table->unsignedSmallInteger('day_status_id')->default(1);
        $table->unsignedDecimal('days', 5, 1)->default(0.0);
        $table->integer('start_date');
        $table->integer('end_date');
        $table->text('reason')->nullable();
        $table->unsignedSmallInteger('last_status')->default(2)->index('last_status');

        $table->index(['user_id', 'leave_id'], 'user_leave');
        $table->index(['user_id', 'leave_entitlement_id'], 'user_entitlement');
    }
}
