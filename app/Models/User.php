<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'numero_telephone',
        'password',
        'solde_actuel',
        'code_parrainage',
        'bonus_inscription',
        'bonus_reclame',
        'id_parrain',
        'statut',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function parrain(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_parrain');
    }

    public function filleuls(): HasMany
    {
        return $this->hasMany(User::class, 'id_parrain');
    }

    public function parrainagesEnTantQueParrain(): HasMany
    {
        return $this->hasMany(Parrainage::class, 'parrain_id');
    }

    public function parrainageEnTantQueFilleul(): HasMany
    {
        return $this->hasMany(Parrainage::class, 'filleul_id');
    }

    public function investissements(): HasMany
    {
        return $this->hasMany(Investissement::class);
    }

    public function tachesJournalieres(): HasMany
    {
        return $this->hasMany(TacheJournaliere::class);
    }

    public function retraits(): HasMany
    {
        return $this->hasMany(Retrait::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
