<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Gateway extends BaseModel
{

    protected $fillable = [
        'title', 'slug', 'currency_id', 'image', 'url',
        'ordering', 'is_default', 'is_hidden', 'published'

    ];
    public $migrationDependancy = ['core_currency'];
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


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_gateway', 'currency_id')) {
            $table->foreign('currency_id')->references('id')->on('core_currency')->nullOnDelete();
        }
    }
}
