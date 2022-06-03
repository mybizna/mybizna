<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class BillingItem extends Model
{

    protected $fillable = ['title', 'billing_id', 'description', 'amount'];
    protected $migrationOrder = 1;
    protected $table = "isp_billing_item";

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
        $table->foreign('billing_id')->references('id')->on('isp_connection')->nullOnDelete();
        $table->string('description')->nullable();
        $table->double('amount', 8, 2)->nullable();
    }
}
