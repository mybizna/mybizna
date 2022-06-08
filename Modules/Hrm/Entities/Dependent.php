<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Dependent extends Model
{

    protected $fillable = ['employee_id', 'name', 'relation', 'dob'];
    public $migrationDependancy = [];
    protected $table = "hrm_dependent";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('employee_id')->nullable()->index('employee_id');
        $table->string('name', 100)->nullable();
        $table->string('relation', 100)->nullable();
        $table->date('dob')->nullable();
    }
}
