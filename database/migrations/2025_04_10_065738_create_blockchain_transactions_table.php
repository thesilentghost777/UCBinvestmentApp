<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blockchain_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->string('transaction_hash', 66)->unique()->index();
            $table->string('block_hash', 66)->nullable();
            $table->unsignedBigInteger('block_number')->nullable();
            $table->string('from_address', 42);
            $table->string('to_address', 42);
            $table->decimal('amount', 20, 2);
            $table->decimal('gas_price', 38, 18)->nullable()->comment('In ETH');
            $table->unsignedInteger('gas_used')->nullable();
            $table->unsignedInteger('nonce');
            $table->enum('status', ['pending', 'processing', 'confirmed', 'failed', 'dropped'])->default('pending');
            $table->string('network_name')->default('Ethereum');
            $table->decimal('network_fee', 20, 2)->comment('In XAF');
            $table->unsignedInteger('confirmations')->default(0);
            $table->text('failure_reason')->nullable();
            $table->timestamp('initiated_at');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blockchain_transactions');
    }
};