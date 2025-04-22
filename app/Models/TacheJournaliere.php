<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TacheJournaliere extends Model
{
    use HasFactory;

    protected $table = 'taches_journalieres';

    protected $fillable = [
        'user_id',
        'tache_id',
        'investissement_id',
        'date',
        'statut',
        'date_realisation',
        'remuneration',
    ];

    protected $casts = [
        'date' => 'date',
        'date_realisation' => 'datetime',
    ];

    /**
     * Obtenir la tâche associée à cette tâche journalière
     */
    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }

    /**
     * Obtenir l'utilisateur associé à cette tâche journalière
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir l'investissement associé à cette tâche journalière
     */
    public function investissement()
    {
        return $this->belongsTo(Investissement::class);
    }

    public function getStatutBadgeClass(): string
    {
        return match($this->statut) {
            'completee' => 'bg-green-100 text-green-800',
            'a_faire' => 'bg-yellow-100 text-yellow-800',
            'expiree' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatutLabel(): string
    {
        return match($this->statut) {
            'completee' => 'Complétée',
            'a_faire' => 'À faire',
            'expiree' => 'Expirée',
            default => 'Inconnue'
        };
    }

    public function isExpired(): bool
    {
        return $this->statut === 'expiree' ||
            ($this->statut === 'a_faire' && $this->date_attribution->addDay()->isPast());
    }

    public function getTimeLeftFormatted(): string
    {
        if ($this->statut !== 'a_faire') {
            return '-';
        }

        $expiration = $this->date_attribution->copy()->addDay();
        $now = Carbon::now();

        if ($now > $expiration) {
            return 'Expirée';
        }

        $diffInHours = $now->diffInHours($expiration);
        $diffInMinutes = $now->diffInMinutes($expiration) % 60;

        return "{$diffInHours}h {$diffInMinutes}m";
    }

    public function getRemunerationFormatted(): string
    {
        return number_format($this->remuneration, 0, ',', ' ') . ' XAF';
    }
}
