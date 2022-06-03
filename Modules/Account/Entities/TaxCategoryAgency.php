<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TaxCategoryAgency extends Model
{

    protected $fillable = ['tax_id', 'component_name', 'tax_cat_id', 'agency_id', 'tax_rate'];
    protected $migrationOrder = 10;
    protected $table = "account_tax_category_agency";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('tax_id')->nullable();
        $table->string('component_name')->nullable();
        $table->integer('tax_cat_id')->nullable();
        $table->integer('agency_id')->nullable();
        $table->decimal('tax_rate', 20, 2)->default(0.00);
    }
}
