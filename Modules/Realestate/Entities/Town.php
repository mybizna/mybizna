<?php

namespace Modules\Realestate\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Town extends Model
{

    protected $fillable = ['name', 'region_id', 'description'];
    public $migrationDependancy = ['realestate_region'];
    protected $table = "realestate_town";

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
        $table->integer('region_id')->unsigned()->nullable();
        $table->string('description')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('realestate_region', 'region_id')) {
            $table->foreign('region_id')->references('id')->on('realestate_region')->nullOnDelete();
        }
    }
}
