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
    Schema::create('packages', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->decimal('montant_investissement', 15, 2);
        $table->decimal('valeur_par_tache', 15, 2);
        $table->decimal('gain_journalier', 15, 2);
        $table->boolean('actif')->default(true);
        $table->timestamps();
    });

    DB::table('packages')->insert([
        [
            'nom' => 'Machine 1',
            'montant_investissement' => 5000,
            'valeur_par_tache' => 300,
            'gain_journalier' => 300,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nom' => 'Machine 2',
            'montant_investissement' => 10000,
            'valeur_par_tache' => 700,
            'gain_journalier' => 1400,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nom' => 'Machine 3',
            'montant_investissement' => 30000,
            'valeur_par_tache' => 700,
            'gain_journalier' => 2100,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nom' => 'Machine 4',
            'montant_investissement' => 50000,
            'valeur_par_tache' => 700,
            'gain_journalier' => 3500,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nom' => 'Machine 5',
            'montant_investissement' => 80000,
            'valeur_par_tache' => 700,
            'gain_journalier' => 4900,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nom' => 'Machine 6',
            'montant_investissement' => 100000,
            'valeur_par_tache' => 700,
            'gain_journalier' => 6300,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nom' => 'Machine 7',
            'montant_investissement' => 150000,
            'valeur_par_tache' => 700,
            'gain_journalier' => 9800,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nom' => 'Machine 8',
            'montant_investissement' => 300000,
            'valeur_par_tache' => 700,
            'gain_journalier' => 19600,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
