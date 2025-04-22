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
        // Create users table with all fields combined
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('numero_telephone')->unique();
            $table->decimal('solde_actuel', 15, 2)->default(0.00);
            $table->string('code_parrainage')->unique();
            $table->decimal('bonus_inscription', 15, 2)->default(500.00);
            $table->boolean('bonus_reclame')->default(false);
            $table->unsignedBigInteger('id_parrain')->nullable();
            $table->foreign('id_parrain')->references('id')->on('users')->onDelete('set null');
            $table->boolean('statut')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
        // Création de la table soldes
        Schema::create('soldes', function (Blueprint $table) {
            $table->id();
            $table->decimal('solde_virtuel', 15, 2)->default(0.00);
            $table->decimal('solde_physique', 15, 2)->default(0.00);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });

        // Create password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('696181557'),
            'numero_telephone' => '696181557',
            'solde_actuel' => 0.00,
            'code_parrainage' => Str::random(8),
            'bonus_inscription' => 0.00,
            'bonus_reclame' => true,
            'statut' => true,
            'is_admin' => true,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Ajout d'un enregistrement dans soldes pour l'admin
        DB::table('soldes')->insert([
            'solde_virtuel' => 0.00,
            'solde_physique' => 0.00,
            'admin_id' => 1,
            'notes' => 'Solde initial de l\'administrateur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};