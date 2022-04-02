<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class SaveEmailRepy extends Model
{

    protected $fillable = [];
    protected $table = "crm_save_email_reply";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->text('name')->nullable();
        $table->text('subject')->nullable();
        $table->longText('template')->nullable();
    }
}
