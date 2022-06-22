<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class Tax extends Model
{

    protected $fillable = ['tax_rate_name', 'tax_number', 'default'];
    public $migrationDependancy = [];
    protected $table = "account_tax";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('tax_rate_name')->nullable();
        $table->string('tax_number', 100)->nullable();
        $table->tinyInteger('default')->nullable();
    }
}
