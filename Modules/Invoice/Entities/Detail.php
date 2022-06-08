<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Detail extends Model
{

    protected $fillable = [
        'trn_no', 'product_id', 'qty', 'unit_price', 'discount', 'shipping',
        'tax', 'tax_cat_id', 'item_total', 'ecommerce_type'
    ];
    public $migrationDependancy = [];
    protected $table = "invoice_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('trn_no')->nullable();
        $table->integer('product_id')->nullable();
        $table->integer('qty')->nullable();
        $table->decimal('unit_price', 20, 2)->default(0.00);
        $table->decimal('discount', 20, 2)->default(0.00);
        $table->decimal('shipping', 20, 2)->default(0.00);
        $table->decimal('tax', 20, 2)->default(0.00);
        $table->integer('tax_cat_id')->nullable();
        $table->decimal('item_total', 20, 2)->default(0.00);
        $table->string('ecommerce_type')->nullable();
    }
}
