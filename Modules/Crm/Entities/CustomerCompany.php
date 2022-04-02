<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CustomerCompany extends Model
{

    protected $fillable = [];
    protected $table = "crm_customer_company";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedBigInteger('id')->primary();
        $table->bigInteger('customer_id')->nullable()->index('customer_id');
        $table->bigInteger('company_id')->nullable()->index('company_id');
    }
}
