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
        Schema::create('taches_journalieres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('investissement_id');
            $table->unsignedBigInteger('tache_id');
            $table->timestamp('date_attribution')->useCurrent();
            $table->timestamp('date_realisation')->nullable();
            $table->enum('statut', ['a_faire', 'completee', 'expiree'])->default('a_faire');
            $table->decimal('remuneration', 15, 2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('investissement_id')->references('id')->on('investissements')->onDelete('cascade');
            $table->foreign('tache_id')->references('id')->on('taches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches_journalieres');
    }
};
