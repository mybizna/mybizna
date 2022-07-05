<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Payment extends Model
{

    protected $fillable = [
        'gateway_id', 'amount', 'invoice_id', 'transaction_id', 'description', 'receipt_no',
        'code', "completed", 'successful', 'canceled'
    ];
    public $migrationDependancy = ['account_gateway'];
    protected $table = "account_payment";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('gateway_id');
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->integer('transaction_id')->nullable();
        $table->integer('invoice_id')->nullable();
        $table->string('description')->nullable();
        $table->string('receipt_no')->nullable();
        $table->string('code')->nullable();
        $table->tinyInteger('completed')->nullable();
        $table->tinyInteger('successful')->nullable();
        $table->tinyInteger('canceled')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_payment', 'gateway_id')) {
            $table->foreign('gateway_id')->references('id')->on('account_gateway')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_payment', 'transaction_id')) {
            $table->foreign('transaction_id')->references('id')->on('account_transaction')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_payment', 'invoice_id')) {
            $table->foreign('invoice_id')->references('id')->on('account_invoice')->nullOnDelete();
        }
    }
}
