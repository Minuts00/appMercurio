<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Script extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'id_subcategory',
        'responses',
        'id_campaign',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'id_subcategory');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'id_campaign');
    }
}