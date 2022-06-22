<?php

namespace Modules\Isp\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class PackageSetupItem extends Model
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
        if (Migration::checkKeyExist('isp_package', 'package_id')) {
            $table->foreign('package_id')->references('id')->on('isp_package')->nullOnDelete();
        }
    }
}
