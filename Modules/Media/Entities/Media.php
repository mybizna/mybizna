<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $fillable = ['name'];
    protected $migrationOrder = 5;
    protected $table = "media";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name');
    }

}
