<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ReturnDetail extends Model
{

    protected $fillable = [];
    protected $table = "sale_return_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->integer('invoice_details_id');
        $table->integer('trn_no');
        $table->integer('product_id');
        $table->integer('qty');
        $table->decimal('unit_price', 20, 2);
        $table->decimal('discount', 20, 2)->default(0.00);
        $table->decimal('tax', 20, 2)->default(0.00);
        $table->decimal('item_total', 20, 2);
        $table->string('ecommerce_type')->nullable();
        $table->integer('created_by')->nullable();
        $table->integer('updated_by')->nullable();
        $table->timestamps();
    }
}
