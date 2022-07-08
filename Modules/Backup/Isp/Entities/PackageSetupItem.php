<?php

namespace Modules\Isp\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Base\Classes\Migration;

class PackageSetupItem extends BaseModel
{

    protected $fillable = ['title', 'description', 'package_id', 'amount', 'published'];
    public $migrationDependancy = ['isp_package'];
    protected $table = "isp_package_setup_item";

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
        $table->integer('package_id')->unsigned()->nullable();
        $table->double('amount', 8, 2)->nullable();
        $table->boolean('published')->default(true)->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('isp_package_setup_item', 'package_id')) {
            $table->foreign('package_id')->references('id')->on('isp_package')->nullOnDelete();
        }
    }
}
