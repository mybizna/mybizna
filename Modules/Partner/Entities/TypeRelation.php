<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TypeRelation extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "partner_type_relation";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedBigInteger('id')->primary();
        $table->unsignedBigInteger('people_id')->nullable()->index('people_id');
        $table->unsignedInteger('people_types_id')->nullable()->index('people_types_id');
        $table->dateTime('deleted_at')->nullable();
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
    }
}
