<?php

namespace Modules\Hrm\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class UserLeave extends BaseModel
{

    protected $fillable = ['user_id', 'request_id', 'title', 'date'];
    public $migrationDependancy = [];
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
