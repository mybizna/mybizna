<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class Payment extends Model
{

    protected $fillable = [
        'gateway_id', 'amount', 'invoice_id', 'description', 'receipt_no',
        'code', "completed", 'successful', 'canceled'
    ];
    public $migrationDependancy = [];
    protected $table = "account_payment";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('gateway_id');
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->integer('invoice_id')->nullable();
        $table->string('description')->nullable();
        $table->string('receipt_no')->nullable();
        $table->string('code')->nullable();
        $table->tinyInteger('completed')->nullable();
        $table->tinyInteger('successful')->nullable();
        $table->tinyInteger('canceled')->nullable();
    }
}
