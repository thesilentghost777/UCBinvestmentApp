<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investissement extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'investissements';

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'package_id',
        'date_initiation',
        'date_validation',
        'montant',
        'numero_depot',
        'statut'
    ];

    /**
     * Les attributs à caster.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_initiation' => 'datetime',
        'date_validation' => 'datetime',
        'montant' => 'decimal:2'
    ];

    /**
     * Les valeurs par défaut pour les attributs.
     *
     * @var array
     */
    protected $attributes = [
        'statut' => 'en_attente',
    ];

    /**
     * Récupère l'utilisateur associé à cet investissement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Récupère le package associé à cet investissement.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Vérifie si l'investissement est en attente.
     *
     * @return bool
     */
    public function isEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    /**
     * Vérifie si l'investissement est validé.
     *
     * @return bool
     */
    public function isValide(): bool
    {
        return $this->statut === 'valide';
    }

    /**
     * Vérifie si l'investissement est terminé.
     *
     * @return bool
     */
    public function isTermine(): bool
    {
        return $this->statut === 'termine';
    }

    /**
     * Vérifie si l'investissement est rejeté.
     *
     * @return bool
     */
    public function isRejete(): bool
    {
        return $this->statut === 'rejete';
    }

    /**
 * Récupère les tâches journalières associées à cet investissement.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function tachesJournalieres()
{
    return $this->hasMany(TacheJournaliere::class, 'investissement_id');
}

}