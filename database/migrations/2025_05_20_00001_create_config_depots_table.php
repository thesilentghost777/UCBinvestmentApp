<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('config_depots', function (Blueprint $table) {
            $table->id();
            $table->string('numero_depot_mtn')->nullable();
            $table->string('numero_depot_orange')->nullable();
            $table->string('nom_depot_mtn')->nullable();
            $table->string('nom_depot_orange')->nullable();
            $table->string('lien_video_youtube')->nullable();
            $table->string('lien_video_tiktok')->nullable();
            $table->string('code_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('config_depots');
    }
};