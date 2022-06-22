<?php

namespace Modules\Hrm\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class HolidayIndv extends Model
{

    protected $fillable = ['holiday_id', 'title', 'date'];
    public $migrationDependancy = [];
    protected $table = "hrm_holiday_indv";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->integer('holiday_id')->nullable();
        $table->string('title')->nullable();
        $table->date('date')->nullable();
    }
}
