<?php

namespace Modules\Realestate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Estate extends Model
{

    protected $fillable = ['title', 'description', 'building_id','type','amount','deposit','goodwill','rooms','bathrooms', 'is_full'];
    protected $migrationOrder = 6;
    protected $table = "realestate_unit";

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
        $table->foreign('building_id')->references('id')->on('realestate_building')->nullOnDelete();
        $table->enum('type', ['single', 'bedsitter', 'one_bedroom', 'two_bedroom', 'three_bedroom', 'four_bedroom',])->default('one_bedroom');
        $table->double('amount', 8, 2)->nullable();
        $table->double('deposit', 8, 2)->nullable();
        $table->double('goodwill', 8, 2)->nullable();
        $table->string('rooms');
        $table->string('bathrooms');
        $table->boolean('is_full')->default(false)->nullable();
    }

    /**record_name = fields.Char(string='Record Name',
                              compute='_compute_record_name')

    setup_ids = fields.One2many('mybizna.realestate.unit_setup', 'unit_id',
                                'Unit Setup',
                                track_visibility='onchange')*/
}
