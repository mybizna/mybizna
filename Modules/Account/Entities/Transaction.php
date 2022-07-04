<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Transaction extends Model
{

    protected $fillable = [
        'partner_id', 'from_user_id', 'payment_id', 'rate_id',
        'amount', 'description', 'type', 'level', 'token',
        'is_capped', 'is_processed', 'is_profitshare'
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
        $table->integer('payment_id');
        $table->integer('rate_id');
        $table->integer('left_ledger_id')->nullable();
        $table->integer('right_chart_of_account_id')->nullable();
        $table->integer('right_ledger_id')->nullable();
        $table->string('type')->nullable();
        $table->string('level')->nullable();
        $table->string('token')->nullable();
        $table->tinyInteger('is_capped')->nullable();
        $table->tinyInteger('is_processed')->nullable();
        $table->tinyInteger('is_profitshare')->nullable();
    }

    public function post_migration(Blueprint $table)
    {


        if (Migration::checkKeyExist('account_transaction', 'partner_id')) {
            $table->foreign('partner_id')->references('id')->on('partner')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_transaction', 'payment_id')) {
            $table->foreign('payment_id')->references('id')->on('account_payment')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_transaction', 'rate_id')) {
            $table->foreign('rate_id')->references('id')->on('account_rate')->nullOnDelete();
        }
    }
}
