<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class OpeningBalance extends Model
{

    protected $fillable = ['financial_year_id', 'chart_id', 'ledger_id', 'type', 'debit', 'credit'];
    public $migrationDependancy = ['account_ledger', 'account_chart_of_account', 'account_financial_year'];
    protected $table = "account_opening_balance";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('financial_year_id')->nullable();
        $table->integer('chart_id')->nullable();
        $table->integer('ledger_id')->nullable();
        $table->string('type', 50)->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_opening_balance', 'financial_year_id')) {
            $table->foreign('financial_year_id')->references('id')->on('account_financial_year')->nullOnDelete();
        }
        if (Migration::checkKeyExist('account_opening_balance', 'chart_id')) {
            $table->foreign('chart_id')->references('id')->on('account_chart_of_account')->nullOnDelete();
        }
        if (Migration::checkKeyExist('account_opening_balance', 'ledger_id')) {
            $table->foreign('ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }
    }
}
