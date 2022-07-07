<?php

namespace Modules\Product\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Type extends BaseModel
{

    protected $fillable = ['name', 'slug'];
    public $migrationDependancy = [];
    protected $table = "product_type";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('slug')->nullable();
    }
}
