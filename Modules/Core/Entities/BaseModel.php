<?php

namespace Modules\Core\Entities;

use Illuminate\Support\Str;

class BaseModel extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model. Copies $table in Model
     *
     * @var string
     */
    protected static string $tableName;

    /**
     * Get the table associated with the model. Copies getTable() in Model
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return static::$tableName ?? Str::snake(Str::pluralStudly(class_basename(static::class)));
    }

    /**
     * Get the table associated with the model. Overrides getTable() in Model
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this::getTableName();
    }
}
