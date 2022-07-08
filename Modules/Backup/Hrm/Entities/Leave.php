<?php

namespace Modules\Hrm\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Leave extends BaseModel
{

    protected $fillable = ['name', 'description'];
    public $migrationDependancy = [];
    protected $table = "hrm_leave";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name', 150);
        $table->text('description')->nullable();
    }
}
