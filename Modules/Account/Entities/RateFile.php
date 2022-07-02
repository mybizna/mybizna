<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class RateFile extends Model
{

    protected $fillable = [
        'rate_id', 'year', 'month', 'token', 'type', 'max_limit', 'file', 'is_processed'
    ];
    public $migrationDependancy = [];
    protected $table = "account_rate_file";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('rate_id');
        $table->string('year');
        $table->string('month');
        $table->string('token');
        $table->string('type');
        $table->integer('max_limit');
        $table->string('file');
        $table->tinyInteger('is_processed')->nullable();
    }
}
