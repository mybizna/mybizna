<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class TaxPay extends Model
{

    protected $fillable = ['voucher_no', 'trn_date', 'particulars', 'amount', 'voucher_type', 'trn_by', 'agency_id', 'ledger_id'];
    public $migrationDependancy = ['account_tax_agency', 'account_ledger'];
    protected $table = "account_tax_pay";

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
        $table->date('trn_date')->nullable();
        $table->string('particulars')->nullable();
        $table->decimal('amount', 20, 2)->default(0.00);
        $table->string('voucher_type')->nullable();
        $table->integer('trn_by')->nullable();
        $table->integer('agency_id')->nullable();
        $table->integer('ledger_id')->nullable();
    }
    
    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_tax_agency', 'agency_id')) {
            $table->foreign('agency_id')->references('id')->on('account_tax_agency')->nullOnDelete();
        }
        if (Migration::checkKeyExist('account_ledger', 'ledger_id')) {
            $table->foreign('ledger_id')->references('id')->on('account_ledger')->nullOnDelete();
        }
    }
}
