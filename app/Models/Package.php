<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'montant_investissement',
        'valeur_par_tache',
        'gain_journalier',
        'actif'
    ];

    public function investissements(): HasMany
    {
        return $this->hasMany(Investissement::class);
    }
}