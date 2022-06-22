<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class CashAtBank extends Model
{

    protected $fillable = ['ledger_id', 'name', 'balance'];
    public $migrationDependancy = ['account_ledger'];
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

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_ledger', 'ledger_id')) {
            $table->foreign('ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }
    }
}
