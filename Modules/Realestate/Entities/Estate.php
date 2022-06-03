<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Estate extends Model
{

    protected $fillable = ['name', 'description', 'town_id'];
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
        $table->string('description')->nullable();
        $table->foreign('town_id')->references('id')->on('realestate_town')->nullOnDelete();
    }
}
