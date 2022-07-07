<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class Transaction extends BaseModel
{

    protected $fillable = [
        'amount', 'description', 'partner_id', 'left_ledger_id',
        'right_chart_of_account_id', 'right_ledger_id', 'type', 'is_processed'
    ];
    public $migrationDependancy = ['partner', 'account_payment', 'account_rate'];
    protected $table = "account_transaction";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('description');
        $table->integer('partner_id');
        $table->integer('left_ledger_id')->nullable();
        $table->integer('right_chart_of_account_id')->nullable();
        $table->integer('right_ledger_id')->nullable();
        $table->string('type')->nullable();
        $table->tinyInteger('is_processed')->nullable();
    }

    public function post_migration(Blueprint $table)
    {

        if (Migration::checkKeyExist('account_transaction', 'partner_id')) {
            $table->foreign('partner_id')->references('id')->on('partner')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_transaction', 'left_ledger_id')) {
            $table->foreign('left_ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_transaction', 'right_chart_of_account_id')) {
            $table->foreign('right_chart_of_account_id')->references('id')->on('account_chart_of_account')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_transaction', 'right_ledger_id')) {
            $table->foreign('right_ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }
    }
}
