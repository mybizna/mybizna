<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TaxCategoryAgency extends Model
{

    protected $fillable = [];
    protected $table = "account_tax_category_agency";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->integer('tax_id')->nullable();
        $table->string('component_name')->nullable();
        $table->integer('tax_cat_id')->nullable();
        $table->integer('agency_id')->nullable();
        $table->decimal('tax_rate', 20, 2)->default(0.00);
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
