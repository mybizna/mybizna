<?php

namespace Modules\Hrm\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;

class Education extends BaseModel
{

    protected $fillable = [
        'employee_id', 'school', 'degree', 'field', 'result', 'result_type',
        'finished', 'notes', 'interest'
    ];
    public $migrationDependancy = [];
    protected $table = "hrm_education";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->unsignedInteger('employee_id')->nullable()->index('employee_id');
        $table->string('school', 100)->nullable();
        $table->string('degree', 100)->nullable();
        $table->string('field', 100)->nullable();
        $table->string('result', 50)->nullable();
        $table->enum('result_type', ['grade', 'percentage'])->nullable();
        $table->unsignedInteger('finished')->nullable();
        $table->text('notes')->nullable();
        $table->text('interest')->nullable();
    }
}
