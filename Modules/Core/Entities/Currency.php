<?php

namespace Modules\Core\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Modules\Base\Classes\Migration;

class Currency extends BaseModel
{

    /**
     * Trait to allow softdeleting of records.
     */
    use SoftDeletes;

    /**
     * Traits for managing user modification details
     */
    use Userstamps;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_by', 'updated_by', 'deleted_at'];
    public $migrationDependancy = ['core_country'];

    protected $fillable = [
        "country_id",
        "name",
        "code",
        "symbol",
        "rate",
        "buying",
        "selling",
        "published",
        "is_fetched",
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'core_currency';

    /**
     * Get the country record associated with this record.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo('Modules\Base\Entities\Country', 'country_id');
    }

    /**
     * Get the user that created the record.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that created the record.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that created the record.
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByCreatedAt($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * List of fields for managing postings.
     *
     * @param Blueprint $table
     * @return void
     */
    public function migration(Blueprint $table)
    {
        $table->increments('id');
        $table->string('name', 255);
        $table->unsignedInteger('country_id')->nullable()->default(null);
        $table->string('code', 255)->nullable()->default(null);
        $table->string('symbol', 255)->nullable()->default(null);
        $table->decimal('rate', 11, 2)->nullable()->default(null);
        $table->decimal('buying', 11, 2)->nullable()->default(null);
        $table->decimal('selling', 11, 2)->nullable()->default(null);
        $table->integer('published')->nullable()->default(0);
        $table->integer('is_fetched')->nullable()->default(0);
    }

    public function post_migration(Blueprint $table)
    {
        if (Migration::checkKeyExist('core_country', 'country_id')) {
            $table->foreign('country_id')->references('id')->on('core_country')->nullOnDelete();
        }
    }
}
