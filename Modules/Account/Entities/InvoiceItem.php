<?php

namespace Modules\Invoice\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class InvoiceItem extends BaseModel
{

    protected $fillable = [
        'invoice_id', 'transaction_id', 'amount', 'description', 'quantity',
    ];
    public $migrationDependancy = ['account_invoice', 'account_transaction'];
    protected $table = "account_invoice_item";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('invoice_id');
        $table->integer('transaction_id')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('description')->nullable();
        $table->integer('quantity')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_invoice_item', 'invoice_id')) {
            $table->foreign('invoice_id')->references('id')->on('account_invoice')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_invoice_item', 'transaction_id')) {
            $table->foreign('transaction_id')->references('id')->on('account_transaction')->nullOnDelete();
        }
    }
}
