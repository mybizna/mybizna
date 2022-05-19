<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class FinancialYear extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_financial_year";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->string('fy_name')->nullable();
        $table->integer('start_date')->nullable()->index('start_date');
        $table->integer('end_date')->nullable()->index('end_date');
        $table->string('description')->nullable();
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->timestamps();

        $table->index(['start_date', 'end_date'], 'year_search');
    }
}
