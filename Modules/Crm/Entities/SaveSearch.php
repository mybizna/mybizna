<?php

namespace Modules\Crm\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class SaveSearch extends BaseModel
{

    protected $fillable = ['user_id', 'type', 'global', 'search_name', 'search_val'];
    public $migrationDependancy = [];
    protected $table = "crm_save_search";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('user_id')->nullable();
        $table->string('type')->nullable();
        $table->boolean('global')->default(0);
        $table->text('search_name')->nullable();
        $table->text('search_val')->nullable();
    }
}
