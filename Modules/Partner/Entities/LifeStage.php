<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class LifeStage extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "partner_life_stage";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->string('slug', 100)->nullable()->unique('slug');
        $table->string('title', 100)->nullable();
        $table->string('title_plural', 100)->nullable();
        $table->unsignedSmallInteger('position')->default(0);
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
    }
}
