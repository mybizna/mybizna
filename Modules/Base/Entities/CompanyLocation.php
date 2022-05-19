<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CountryLocation extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "base_country_location";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
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
        $table->timestamps();
    }


}
