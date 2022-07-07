<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Invoice extends BaseModel
{

    protected $fillable = [
        'partner_id', 'description', 'status', 'completed', 'successful'
    ];
    public $migrationDependancy = ['partner'];
    protected $table = "account_invoice";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('partner_id');
        $table->string('description')->nullable();
        $table->enum('status', ['draft', 'pending', 'partial', 'paid', 'closed', 'void'])->default('draft')->nullable();
        $table->tinyInteger('completed')->nullable();
        $table->tinyInteger('successful')->nullable();
    }


    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_invoice', 'partner_id')) {
            $table->foreign('partner_id')->references('id')->on('partner')->nullOnDelete();
        }
    }
}
