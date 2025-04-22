@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto my-8 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Configuration des dépôts</h2>
    @if(session('success'))
      <div class="bg-green-200 text-green-800 px-3 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.config-depots.update') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm">Numéro Dépôt MTN</label>
            <input type="text" name="numero_depot_mtn" value="{{ old('numero_depot_mtn', $config->numero_depot_mtn ?? '') }}" class="w-full rounded border px-2 py-1" />
        </div>
        <div>
            <label class="block text-sm">Numéro Dépôt Orange</label>
            <input type="text" name="numero_depot_orange" value="{{ old('numero_depot_orange', $config->numero_depot_orange ?? '') }}" class="w-full rounded border px-2 py-1" />
        </div>
        <div>
            <label class="block text-sm">Nom Dépôt MTN</label>
            <input type="text" name="nom_depot_mtn" value="{{ old('nom_depot_mtn', $config->nom_depot_mtn ?? '') }}" class="w-full rounded border px-2 py-1" />
        </div>
        <div>
            <label class="block text-sm">Nom Dépôt Orange</label>
            <input type="text" name="nom_depot_orange" value="{{ old('nom_depot_orange', $config->nom_depot_orange ?? '') }}" class="w-full rounded border px-2 py-1" />
        </div>
        <div>
            <label class="block text-sm">Lien vidéo YouTube (défaut)</label>
            <input type="url" name="lien_video_youtube" value="{{ old('lien_video_youtube', $config->lien_video_youtube ?? '') }}" class="w-full rounded border px-2 py-1" />
        </div>
        <div>
            <label class="block text-sm">Lien vidéo TikTok (défaut)</label>
            <input type="url" name="lien_video_tiktok" value="{{ old('lien_video_tiktok', $config->lien_video_tiktok ?? '') }}" class="w-full rounded border px-2 py-1" />
        </div>
        <div>
            <label class="block text-sm">Code récupération admin</label>
            <input type="text" name="code_admin" value="{{ old('code_admin', $config->code_admin ?? '') }}" class="w-full rounded border px-2 py-1" />
        </div>
        <div class="flex gap-4 mt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded text-white">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
