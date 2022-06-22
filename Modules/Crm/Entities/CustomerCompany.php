<?php

namespace Modules\Crm\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class CustomerCompany extends Model
{

    protected $fillable = ['customer_id', 'company_id'];
    public $migrationDependancy = [];
    protected $table = "crm_customer_company";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->bigInteger('customer_id')->nullable()->index('customer_id');
        $table->bigInteger('company_id')->nullable()->index('company_id');
    }
}
