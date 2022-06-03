<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class BillingCycle extends Model
{

    protected $fillable = ['title', 'description', 'duration', 'duration_type', 'published'];
    protected $migrationOrder = 5;
    protected $table = "isp_billing_cycle";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('title');
        $table->string('description')->nullable();
        $table->string('duration')->nullable();
        $table->enum('duration_type', ['days', 'weeks', 'months'])->nullable();
        $table->boolean('published')->default(true)->nullable();
    }
}
