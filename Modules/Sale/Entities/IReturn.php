<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class IReturn extends Model
{

    protected $fillable = [
        'invoice_id', 'voucher_no', 'vendor_id', 'vendor_name', 'trn_date', 'amount',
        'discount', 'discount_type', 'tax', 'reason', 'comments', 'status'
    ];
    public $migrationDependancy = [];
    protected $table = "sale_return";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {


        $table->increments('id');
        $table->integer('invoice_id');
        $table->integer('voucher_no');
        $table->integer('vendor_id')->nullable();
        $table->string('vendor_name')->nullable();
        $table->date('trn_date');
        $table->decimal('amount', 20, 2);
        $table->decimal('discount', 20, 2)->default(0.00);
        $table->string('discount_type')->nullable();
        $table->decimal('tax', 20, 2)->default(0.00);
        $table->text('reason')->nullable();
        $table->text('comments')->nullable();
        $table->integer('status')->nullable()->comment("0 means drafted, 1 means confirmed return");
    }
}
