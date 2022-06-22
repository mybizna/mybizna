<?php

namespace Modules\Realestate\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Region extends Model
{

    protected $fillable = ['name', 'description', 'country_id', 'state_id'];
    public $migrationDependancy = ['base_country', 'base_state'];
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
        if (Migration::checkKeyExist('base_country', 'country_id')) {
            $table->foreign('country_id')->references('id')->on('base_country')->nullOnDelete();
        }
        if (Migration::checkKeyExist('base_state', 'state_id')) {
            $table->foreign('state_id')->references('id')->on('base_state')->nullOnDelete();
        }
    }
}
