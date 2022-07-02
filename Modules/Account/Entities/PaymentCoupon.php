<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class PaymentCoupon extends Model
{

    protected $fillable = ['payment_id', 'coupon_id'];
    public $migrationDependancy = [];
    protected $table = "account_payment_coupon";

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
        $table->integer('coupon_id');
    }
}
