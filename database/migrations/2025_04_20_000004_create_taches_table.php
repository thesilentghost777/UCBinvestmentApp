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
    Schema::create('taches', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['youtube', 'tiktok', 'facebook', 'instagram', 'autre']);
        $table->text('lien');
        $table->text('description');
        $table->boolean('statut')->default(true);
        $table->timestamps();
    });

    // Insérer 40 tâches : 20 YouTube, 20 TikTok
    $taches = [];

    for ($i = 0; $i < 20; $i++) {
        $taches[] = [
            'type' => 'youtube',
            'lien' => 'a_remplacer',
            'description' => 'inserer_vos_propores_url',
            'statut' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    for ($i = 0; $i < 20; $i++) {
        $taches[] = [
            'type' => 'tiktok',
            'lien' => 'a_remplacer',
            'description' => 'inserer_vos_propores_url',
            'statut' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    DB::table('taches')->insert($taches);
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
