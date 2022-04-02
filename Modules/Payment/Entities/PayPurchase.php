<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayPurchase extends Model
{

    protected $fillable = [];
    protected $table = "payment_pay_purchase";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->integer('id')->primary();
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
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
