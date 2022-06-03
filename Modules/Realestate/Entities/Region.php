<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Region extends Model
{

    protected $fillable = ['name', 'description', 'country_id', 'state_id'];
    protected $migrationOrder = 3;
    protected $table = "realestate_building";

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
        $table->string('description')->nullable();
        $table->foreign('country_id')->references('id')->on('base_country')->nullOnDelete();
        $table->foreign('state_id')->references('id')->on('base_state')->nullOnDelete();
    }
}
