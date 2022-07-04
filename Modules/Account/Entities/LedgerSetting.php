<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class LedgerSetting extends Model
{

    protected $fillable = ['title', 'slug', 'left_ledger_id', 'right_chart_of_account_id', 'right_ledger_id'];
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
        $table->string('title')->nullable();
        $table->string('slug')->nullable();
        $table->integer('left_ledger_id')->nullable();
        $table->integer('right_chart_of_account_id')->nullable();
        $table->integer('right_ledger_id')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_ledger', 'left_ledger_id')) {
            $table->foreign('left_ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_chart_of_account', 'right_chart_of_account_id')) {
            $table->foreign('right_chart_of_account_id')->references('id')->on('account_chart_of_account')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_ledger', 'right_ledger_id')) {
            $table->foreign('right_ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }
    }
}
