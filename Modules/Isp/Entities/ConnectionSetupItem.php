<?php

namespace Modules\Isp\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class ConnectionSetupItem extends BaseModel
{

    protected $fillable = ['title', 'connection_id', 'description', 'amount'];
    public $migrationDependancy = ['isp_connection'];
    protected $table = "isp_connection_setup_item";

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
        $table->integer('connection_id')->unsigned()->nullable();
        $table->string('description')->nullable();
        $table->double('amount', 8, 2)->nullable();
    }


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('isp_connection_setup_item', 'connection_id')) {
            $table->foreign('connection_id')->references('id')->on('isp_connection')->nullOnDelete();
        }
    }
}
