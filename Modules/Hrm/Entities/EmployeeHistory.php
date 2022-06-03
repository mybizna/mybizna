<?php

namespace Modules\Hrm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class EmployeeHistory extends Model
{

    protected $fillable = ['user_id', 'module', 'category', 'type', 'comment', 'data', 'date'];
    protected $migrationOrder = 10;
    protected $table = "hrm_employee_history";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->unsignedBigInteger('user_id')->default(0)->index('user_id');
        $table->string('module', 20)->nullable()->index('module');
        $table->string('category', 20)->nullable();
        $table->string('type', 20)->nullable();
        $table->text('comment')->nullable();
        $table->longText('data')->nullable();
        $table->dateTime('date');
    }
}
