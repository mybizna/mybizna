<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ReceiptDetail extends Model
{

    protected $fillable = ['voucher_no', 'invoice_no', 'amount'];
    public $migrationDependancy = [];
    protected $table = "invoice_receipt_detail";

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
        $table->integer('invoice_no')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
    }
}
