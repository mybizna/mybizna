<?php

namespace Modules\Invoice\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class InvoiceCoupon extends Model
{

    protected $fillable = [
        'code', 'description', 'value', 'amount', 'start_amount', 'end_amount',
        'start_date', 'end_date', 'applied', 'is_percent',  'published', 'is_visible'
    ];
    public $migrationDependancy = [];
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
        $table->string('code')->nullable();
        $table->string('description')->nullable();
        $table->string('value')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->decimal('start_amount', 20, 2)->default(0.00);
        $table->decimal('end_amount', 20, 2)->default(0.00);
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->string('applied')->nullable();
        $table->tinyInteger('is_percent')->nullable();
        $table->tinyInteger('published')->nullable();
        $table->tinyInteger('is_visible')->nullable();
    }
}
