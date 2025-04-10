<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
        'transaction_hash',
        'type',
        'status',
        'description'
    ];

    // Relation avec l'expéditeur
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relation avec le destinataire
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Relation avec la transaction blockchain
    public function blockchainTransaction()
    {
        return $this->hasOne(BlockchainTransaction::class);
    }
    // App\Models\Transaction.php

public function getTypeColorClass(): string
{
    return match ($this->type) {
        'deposit', 'transfer_in' => 'bg-green-100 text-green-800',
        'withdrawal', 'transfer_out' => 'bg-red-100 text-red-800',
        'payment' => 'bg-blue-100 text-blue-800',
        default => 'bg-gray-100 text-gray-800',
    };
}

}