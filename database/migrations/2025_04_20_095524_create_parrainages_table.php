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
        Schema::create('parrainages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parrain_id');
            $table->unsignedBigInteger('filleul_id')->unique();
            $table->string('code_parrainage_utilise');
            $table->timestamp('date_parrainage')->useCurrent();
            $table->decimal('bonus_obtenu', 15, 2)->default(0.00);
            $table->boolean('bonus_verse')->default(false);
            $table->boolean('statut_filleul')->default(false);
            $table->timestamps();
            $table->foreign('parrain_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('filleul_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parrainages');
    }
};