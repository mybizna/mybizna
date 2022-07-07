<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class InvoiceStatus extends BaseModel
{

    protected $fillable = ['type_name', 'slug'];
    public $migrationDependancy = [];
    protected $table = "account_invoice_status";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('type_name')->nullable();
        $table->string('slug')->nullable();

    }

}
