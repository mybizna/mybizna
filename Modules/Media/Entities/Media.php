<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $fillable = [];
    protected $table = "media_media";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->id();
        $table->string('name');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
    }

}
