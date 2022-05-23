<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LeaveEntitlement extends Model
{

    protected $fillable = [
        'user_id','leave_id','trn_id','trn_type','day_in','day_out','description', 'f_year'
    ];
    protected $migrationOrder = 5;
    protected $table = "hrm_leave_entitlement";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedSmallInteger('leave_id')->index('leave_id');
        $table->unsignedBigInteger('trn_id')->index('trn_id');
        $table->enum('trn_type', ['leave_policies', 'leave_approval_status', 'leave_encashment_requests', 'leave_entitlements', 'unpaid_leave', 'leave_encashment', 'leave_carryforward', 'manual_leave_policies', 'accounts', 'others', 'leave_accrual', 'carry_forward_leave_expired'])->default('leave_policies');
        $table->unsignedDecimal('day_in', 5, 1)->default(0.0);
        $table->unsignedDecimal('day_out', 5, 1)->default(0.0);
        $table->text('description')->nullable();
        $table->smallInteger('f_year');

        $table->index(['user_id', 'leave_id', 'f_year', 'trn_type'], 'comp_key_1');
    }
}
