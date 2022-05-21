<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CashAtBank extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "account_cash_at_bank";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('ledger_id')->nullable();
        $table->string('name')->nullable();
        $table->decimal('balance', 20, 2)->default(0.00);
    }
}
