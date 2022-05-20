<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PayBillDetail extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "payment_pay_bill_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('voucher_no')->nullable();
        $table->integer('bill_no')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
