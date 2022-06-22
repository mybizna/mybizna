<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class TaxCategory extends Model
{

    protected $fillable = ['name', 'description'];
    public $migrationDependancy = [];
    protected $table = "account_tax_category";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name', 100)->nullable();
        $table->string('description')->nullable();
    }
}
