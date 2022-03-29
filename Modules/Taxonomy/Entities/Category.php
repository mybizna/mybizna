<?php

namespace Modules\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = "taxonomy_category";

    protected static function newFactory()
    {
        return \Modules\Taxonomy\Database\factories\CategoryFactory::new();
    }
}
