<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class EmployeeNote extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "hrm_employee_note";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedBigInteger('id')->primary();
        $table->unsignedBigInteger('user_id')->default(0);
        $table->text('comment');
        $table->unsignedBigInteger('comment_by');
        $table->timestamps();
    }
}
