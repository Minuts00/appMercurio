<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anagraphic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'fiscalCode',
        'identityDoc',
        'mail',
        'address',
        'POD',
        'PDR',
        'RID',
        'lightOffer',
        'gasOffer',
        'telco',
        'note',
        'boNote',
        'id_campaign',
    ];

    protected $casts = [
        'telco' => 'boolean',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'id_campaign');
    }
}