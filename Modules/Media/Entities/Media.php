<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Entities\BaseModel AS Model;

class Media extends Model
{

    protected $fillable = ['name'];
    public $migrationDependancy = [];
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
