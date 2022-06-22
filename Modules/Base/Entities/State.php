<?php

namespace Modules\Base\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class State extends Model
{

    protected $table = "base_state";

    public $migrationDependancy = [];

    protected $fillable = ['name', 'country_code', 'type', 'item_id','state_code', 'latitude', 'longitude'];


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
        $table->string('country_code', 2);
        $table->string('type', 20)->nullable();
        $table->integer('item_id')->nullable();
        $table->string('state_code', 3)->nullable()->default(null);
        $table->string('latitude', 255)->nullable()->default(null);
        $table->string('longitude', 255)->nullable()->default(null);
    }
}
