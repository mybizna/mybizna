<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class LedgerCategory extends BaseModel
{

    protected $fillable = ['name', 'slug', 'chart_id', 'parent_id', 'system'];
    public $migrationDependancy = ['account_chart_of_account'];
    protected $table = "account_ledger_category";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('slug')->nullable();
        $table->integer('chart_id')->nullable();
        $table->integer('parent_id')->nullable();
        $table->tinyInteger('system')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_ledger_category', 'chart_id')) {
            $table->foreign('chart_id')->references('id')->on('account_chart_of_account')->nullOnDelete();
        }
        if (Migration::checkKeyExist('account_ledger_category', 'parent_id')) {
            $table->foreign('parent_id')->references('id')->on('account_ledger_category')->nullOnDelete();
        }
    }
}
