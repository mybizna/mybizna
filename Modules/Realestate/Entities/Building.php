<?php

namespace Modules\Realestate\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Building extends Model
{

    protected $fillable = ['name', 'estate_id', 'type', 'description', 'units', 'default_deposit', 'default_goodwill', 'default_amount', 'is_full'];
    public $migrationDependancy = ['realestate_estate'];
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
        $table->integer('estate_id')->unsigned()->nullable();
        $table->enum('type', ['apartment', 'maisonette', 'bungalow'])->default('apartment')->nullable();
        $table->string('description')->nullable();
        $table->integer('units')->nullable();
        $table->double('default_deposit', 8, 2)->nullable();
        $table->double('default_goodwill', 8, 2)->nullable();
        $table->double('default_amount', 8, 2)->nullable();
        $table->boolean('is_full')->default(false)->nullable();
    }


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('realestate_building', 'estate_id')) {
            $table->foreign('estate_id')->references('id')->on('realestate_estate')->nullOnDelete();
        }
    }
}
