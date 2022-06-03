<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Department extends Model
{

    protected $fillable = ['title', 'slug', 'description', 'lead', 'parent', 'status'];
    protected $migrationOrder = 10;
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
