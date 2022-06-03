<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Connection extends Model
{

    protected $fillable = ['title', 'connection_id', 'invoice_id', 'description', 'start_date', 'end_date', 'is_paid'];
    protected $migrationOrder = 6;
    protected $table = "isp_connection";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->foreign('package_id')->references('id')->on('isp_package')->nullOnDelete();
        $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();
        $table->foreign('partner_id')->references('id')->on('partner')->nullOnDelete();
        $table->string('username');
        $table->string('password');
        $table->string('username');
        $table->string('params')->nullable();
        $table->dateTime('expiry_date')->nullable();
        $table->dateTime('billing_date')->nullable();
        $table->boolean('is_paid')->default(false)->nullable();
        $table->boolean('is_setup')->default(false)->nullable();
        $table->enum('duration_type', ['new', 'active', 'inactive', 'closed'])->default('new')->nullable();
    }

/**
    connections_setupitems_ids = fields.One2many('mybizna.isp.connections_setupitems', 'connection_id',
                                                 'Setup Items',
                                                 track_visibility='onchange')

    connections_invoices_ids = fields.One2many('mybizna.isp.connections_invoices', 'connection_id',
                                               'Invoices',
                                               track_visibility='onchange')
*/
}
