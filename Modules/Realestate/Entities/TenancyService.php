<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TenancyService extends Model
{

    protected $fillable = ['title', 'tenancy_id', 'amount',  'billing_date'];
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
        $table->string('title');
        $table->foreign('tenancy_id')->references('id')->on('realestate_tenancy')->nullOnDelete();
        $table->double('amount', 8, 2)->nullable();
        $table->dateTime('billing_date')->nullable();
    }




}
