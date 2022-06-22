<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class Journal extends Model
{

    protected $fillable = ['trn_date', 'ref', 'voucher_no', 'voucher_amount', 'particulars', 'attachments'];
    public $migrationDependancy = [];
    protected $table = "account_journal";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->date('trn_date')->nullable();
        $table->string('ref')->nullable();
        $table->integer('voucher_no')->nullable();
        $table->decimal('voucher_amount', 20, 2)->default(0.00);
        $table->string('particulars')->nullable();
        $table->string('attachments')->nullable();
    }
}
