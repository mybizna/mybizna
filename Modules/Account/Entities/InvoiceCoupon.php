<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class InvoiceCoupon extends Model
{

    protected $fillable = ['payment_id', 'coupon_id'];
    public $migrationDependancy = ['account_payment', 'account_coupon'];
    protected $table = "account_invoice_coupon";

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

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_invoice_coupon', 'payment_id')) {
            $table->foreign('payment_id')->references('id')->on('account_payment')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_invoice_coupon', 'coupon_id')) {
            $table->foreign('coupon_id')->references('id')->on('account_coupon')->nullOnDelete();
        }
    }
}
