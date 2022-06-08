<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class FinancialYear extends Model
{

    protected $fillable = ['fy_name', 'start_date', 'end_date', 'description'];
    public $migrationDependancy = [];
    protected $table = "hrm_financial_year";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('fy_name')->nullable();
        $table->integer('start_date')->nullable()->index('start_date');
        $table->integer('end_date')->nullable()->index('end_date');
        $table->string('description')->nullable();

        $table->index(['start_date', 'end_date'], 'year_search');
    }
}
