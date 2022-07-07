<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class RateAllowedin extends BaseModel
{

    protected $fillable = ['country_id', 'rate_id'];
    public $migrationDependancy = ['base_country', 'account_rate'];
    protected $table = "account_rate_allowedin";

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

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_rate_allowedin', 'country_id')) {
            $table->foreign('country_id')->references('id')->on('base_country')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_rate_allowedin', 'rate_id')) {
            $table->foreign('rate_id')->references('id')->on('account_rate')->nullOnDelete();
        }
    }
}
