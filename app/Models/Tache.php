<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'lien',
        'description',
        'statut'
    ];

    public function tachesJournalieres(): HasMany
    {
        return $this->hasMany(TacheJournaliere::class);
    }

    public function getTypeEmoji(): string
    {
        return match($this->type) {
            'youtube' => '📺',
            'tiktok' => '📱',
            'facebook' => '👍',
            'instagram' => '📷',
            'autre' => '🔗',
            default => '📝'
        };
    }

    public function getTypeBadgeClass(): string
    {
        return match($this->type) {
            'youtube' => 'bg-red-100 text-red-800',
            'tiktok' => 'bg-black text-white',
            'facebook' => 'bg-blue-100 text-blue-800',
            'instagram' => 'bg-purple-100 text-purple-800',
            'autre' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}