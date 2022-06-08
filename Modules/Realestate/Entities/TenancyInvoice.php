<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Classes\Migration;

class TenancyInvoice extends Model
{

    protected $fillable = ['title', 'tenancy_id', 'invoice_id',  'billing_period'];
    public $migrationDependancy = ['realestate_tenancy','invoice'];
    protected $table = "realestate_tenancy_invoice";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->increments('id');
        $table->integer('tenancy_id')->unsigned()->nullable();
        $table->integer('invoice_id')->unsigned()->nullable();
        $table->char('billing_period', 20)->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('realestate_tenancy', 'tenancy_id')) {
            $table->foreign('tenancy_id')->references('id')->on('realestate_tenancy')->nullOnDelete();
        }
        if (Migration::checkKeyExist('invoice', 'invoice_id')) {
            $table->foreign('invoice_id')->references('id')->on('invoice')->nullOnDelete();
        }
    }
}
