<?php

namespace Modules\Isp\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class BillingItem extends Model
{

    protected $fillable = ['title', 'billing_id', 'description', 'amount'];
    public $migrationDependancy = ['isp_connection'];
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
        $table->integer('billing_id')->unsigned()->nullable();
        $table->string('description')->nullable();
        $table->double('amount', 8, 2)->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('isp_connection', 'billing_id')) {
            $table->foreign('billing_id')->references('id')->on('isp_connection')->nullOnDelete();
        }
    }
}
