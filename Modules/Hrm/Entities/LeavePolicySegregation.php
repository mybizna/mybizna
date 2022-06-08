<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LeavePolicySegregation extends Model
{

    protected $fillable = [
        'leave_policy_id', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul',
         'aug', 'sep', 'oct', 'nov', 'decem'
    ];
    public $migrationDependancy = [];
    protected $table = "hrm_leave_policy_segregation";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('leave_policy_id')->index('leave_policy_id');
        $table->unsignedTinyInteger('jan')->default(0);
        $table->unsignedTinyInteger('feb')->default(0);
        $table->unsignedTinyInteger('mar')->default(0);
        $table->unsignedTinyInteger('apr')->default(0);
        $table->unsignedTinyInteger('may')->default(0);
        $table->unsignedTinyInteger('jun')->default(0);
        $table->unsignedTinyInteger('jul')->default(0);
        $table->unsignedTinyInteger('aug')->default(0);
        $table->unsignedTinyInteger('sep')->default(0);
        $table->unsignedTinyInteger('oct')->default(0);
        $table->unsignedTinyInteger('nov')->default(0);
        $table->unsignedTinyInteger('decem')->default(0);
    }
}
