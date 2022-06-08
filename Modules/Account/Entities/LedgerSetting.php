<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Classes\Migration;

class LedgerSetting extends Model
{

    protected $fillable = ['ledger_id', 'short_code'];
    public $migrationDependancy = ['account_ledger'];
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
    
    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_ledger', 'ledger_id')) {
            $table->foreign('ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }
    }
}
