<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class Ledger extends BaseModel
{

    protected $fillable = ['chart_id', 'category_id', 'name', 'slug', 'code', 'unused', 'system'];
    public $migrationDependancy = ['account_chart_of_account', 'account_ledger_category'];
    protected $table = "account_ledger";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('chart_id')->nullable();
        $table->integer('category_id')->nullable();
        $table->string('name')->nullable();
        $table->string('slug')->nullable();
        $table->integer('code')->nullable();
        $table->tinyInteger('unused')->nullable();
        $table->tinyInteger('system')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_ledger', 'chart_id')) {
            $table->foreign('chart_id')->references('id')->on('account_chart_of_account')->nullOnDelete();
        }
        if (Migration::checkKeyExist('account_ledger', 'category_id')) {
            $table->foreign('category_id')->references('id')->on('account_ledger_category')->nullOnDelete();
        }
    }
}
