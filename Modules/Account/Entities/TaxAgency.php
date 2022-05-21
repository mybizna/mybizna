<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TaxAgency extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "account_tax_agency";

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
        $table->string('ecommerce_type')->nullable();
    }
}
