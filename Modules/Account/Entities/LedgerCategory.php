<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LedgerCategory extends Model
{

    protected $fillable = ['name', 'slug', 'chart_id', 'parent_id', 'system'];
    protected $migrationOrder = 5;
    protected $table = "account_ledger_category";

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
        $table->integer('chart_id')->nullable();
        $table->integer('parent_id')->nullable();
        $table->tinyInteger('system')->nullable();
    }
}
