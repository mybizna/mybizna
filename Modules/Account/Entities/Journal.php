<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Journal extends Model
{

    protected $fillable = ['transaction_id', 'debit', 'credit', 'note', 'particulars'];
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
        $table->integer('transaction_id')->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
        $table->string('note')->nullable();
        $table->string('particulars')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_journal', 'transaction_id')) {
            $table->foreign('transaction_id')->references('id')->on('account_transaction')->nullOnDelete();
        }
    }
}
