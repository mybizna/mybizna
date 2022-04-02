<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class SaveSearch extends Model
{

    protected $fillable = [];
    protected $table = "crm_save_search";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->integer('user_id')->nullable();
        $table->string('type')->nullable();
        $table->boolean('global')->default(0);
        $table->text('search_name')->nullable();
        $table->text('search_val')->nullable();
        $table->timestamps();
    }
}
