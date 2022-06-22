<?php

namespace Modules\Hrm\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class Holiday extends Model
{

    protected $fillable = ['title', 'start', 'end', 'description', 'range_status'];
    public $migrationDependancy = [];
    protected $table = "hrm_holiday";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->string('title', 200);
        $table->timestamp('start')->useCurrent();
        $table->timestamp('end')->nullable()->default(null);;
        $table->text('description');
        $table->string('range_status', 5);
    }
}
