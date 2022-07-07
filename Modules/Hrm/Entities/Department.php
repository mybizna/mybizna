<?php

namespace Modules\Hrm\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Department extends BaseModel
{

    protected $fillable = ['title', 'slug', 'description', 'lead', 'parent', 'status'];
    public $migrationDependancy = [];
    protected $table = "hrm_department";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('title', 200)->default('');
        $table->string('slug')->nullable();
        $table->text('description')->nullable();
        $table->unsignedInteger('lead')->default(0);
        $table->unsignedInteger('parent')->default(0);
        $table->unsignedTinyInteger('status')->default(1);
    }
}
