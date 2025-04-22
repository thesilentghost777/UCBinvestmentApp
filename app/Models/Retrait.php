<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retrait extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'montant',
        'date_demande',
        'date_validation',
        'numero_reception',
        'statut'
    ];

    protected $casts = [
        'date_demande' => 'datetime',
        'date_validation' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
