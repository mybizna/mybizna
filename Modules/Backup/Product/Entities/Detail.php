<?php

namespace Modules\Product\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Detail extends BaseModel
{

    protected $fillable = ['product_id', 'trn_no', 'stock_in', 'stock_out'];
    public $migrationDependancy = [];
    protected $table = "product_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('product_id')->nullable();
        $table->integer('trn_no')->nullable();
        $table->integer('stock_in')->nullable();
        $table->integer('stock_out')->nullable();
    }
}
