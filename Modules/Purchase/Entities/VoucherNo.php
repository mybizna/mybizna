<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class VoucherNo extends Model
{

    protected $fillable = ['type', 'currency', 'editable'];
    protected $migrationOrder = 5;
    protected $table = "purchase_voucher_no";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('type')->nullable();
        $table->string('currency', 50)->nullable();
        $table->boolean('editable')->default(0);
    }
}
