<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parrainage extends Model
{
    use HasFactory;

    protected $fillable = [
        'parrain_id',
        'filleul_id',
        'code_parrainage_utilise',
        'date_parrainage',
        'bonus_obtenu',
        'bonus_verse',
        'statut_filleul'
    ];

    protected $casts = [
        'date_parrainage' => 'datetime',
    ];

    public function parrain(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parrain_id');
    }

    public function filleul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'filleul_id');
    }
}