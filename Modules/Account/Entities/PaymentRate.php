<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class PaymentRate extends BaseModel
{

    protected $fillable = ['payment_id', 'rate_id'];
    public $migrationDependancy = ['account_payment', 'account_rate'];
    protected $table = "account_payment_rate";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('payment_id');
        $table->integer('rate_id');
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_payment_rate', 'payment_id')) {
            $table->foreign('payment_id')->references('id')->on('account_payment')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_payment_rate', 'rate_id')) {
            $table->foreign('rate_id')->references('id')->on('account_rate')->nullOnDelete();
        }
    }
}
