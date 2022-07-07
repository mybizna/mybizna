<?php

namespace Modules\Partner\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Meta extends BaseModel
{

    protected $fillable = ['people_id', 'meta_key', 'meta_value'];
    public $migrationDependancy = [];
    protected $table = "partner_meta";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->bigInteger('people_id')->nullable()->index('people_id');
        $table->string('meta_key')->nullable();
        $table->longText('meta_value')->nullable();
    }
}
