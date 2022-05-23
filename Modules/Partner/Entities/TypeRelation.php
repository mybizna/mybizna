<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class TypeRelation extends Model
{

    protected $fillable = ['people_id', 'people_types_id'];
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
        $table->bigIncrements('id');
        $table->unsignedBigInteger('people_id')->nullable()->index('people_id');
        $table->unsignedInteger('people_types_id')->nullable()->index('people_types_id');
    }
}
