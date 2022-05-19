<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Detail extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "purchase_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->integer('trn_no')->nullable();
        $table->integer('product_id')->nullable();
        $table->integer('qty')->nullable();
        $table->decimal('price', 20, 2)->default(0.00);
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->decimal('tax', 20, 2)->nullable();
        $table->integer('tax_cat_id')->nullable();
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
