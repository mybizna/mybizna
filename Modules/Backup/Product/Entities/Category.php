<?php

namespace Modules\Product\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Category extends BaseModel
{

    protected $fillable = ['name', 'parent'];
    public $migrationDependancy = [];
    protected $table = "product_category";

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
        $table->integer('parent')->default(0);
    }
}
