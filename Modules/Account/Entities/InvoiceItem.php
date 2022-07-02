<?php

namespace Modules\Invoice\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class InvoiceItem extends Model
{

    protected $fillable = [
        'invoice_id', 'amount', 'description', 'quantity',
    ];
    public $migrationDependancy = [];
    protected $table = "account_invoice_item";

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
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('description')->nullable();
        $table->integer('quantity')->nullable();
    }
}
