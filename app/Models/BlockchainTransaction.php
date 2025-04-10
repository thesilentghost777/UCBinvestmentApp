<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BlockchainTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'transaction_hash',
        'block_hash',
        'block_number',
        'from_address',
        'to_address',
        'amount',
        'gas_price',
        'gas_used',
        'nonce',
        'status',           // 'pending', 'processing', 'confirmed', 'failed', 'dropped'
        'network_name',     // ex: 'Ethereum', 'Binance Smart Chain', etc.
        'network_fee',
        'confirmations',
        'failure_reason',
        'initiated_at',
        'processed_at',
    ];

    protected $casts = [
        'initiated_at' => 'datetime',
        'processed_at' => 'datetime',
        'amount' => 'decimal:2',
        'gas_price' => 'decimal:18',
        'network_fee' => 'decimal:2',
    ];

    public function blockchainTransaction()
{
    return $this->hasOne(BlockchainTransaction::class, 'transaction_id');
}

    /**
     * Get the transaction that owns the blockchain transaction.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Determine if the transaction is pending.
     */
    public function isPending(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Determine if the transaction is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Determine if the transaction has failed.
     */
    public function hasFailed(): bool
    {
        return in_array($this->status, ['failed', 'dropped']);
    }

    /**
     * Get transaction age in a human readable format.
     */
    public function getAgeAttribute(): string
    {
        return $this->initiated_at->diffForHumans();
    }

    /**
     * Get transaction processing time in seconds.
     */
    public function getProcessingTimeAttribute(): ?int
    {
        if ($this->processed_at && $this->initiated_at) {
            return $this->initiated_at->diffInSeconds($this->processed_at);
        }

        return null;
    }

    /**
     * Get the transaction fee in ETH if available.
     */
    public function getTransactionFeeAttribute(): ?float
    {
        if ($this->gas_used && $this->gas_price) {
            return $this->gas_used * $this->gas_price;
        }

        return null;
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        switch ($this->status) {
            case 'pending':
                return '<span class="badge bg-warning text-dark">En attente</span>';
            case 'processing':
                return '<span class="badge bg-info">En cours</span>';
            case 'confirmed':
                return '<span class="badge bg-success">Confirmée</span>';
            case 'failed':
                return '<span class="badge bg-danger">Échouée</span>';
            case 'dropped':
                return '<span class="badge bg-secondary">Abandonnée</span>';
            default:
                return '<span class="badge bg-light">Inconnu</span>';
        }
    }
    public function getStatusMessage(): string
    {
        switch ($this->status) {
            case 'pending':
                return 'Transaction is pending.';
            case 'processing':
                return 'Transaction is being processed.';
            case 'confirmed':
                return 'Transaction is confirmed.';
            case 'failed':
                return 'Transaction has failed.';
            case 'dropped':
                return 'Transaction has been dropped.';
            default:
                return 'Unknown status.';
        }
}
}