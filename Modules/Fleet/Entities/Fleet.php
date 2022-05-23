<?php

namespace Modules\Fleet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Fleet extends Model
{

    protected $fillable = ['name'];
    protected $migrationOrder = 1;
    protected $table = "fleet";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name');
    }
}
