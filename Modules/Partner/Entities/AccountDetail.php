<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class AccountDetail extends Model
{

    protected $fillable = [
        'people_id', 'trn_no', 'trn_date', 'trn_by', 'voucher_type',
        'particulars', 'debit', 'credit'
    ];
    protected $migrationOrder = 5;
    protected $table = "partner_account_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('people_id')->nullable();
        $table->integer('trn_no')->nullable();
        $table->date('trn_date')->nullable();
        $table->string('trn_by')->nullable();
        $table->string('voucher_type')->nullable();
        $table->string('particulars')->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
    }
}
