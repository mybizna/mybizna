<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Classes\Migration;

class ConnectionInvoice extends Model
{

    protected $fillable = ['connection_id', 'invoice_id'];
    public $migrationDependancy = ['isp_connection','invoice'];
    protected $table = "isp_connection_invoice";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('connection_id')->unsigned()->nullable();
        $table->integer('invoice_id')->unsigned()->nullable();
    }


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('isp_connection', 'connection_id')) {
            $table->foreign('connection_id')->references('id')->on('isp_connection')->nullOnDelete();
        }
        if (Migration::checkKeyExist('invoice', 'invoice_id')) {
            $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();
        }
    }
}
