<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class FinancialYear extends Model
{

    protected $fillable = ['name', 'start_date', 'end_date', 'description'];
    protected $migrationOrder = 5;
    protected $table = "account_financial_year";

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
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->string('description')->nullable();
    }
}
