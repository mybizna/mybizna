<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class UserLeave extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_user_leave";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->bigIncrements('id');
        $table->integer('user_id')->nullable();
        $table->integer('request_id')->nullable();
        $table->string('title')->nullable();
        $table->date('date')->nullable();
    }
}
