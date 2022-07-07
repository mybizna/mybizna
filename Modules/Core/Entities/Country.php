<?php

namespace Modules\Base\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Country extends BaseModel
{

    protected $table = "base_country";

    public $migrationDependancy = [];

    protected $fillable = ['name', 'code', 'code3', 'latitude', 'longitude'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_by', 'updated_by', 'deleted_at'];

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
        $table->string('code', 2);
        $table->string('code3', 3)->nullable()->default(null);
        $table->string('latitude', 255)->nullable()->default(null);
        $table->string('longitude', 255)->nullable()->default(null);
    }
}
