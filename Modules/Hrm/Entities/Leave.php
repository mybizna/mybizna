<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Leave extends Model
{

    protected $fillable = ['name', 'description'];
    protected $migrationOrder = 5;
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
