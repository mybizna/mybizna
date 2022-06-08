<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CompanyLocation extends Model
{

    protected $table = "base_company_location";

    public $migrationDependancy = [];

    protected $fillable = [
        'company_id', 'name', 'address_1', 'address_2', 'city', 'state',
        'zip', 'country', 'fax', 'phone'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_by', 'updated_by', 'deleted_at'];

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->unsignedInteger('company_id')->nullable()->index('company_id');
        $table->string('name')->nullable();
        $table->string('address_1')->nullable();
        $table->string('address_2')->nullable();
        $table->string('city', 100)->nullable();
        $table->string('state', 100)->nullable();
        $table->integer('zip')->nullable();
        $table->string('country', 5)->nullable();
        $table->string('fax', 20)->nullable();
        $table->string('phone', 20)->nullable();
    }
}
