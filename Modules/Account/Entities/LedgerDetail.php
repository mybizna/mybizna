<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LedgerDetail extends Model
{

    protected $fillable = ['ledger_id', 'trn_no', 'particulars', 'debit', 'credit', 'trn_date'];
    public $migrationDependancy = [];
    protected $table = "account_ledger_detail";

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
        $table->integer('trn_no')->nullable();
        $table->string('particulars')->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
        $table->date('trn_date')->nullable();
    }
}
