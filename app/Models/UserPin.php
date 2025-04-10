<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pin_hash',
    ];

    /**
     * Get the user that owns the PIN.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
