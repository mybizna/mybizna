<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class UnitSetup extends Model
{

    protected $fillable = ['title', 'unit_id', 'amount'];
    protected $migrationOrder = 10;
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
        $table->foreign('unit_id')->references('id')->on('realestate_unit')->nullOnDelete();
        $table->double('amount', 8, 2)->nullable();
    }
}
