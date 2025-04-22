<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigDepot extends Model
{
    protected $fillable = [
        'numero_depot_mtn',
        'numero_depot_orange',
        'nom_depot_mtn',
        'nom_depot_orange',
        'lien_video_youtube',
        'lien_video_tiktok',
        'code_admin',
    ];
}