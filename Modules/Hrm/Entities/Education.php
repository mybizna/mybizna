<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Education extends Model
{

    protected $fillable = [];
    protected $table = "hrm_education";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->unsignedInteger('employee_id')->nullable()->index('employee_id');
        $table->string('school', 100)->nullable();
        $table->string('degree', 100)->nullable();
        $table->string('field', 100)->nullable();
        $table->string('result', 50)->nullable();
        $table->enum('result_type', ['grade', 'percentage'])->nullable();
        $table->unsignedInteger('finished')->nullable();
        $table->text('notes')->nullable();
        $table->text('interest')->nullable();
        $table->timestamps();
    }
}
