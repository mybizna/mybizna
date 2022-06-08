<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Classes\Migration;

class BuildingUnitSetup extends Model
{

    protected $fillable = ['title', 'building_id', 'amount'];
    public $migrationDependancy = ['realestate_building'];
    protected $table = "realestate_building_unit_setup";

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
        $table->double('amount', 8, 2)->nullable();
        $table->integer('building_id')->unsigned()->nullable();
    }


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('realestate_building', 'building_id')) {
            $table->foreign('building_id')->references('id')->on('realestate_building')->nullOnDelete();
        }
    }
}
