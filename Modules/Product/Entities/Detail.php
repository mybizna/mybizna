<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Detail extends Model
{

    protected $fillable = [];
    protected $table = "product_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->integer('product_id')->nullable();
        $table->integer('trn_no')->nullable();
        $table->integer('stock_in')->nullable();
        $table->integer('stock_out')->nullable();
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
