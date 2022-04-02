<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ActivityTask extends Model
{

    protected $fillable = [];
    protected $table = "crm_activity_task";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->integer('activity_id')->nullable()->index('activity_id');
        $table->integer('user_id')->nullable()->index('user_id');
    }
}
