<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class RateDisallowedin extends Model
{

    protected $fillable = ['country_id', 'rate_id'];
    public $migrationDependancy = [];
    protected $table = "account_rate_disallowedin";

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
        $table->integer('rate_id');
    }
}
