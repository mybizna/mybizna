<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Product extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "product";

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
        $table->integer('product_type_id')->nullable();
        $table->integer('category_id')->nullable();
        $table->integer('tax_cat_id')->nullable();
        $table->integer('vendor')->nullable();
        $table->decimal('cost_price', 20, 2)->default(0.00);
        $table->decimal('sale_price', 20, 2)->default(0.00);
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
