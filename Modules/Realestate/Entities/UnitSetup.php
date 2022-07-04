<?php

namespace Modules\Realestate\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class UnitSetup extends Model
{

    protected $fillable = ['title', 'unit_id', 'amount'];
    public $migrationDependancy = ['realestate_unit'];
    protected $table = "realestate_unit_setup";

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
        $table->integer('unit_id')->unsigned()->nullable();
        $table->double('amount', 8, 2)->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('realestate_unit_setup', 'unit_id')) {
            $table->foreign('unit_id')->references('id')->on('realestate_unit')->nullOnDelete();
        }
    }
}
