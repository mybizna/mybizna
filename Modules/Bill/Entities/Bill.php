<?php

namespace Modules\Bill\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Bill extends Model
{

    protected $fillable = [];
    protected $migrationOrder = 5;
    protected $table = "bill";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->integer('id')->primary();
        $table->integer('voucher_no')->nullable();
        $table->integer('vendor_id')->nullable();
        $table->string('vendor_name')->nullable();
        $table->string('address')->nullable();
        $table->date('trn_date')->nullable();
        $table->date('due_date')->nullable();
        $table->string('ref')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('particulars')->nullable();
        $table->integer('status')->nullable();
        $table->string('attachments')->nullable();
        $table->string('created_by', 50)->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamps();
    }
}


