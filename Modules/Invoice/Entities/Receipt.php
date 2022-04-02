<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Receipt extends Model
{

    protected $fillable = [];
    protected $table = "invoice_receipt";

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
        $table->integer('customer_id')->nullable();
        $table->string('customer_name')->nullable();
        $table->date('trn_date')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->decimal('transaction_charge', 20, 2)->default(0.00);
        $table->string('ref')->nullable();
        $table->string('particulars')->nullable();
        $table->string('attachments')->nullable();
        $table->integer('status')->nullable();
        $table->string('trn_by')->nullable();
        $table->integer('trn_by_ledger_id')->nullable();
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
