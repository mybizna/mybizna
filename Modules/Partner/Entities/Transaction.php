<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Transaction extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "partner_transaction";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {

        $table->integer('id')->primary();
        $table->string('people_id')->nullable();
        $table->integer('voucher_no')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->date('trn_date')->nullable();
        $table->string('trn_by')->nullable();
        $table->string('particulars')->nullable();
        $table->string('voucher_type')->nullable();
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}
