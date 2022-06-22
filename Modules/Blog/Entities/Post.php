<?php

namespace Modules\Blog\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class Post extends Model
{

    protected $fillable = ['name'];
    public $migrationDependancy = [];
    protected $table = "blog_post";

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
