<?php

namespace Modules\Hrm\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class EmployeeNote extends Model
{

    protected $fillable = ['user_id', 'comment', 'comment_by'];
    public $migrationDependancy = [];
    protected $table = "hrm_employee_note";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id')->default(0);
        $table->text('comment');
        $table->unsignedBigInteger('comment_by');
    }
}
