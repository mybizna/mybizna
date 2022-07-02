<?php

namespace Modules\Payment\Entities;

use Modules\Core\Entities\BaseModel as Model;
use Illuminate\Database\Schema\Blueprint;

class Transaction extends Model
{

    protected $fillable = [
        'partner_id', 'source_id', 'from_user_id', 'payment_id', 'rate_id',
        'amount', 'description', 'source_ident', 'type', 'level', 'token',
        'is_capped', 'is_processed', 'is_profitshare'
    ];
    public $migrationDependancy = [];
    protected $table = "account_transaction";

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
        $table->integer('source_id');
        $table->integer('from_user_id');
        $table->integer('payment_id');
        $table->integer('rate_id');
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('description');
        $table->integer('source_ident');
        $table->string('type')->nullable();
        $table->string('level')->nullable();
        $table->string('token')->nullable();
        $table->tinyInteger('is_capped')->nullable();
        $table->tinyInteger('is_processed')->nullable();
        $table->tinyInteger('is_profitshare')->nullable();
    }
}
