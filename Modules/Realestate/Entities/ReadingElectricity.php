<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ReadingElectricity extends Model
{

    protected $fillable = ['name', 'tenancy_id', 'invoice_id', 'reading', 'units', 'billing_period', 'billing_date'];
    protected $migrationOrder = 10;
    protected $table = "realestate_building";

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
        $table->integer('reading');
        $table->integer('units');
        $table->char('billing_period', 20)->nullable();
        $table->dateTime('billing_date')->nullable();
    }
}
