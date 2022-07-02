<?php

namespace Modules\Invoice\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class Invoice extends Model
{

    protected $fillable = [
        'voucher_no', 'customer_id', 'customer_name', 'trn_date', 'due_date',
        'billing_address', 'amount', 'discount', 'discount_type', 'shipping',
        'shipping_tax', 'tax', 'tax_zone_id', 'estimate', 'attachments',
        'status', 'particulars'
    ];
    public $migrationDependancy = [];
    protected $table = "invoice";

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
        $table->integer('customer_id')->nullable();
        $table->string('customer_name')->nullable();
        $table->date('trn_date')->nullable();
        $table->date('due_date')->nullable();
        $table->string('billing_address')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->decimal('discount', 20, 2)->default(0.00);
        $table->string('discount_type')->nullable();
        $table->decimal('shipping', 20, 2)->default(0.00);
        $table->decimal('shipping_tax', 20, 2)->default(0.00);
        $table->decimal('tax', 20, 2)->default(0.00);
        $table->integer('tax_zone_id')->nullable();
        $table->tinyInteger('estimate')->nullable();
        $table->string('attachments')->nullable();
        $table->integer('status')->nullable();
        $table->string('particulars')->nullable();
    }
}
