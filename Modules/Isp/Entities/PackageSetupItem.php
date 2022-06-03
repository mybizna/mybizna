<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PackageSetupItem extends Model
{

    protected $fillable = ['title', 'description', 'package_id', 'amount', 'published'];
    protected $migrationOrder = 10;
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
        $table->foreign('package_id')->references('id')->on('isp_package')->nullOnDelete();
        $table->double('amount', 8, 2)->nullable();
        $table->boolean('published')->default(true)->nullable();
    }



}
