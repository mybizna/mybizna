<?php

namespace Modules\Isp\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Connection extends Model
{

    protected $fillable = ['package_id', 'partner_id', 'invoice_id', 'username', 'password', 'params', 'expiry_date', 'billing_date', 'is_paid', 'is_setup', 'status'];
    public $migrationDependancy = ['isp_package', 'invoice', 'partner'];
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
        $table->string('username');
        $table->string('password');
        $table->integer('package_id')->unsigned()->nullable();
        $table->integer('invoice_id')->unsigned()->nullable();
        $table->integer('partner_id')->unsigned()->nullable();
        $table->string('params')->nullable();
        $table->dateTime('expiry_date')->nullable();
        $table->dateTime('billing_date')->nullable();
        $table->boolean('is_paid')->default(false)->nullable();
        $table->boolean('is_setup')->default(false)->nullable();
        $table->enum('status', ['new', 'active', 'inactive', 'closed'])->default('new')->nullable();
    }


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('isp_package', 'package_id')) {
            $table->foreign('package_id')->references('id')->on('isp_package')->nullOnDelete();
        }
        if (Migration::checkKeyExist('invoice', 'invoice_id')) {
            $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();
        }
        if (Migration::checkKeyExist('partner', 'partner_id')) {
            $table->foreign('partner_id')->references('id')->on('partner')->nullOnDelete();
        }
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
