<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Partner extends Model
{

    protected $fillable = [
        'user_id','first_name','last_name', 'company', 'email', 'phone', 'mobile', 'other', 'website',
        'fax', 'notes', 'street_1', 'street_2', 'city', 'state', 'postal_code',
        'country', 'currency', 'life_stage', 'contact_owner', 'hash'
    ];
    protected $migrationOrder = 5;
    protected $table = "partner";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->unsignedBigInteger('user_id')->default(0)->index('user_id');
        $table->string('first_name', 60)->nullable();
        $table->string('last_name', 60)->nullable();
        $table->string('type', 60)->nullable();
        $table->string('company', 60)->nullable();
        $table->string('email', 100)->nullable()->index('email');
        $table->string('phone', 20)->nullable();
        $table->string('mobile', 20)->nullable();
        $table->string('other', 50)->nullable();
        $table->string('website', 100)->nullable();
        $table->string('fax', 20)->nullable();
        $table->text('notes')->nullable();
        $table->string('street_1')->nullable();
        $table->string('street_2')->nullable();
        $table->string('city', 80)->nullable();
        $table->string('state', 50)->nullable();
        $table->string('postal_code', 10)->nullable();
        $table->string('country', 20)->nullable();
        $table->string('currency', 5)->nullable();
        $table->string('life_stage', 100)->nullable();
        $table->bigInteger('contact_owner')->nullable();
        $table->string('hash', 40)->nullable();
    }
}
