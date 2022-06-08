<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ChartOfAccount extends Model
{

    protected $fillable = ['name', 'slug'];
    public $migrationDependancy = [];
    protected $table = "account_chart_of_account";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('slug')->nullable();
    }
}
