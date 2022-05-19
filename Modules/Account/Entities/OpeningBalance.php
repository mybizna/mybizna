<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class OpeningBalance extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "account_opening_balance";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->integer('financial_year_id')->nullable();
        $table->integer('chart_id')->nullable();
        $table->integer('ledger_id')->nullable();
        $table->string('type', 50)->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
