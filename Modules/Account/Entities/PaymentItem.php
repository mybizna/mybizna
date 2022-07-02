<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class PaymentItem extends Model
{

    protected $fillable = [
        'payment_id', 'amount', 'description', 'quantity', 'source_ident', 'source_id'
    ];
    public $migrationDependancy = [];
    protected $table = "account_payment_item";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('payment_id');
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('description')->nullable();
        $table->integer('quantity')->nullable();
        $table->string('source_ident')->nullable();
        $table->integer('source_id')->nullable();
    }
}
