<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Billing extends Model
{

    protected $fillable = ['title', 'connection_id', 'invoice_id', 'description', 'start_date', 'end_date', 'is_paid'];
    protected $migrationOrder = 5;
    protected $table = "isp_billing";

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
        $table->foreign('connection_id')->references('id')->on('isp_connection')->nullOnDelete();
        $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();
        $table->string('description')->nullable();
        $table->dateTime('start_date')->nullable();
        $table->dateTime('end_date')->nullable();
        $table->boolean('is_paid')->default(false)->nullable();
    }

    /**
     *     billing_items_ids = fields.One2many('mybizna.isp.billing_items', 'billing_id',
                                        'Billing Items',
                                        track_visibility='onchange')
     */
}
