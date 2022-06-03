<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ConnectionInvoice extends Model
{

    protected $fillable = ['connection_id', 'invoice_id'];
    protected $migrationOrder = 10;
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
        $table->foreign('connection_id')->references('id')->on('isp_connection')->nullOnDelete();
        $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();

}
