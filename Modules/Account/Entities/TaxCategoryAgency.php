<?php

namespace Modules\Account\Entities;

use Modules\Core\Entities\BaseModel AS Model;
use Illuminate\Database\Schema\Blueprint;
use Modules\Core\Classes\Migration;

class TaxCategoryAgency extends Model
{

    protected $fillable = ['tax_id', 'component_name', 'tax_cat_id', 'agency_id', 'tax_rate'];
    public $migrationDependancy = ['account_tax', 'account_tax_agency', 'account_tax_category'];
    protected $table = "account_tax_category_agency";

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('tax_id')->nullable();
        $table->string('component_name')->nullable();
        $table->integer('tax_cat_id')->nullable();
        $table->integer('agency_id')->nullable();
        $table->decimal('tax_rate', 20, 2)->default(0.00);
    }

     
    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('account_tax', 'tax_id')) {
            $table->foreign('tax_id')->references('id')->on('account_tax')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_tax_category', 'tax_cat_id')) {
            $table->foreign('tax_cat_id')->references('id')->on('account_tax_category')->nullOnDelete();
        }

        if (Migration::checkKeyExist('account_tax_agency', 'agency_id')) {
            $table->foreign('agency_id')->references('id')->on('account_tax_agency')->nullOnDelete();
        }
    }
}
