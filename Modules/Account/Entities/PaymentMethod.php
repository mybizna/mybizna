<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class PaymentMethod extends Model
{

    protected $fillable = ['name', 'description'];
    public $migrationDependancy = [];
    protected $table = "account_payment_method";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('description')->nullable();
    }
}
