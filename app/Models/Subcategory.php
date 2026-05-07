<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_category',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function scripts(): HasMany
    {
        return $this->hasMany(Script::class, 'id_subcategory');
    }

    public function objections(): HasMany
    {
        return $this->hasMany(Objection::class, 'id_subcategory');
    }
}