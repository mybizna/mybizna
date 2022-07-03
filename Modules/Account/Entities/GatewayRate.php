<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class GatewayRate extends Model
{

    protected $fillable = ['gateway_id', 'rate_id'];
    public $migrationDependancy = ['account_gateway', 'account_rate'];
    protected $table = "account_gateway_rate";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('gateway_id');
        $table->integer('rate_id');
    }


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_gateway_rate', 'gateway_id')) {
            $table->foreign('gateway_id')->references('id')->on('account_gateway')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_gateway_rate', 'rate_id')) {
            $table->foreign('rate_id')->references('id')->on('account_rate')->nullOnDelete();
        }
    }
}
