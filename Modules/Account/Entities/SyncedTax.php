<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;

class SyncedTax extends Model
{

    protected $fillable = ['system_id', 'sync_id', 'sync_slug', 'sync_type', 'sync_source'];
    public $migrationDependancy = [];
    protected $table = "account_synced_tax";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->bigInteger('system_id')->index('system_id');
        $table->bigInteger('sync_id')->nullable()->index('sync_id');
        $table->string('sync_slug', 100)->nullable()->index('sync_slug');
        $table->string('sync_type', 100)->nullable()->index('sync_type');
        $table->string('sync_source', 100)->nullable()->index('sync_source');
    }
}
