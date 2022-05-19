<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class CustomerActivity extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "crm_customer_activity";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->unsignedInteger('id')->primary();
        $table->integer('user_id')->nullable()->index('user_id');
        $table->string('type')->nullable()->index('type');
        $table->longText('message')->nullable();
        $table->text('email_subject')->nullable();
        $table->string('log_type')->nullable()->index('log_type');
        $table->dateTime('start_date')->nullable();
        $table->dateTime('end_date')->nullable();
        $table->integer('created_by')->nullable()->index('created_by');
        $table->longText('extra')->nullable();
        $table->boolean('sent_notification')->default(0);
        $table->dateTime('done_at')->nullable();
        $table->timestamps();
    }
}
