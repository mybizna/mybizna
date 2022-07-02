<?php

namespace Modules\Invoice\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class Invoice extends Model
{

    protected $fillable = [
        'partner_id', 'description', 'status', 'completed', 'successful'
    ];
    public $migrationDependancy = [];
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
}
