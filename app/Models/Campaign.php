<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scripts(): HasMany
    {
        return $this->hasMany(Script::class, 'id_campaign');
    }

    public function objections(): HasMany
    {
        return $this->hasMany(Objection::class, 'id_campaign');
    }

    public function anagraphics(): HasMany
    {
        return $this->hasMany(Anagraphic::class, 'id_campaign');
    }
public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_campaign');
    }
}
