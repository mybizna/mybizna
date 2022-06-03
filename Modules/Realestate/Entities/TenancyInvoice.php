<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TenancyInvoice extends Model
{

    protected $fillable = ['title', 'tenancy_id', 'invoice_id',  'billing_period'];
    protected $migrationOrder = 10;
    protected $table = "realestate_tenancy_services";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->increments('id');
        $table->foreign('tenancy_id')->references('id')->on('realestate_tenancy')->nullOnDelete();
        $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();
        $table->char('billing_period', 20)->nullable();
    }
}
