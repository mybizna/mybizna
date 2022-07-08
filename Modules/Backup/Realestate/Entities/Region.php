<?php

namespace Modules\Realestate\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class Region extends BaseModel
{

    protected $fillable = ['name', 'description', 'country_id', 'state_id'];
    public $migrationDependancy = ['core_country', 'core_state'];
    protected $table = "realestate_region";

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
        $table->integer('country_id')->unsigned()->nullable();
        $table->integer('state_id')->unsigned()->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('realestate_region', 'country_id')) {
            $table->foreign('country_id')->references('id')->on('core_country')->nullOnDelete();
        }
        if (Migration::checkKeyExist('realestate_region', 'state_id')) {
            $table->foreign('state_id')->references('id')->on('core_state')->nullOnDelete();
        }
    }
}
