<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class Gateway extends Model
{

    protected $fillable = [
        'title', 'slug', 'currency_id', 'image', 'url',
        'ordering', 'is_default', 'is_hidden', 'published'

    ];
    public $migrationDependancy = [];
    protected $table = "account_gateway";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('title');
        $table->string('slug');
        $table->integer('currency_id')->nullable();
        $table->string('image')->nullable();
        $table->string('url')->nullable();
        $table->integer('ordering')->nullable();
        $table->tinyInteger('is_default')->nullable();
        $table->tinyInteger('is_hidden')->nullable();
        $table->tinyInteger('published')->nullable();
    }
}
