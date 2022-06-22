<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class TaxAgencyDetail extends Model
{

    protected $fillable = ['agency_id', 'trn_no', 'trn_date', 'particulars', 'debit', 'credit'];
    public $migrationDependancy = ['account_tax_agency'];
    protected $table = "account_tax_agency_detail";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('agency_id')->nullable();
        $table->integer('trn_no')->nullable();
        $table->date('trn_date')->nullable();
        $table->string('particulars')->nullable();
        $table->decimal('debit', 20, 2)->default(0.00);
        $table->decimal('credit', 20, 2)->default(0.00);
    }
    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_tax_agency', 'agency_id')) {
            $table->foreign('agency_id')->references('id')->on('account_tax_agency')->nullOnDelete();
        }
    }
}
