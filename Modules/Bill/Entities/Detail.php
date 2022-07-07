<?php

namespace Modules\Bill\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class Detail extends BaseModel
{

    protected $fillable = ['trn_no', 'ledger_id', 'particulars', 'amount'];
    public $migrationDependancy = ['account_ledger'];
    protected $table = "bill_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('trn_no')->nullable();
        $table->integer('ledger_id')->nullable();
        $table->string('particulars')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_ledger', 'ledger_id')) {
            $table->foreign('ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }
    }
}
