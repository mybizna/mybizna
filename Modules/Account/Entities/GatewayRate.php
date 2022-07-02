<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class GatewayRate extends Model
{

    protected $fillable = ['gateway_id', 'rate_id'];
    public $migrationDependancy = [];
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
}
