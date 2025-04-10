<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'private_key',
        'balance',
    ];

    /**
     * Les attributs qui doivent être cachés pour les tableaux.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'private_key',
    ];

    /**
     * Récupérer l'utilisateur propriétaire du portefeuille.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
