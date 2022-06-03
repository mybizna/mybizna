<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class BuildingUnitSetup extends Model
{

    protected $fillable = ['title', 'building_id', 'amount'];
    protected $migrationOrder = 10;
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
        $table->string('title');
        $table->foreign('building_id')->references('id')->on('realestate_building')->nullOnDelete();
        $table->double('amount', 8, 2)->nullable();
    }
}
