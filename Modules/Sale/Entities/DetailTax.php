<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class DetailTax extends Model
{

    protected $fillable = ['invoice_details_id', 'agency_id', 'tax_rate'];
    public $migrationDependancy = [];
    protected $table = "sale_detail_tax";

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
        $table->integer('agency_id')->nullable();
        $table->decimal('tax_rate', 20, 2);
    }
}
