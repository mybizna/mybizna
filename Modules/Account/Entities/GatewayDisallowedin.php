<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class GatewayDisallowedin extends Model
{

    protected $fillable = ['country_id', 'gateway_id'];
    public $migrationDependancy = [];
    protected $table = "account_gateway_disallowedin";

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
}
