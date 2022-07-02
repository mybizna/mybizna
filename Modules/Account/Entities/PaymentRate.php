<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class PaymentRate extends Model
{

    protected $fillable = ['payment_id', 'rate_id'];
    public $migrationDependancy = [];
    protected $table = "account_payment_rate";

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
        $table->integer('rate_id');
    }
}
