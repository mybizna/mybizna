<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class Journal extends Model
{

    protected $fillable = ['transaction_date', 'debit', 'credit', 'note', 'particulars'];
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
        $table->date('transaction_date')->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
        $table->string('note')->nullable();
        $table->string('particulars')->nullable();
    }
}
