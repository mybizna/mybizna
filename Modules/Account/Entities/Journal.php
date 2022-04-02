<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Journal extends Model
{

    protected $fillable = [];
    protected $table = "account_journal";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->date('trn_date')->nullable();
        $table->string('ref')->nullable();
        $table->integer('voucher_no')->nullable();
        $table->decimal('voucher_amount', 20, 2)->default(0.00);
        $table->string('particulars')->nullable();
        $table->string('attachments')->nullable();
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
