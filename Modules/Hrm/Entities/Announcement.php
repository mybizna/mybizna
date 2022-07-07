<?php

namespace Modules\Hrm\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Announcement extends BaseModel
{

    protected $fillable = ['user_id', 'post_id', 'status', 'email_status'];
    public $migrationDependancy = [];
    protected $table = "hrm_announcement";

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
        $table->bigInteger('post_id')->index('post_id');
        $table->string('status', 30)->index('status');
        $table->string('email_status', 30);
    }
}
