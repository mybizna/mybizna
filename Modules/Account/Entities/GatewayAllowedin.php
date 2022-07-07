<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class GatewayAllowedin extends BaseModel
{

    protected $fillable = ['country_id', 'gateway_id'];
    public $migrationDependancy = ['core_country', 'account_gateway'];
    protected $table = "account_gateway_allowedin";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('country_id');
        $table->integer('gateway_id');
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_gateway_disallowedin', 'country_id')) {
            $table->foreign('country_id')->references('id')->on('core_country')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_gateway_disallowedin', 'gateway_id')) {
            $table->foreign('gateway_id')->references('id')->on('account_gateway')->nullOnDelete();
        }
    }
}
