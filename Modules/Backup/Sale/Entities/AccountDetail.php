<?php

namespace Modules\Sale\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class AccountDetail extends BaseModel
{

    protected $fillable = [
        'sale_no', 'trn_no', 'trn_date', 'particulars', 'debit', 'credit'
    ];
    public $migrationDependancy = [];
    protected $table = "sale_account_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('sale_no')->nullable();
        $table->integer('trn_no')->nullable();
        $table->date('trn_date')->nullable();
        $table->string('particulars')->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
    }
}
