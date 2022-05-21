<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Ledger extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "account_ledger";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('chart_id')->nullable();
        $table->integer('category_id')->nullable();
        $table->string('name')->nullable();
        $table->string('slug')->nullable();
        $table->integer('code')->nullable();
        $table->tinyInteger('unused')->nullable();
        $table->tinyInteger('system')->nullable();
    }
}
