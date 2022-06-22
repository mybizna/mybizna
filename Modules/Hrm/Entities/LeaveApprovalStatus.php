<?php

namespace Modules\Hrm\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class LeaveApprovalStatus extends Model
{

    protected $fillable = [
        'leave_request_id', 'approval_status_id', 'approved_by', 'message'
    ];
    public $migrationDependancy = [];
    protected $table = "hrm_leave_approval_status";

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
        $table->unsignedTinyInteger('approval_status_id')->default(0)->index('approval_status_id');
        $table->unsignedBigInteger('approved_by')->nullable();
        $table->text('message')->nullable();
    }
}
