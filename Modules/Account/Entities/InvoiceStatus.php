<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class TransactionStatusType extends Model
{

    protected $fillable = ['type_name', 'slug'];
    public $migrationDependancy = [];
    protected $table = "account_transaction_status_type";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('type_name')->nullable();
        $table->string('slug')->nullable();

    }

}
