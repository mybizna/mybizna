<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Type extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
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
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
