<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Town extends Model
{

    protected $fillable = ['name', 'region_id', 'description'];
    protected $migrationOrder = 4;
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
        $table->foreign('region_id')->references('id')->on('realestate_region')->nullOnDelete();
        $table->string('description')->nullable();
    }
}
