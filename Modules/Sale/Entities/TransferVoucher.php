<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TransferVoucher extends Model
{

    protected $fillable = ['voucher_no', 'trn_date', 'amount', 'ac_from', 'ac_to', 'particulars'];
    public $migrationDependancy = [];
    protected $table = "sale_transfer_voucher";

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
        $table->decimal('amount', 20, 2)->nullable();
        $table->integer('ac_from')->nullable();
        $table->integer('ac_to')->nullable();
        $table->string('particulars')->nullable();
    }
}
