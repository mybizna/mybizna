<?php

namespace Modules\Bill\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class Bill extends BaseModel
{

    protected $fillable = [
        'voucher_no', 'vendor_id', 'vendor_name', 'address', 'trn_date',
        'due_date', 'ref', 'amount', 'particulars', 'status', 'attachments'
    ];
    public $migrationDependancy = ['partner'];
    protected $table = "bill";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('voucher_no')->nullable();
        $table->integer('partner_id')->nullable();
        $table->string('partner_name')->nullable();
        $table->string('address')->nullable();
        $table->date('trn_date')->nullable();
        $table->date('due_date')->nullable();
        $table->string('ref')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('particulars')->nullable();
        $table->integer('status')->nullable();
        $table->string('attachments')->nullable();
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('partner', 'partner_id')) {
            $table->foreign('partner_id')->references('id')->on('partner')->nullOnDelete();
        }
    }
}
