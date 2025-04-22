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
        Schema::create('retraits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('montant', 15, 2);
            $table->timestamp('date_demande')->useCurrent();
            $table->timestamp('date_validation')->nullable();
            $table->string('numero_reception');
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retraits');
    }
};