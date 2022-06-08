<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayPurchase extends Model
{

    protected $fillable = [
        'voucher_no', 'vendor_id', 'vendor_name', 'trn_date', 'amount',
        'trn_by', 'transaction_charge', 'ref', 'trn_by_ledger_id',
        'particulars', 'attachments', 'status'
    ];
    public $migrationDependancy = [];
    protected $table = "payment_pay_purchase";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->increments('id');
        $table->integer('voucher_no')->nullable();
        $table->integer('vendor_id')->nullable();
        $table->string('vendor_name')->nullable();
        $table->date('trn_date')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('trn_by')->nullable();
        $table->decimal('transaction_charge', 20, 2)->default(0.00);
        $table->string('ref')->nullable();
        $table->integer('trn_by_ledger_id')->nullable();
        $table->string('particulars')->nullable();
        $table->string('attachments')->nullable();
        $table->integer('status')->nullable();
    }
}
