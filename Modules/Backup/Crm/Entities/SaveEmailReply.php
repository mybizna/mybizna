<?php

namespace Modules\Crm\Entities;

use Modules\Base\Entities\BaseModel
;
use Illuminate\Database\Schema\Blueprint;

class SaveEmailReply extends BaseModel
{

    protected $fillable = ['name', 'subject', 'template'];
    public $migrationDependancy = [];
    protected $table = "crm_save_email_reply";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->text('name')->nullable();
        $table->text('subject')->nullable();
        $table->longText('template')->nullable();
    }
}
