<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ReturnDetail extends Model
{

    protected $fillable = [
        'invoice_details_id', 'trn_no', 'product_id', 'qty',
        'price', 'discount', 'tax'
    ];
    protected $migrationOrder = 5;
    protected $table = "purchase_return_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('invoice_details_id');
        $table->integer('trn_no');
        $table->integer('product_id');
        $table->integer('qty');
        $table->decimal('price', 20, 2);
        $table->decimal('discount', 20, 2)->default(0.00);
        $table->decimal('tax', 20, 2)->default(0.00);
    }
}
