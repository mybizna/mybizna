<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Meta extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "partner_meta";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->bigInteger('people_id')->nullable()->index('people_id');
        $table->string('meta_key')->nullable();
        $table->longText('meta_value')->nullable();
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
    }
}
