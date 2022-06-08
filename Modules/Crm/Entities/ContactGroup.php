<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ContactGroup extends Model
{

    protected $fillable = ['name', 'description', 'private'];
    public $migrationDependancy = [];
    protected $table = "crm_contact_group";

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
        $table->text('description')->nullable();
        $table->tinyInteger('private')->nullable();
    }
}
