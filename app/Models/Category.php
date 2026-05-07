<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'id_category');
    }

    public function scripts(): HasMany
    {
        return $this->hasMany(Script::class, 'id_category');
    }

    public function objections(): HasMany
    {
        return $this->hasMany(Objection::class, 'id_category');
    }
}