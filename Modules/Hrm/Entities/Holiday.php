<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Holiday extends Model
{

    protected $fillable = [];
    protected $table = "hrm_holiday";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedBigInteger('id')->primary();
        $table->string('title', 200);
        $table->timestamp('start')->default('current_timestamp()');
        $table->timestamp('end')->default('0000-00-00 00:00:00');
        $table->text('description');
        $table->string('range_status', 5);
        $table->timestamps();
    }
}
