<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LedgerSetting extends Model
{

    protected $fillable = ['ledger_id', 'short_code'];
    protected $migrationOrder = 5;
    protected $table = "account_ledger_setting";

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
        $table->string('short_code')->nullable();
    }
}
