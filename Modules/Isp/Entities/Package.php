<?php

namespace Modules\Isp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Package extends Model
{

    protected $fillable = ['title', 'description', 'gateway_id', 'billing_cycle_id', 'speed', 'speed_type', 'published', 'amount'];
    protected $migrationOrder = 2;
    protected $table = "isp_billing_cycle";

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
        $table->foreign('gateway_id')->references('id')->on('isp_gateway')->nullOnDelete();
        $table->foreign('billing_cycle_id')->references('id')->on('isp_billing_cycle')->nullOnDelete();
        $table->string('speed')->nullable();
        $table->enum('speed_type', ['kilobyte', 'megabyte'])->default('megabyte')->nullable();
        $table->boolean('published')->default(true)->nullable();
        $table->double('amount', 8, 2)->nullable();
    }


    /*packages_setupitems_ids = fields.One2many('mybizna.isp.packages_setupitems', 'package_id',
                                              'Package Setup Items',
                                              track_visibility='onchange')*/
}
