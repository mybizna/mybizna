<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TransferVoucher extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "purchase_transfer_voucher";

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
        $table->date('trn_date')->nullable();
        $table->decimal('amount', 20, 2)->nullable();
        $table->integer('ac_from')->nullable();
        $table->integer('ac_to')->nullable();
        $table->string('particulars')->nullable();
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
