<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TaxPay extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "account_tax_pay";

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
        $table->date('trn_date')->nullable();
        $table->string('particulars')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('voucher_type')->nullable();
        $table->integer('trn_by')->nullable();
        $table->integer('agency_id')->nullable();
        $table->integer('ledger_id')->nullable();
    }
}
