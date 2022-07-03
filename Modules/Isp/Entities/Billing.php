<?php

namespace Modules\Isp\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Billing extends Model
{

    protected $fillable = ['title', 'connection_id', 'invoice_id', 'description', 'start_date', 'end_date', 'is_paid'];
    public $migrationDependancy = ['isp_connection', 'account_invoice'];
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
        $table->integer('connection_id')->unsigned()->nullable();
        $table->integer('invoice_id')->unsigned()->nullable();
        $table->string('description')->nullable();
        $table->dateTime('start_date')->nullable();
        $table->dateTime('end_date')->nullable();
        $table->boolean('is_paid')->default(false)->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('isp_billing', 'connection_id')) {
            $table->foreign('connection_id')->references('id')->on('isp_connection')->nullOnDelete();
        }

        if (Migration::checkKeyExist('isp_billing', 'invoice_id')) {
            $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();
        }
    }
}
