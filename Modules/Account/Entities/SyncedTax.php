<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class SyncedTax extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "account_synced_tax";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->bigInteger('system_id')->index('system_id');
        $table->bigInteger('sync_id')->nullable()->index('sync_id');
        $table->string('sync_slug', 100)->nullable()->index('sync_slug');
        $table->string('sync_type', 100)->nullable()->index('sync_type');
        $table->string('sync_source', 100)->nullable()->index('sync_source');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
    }
}
