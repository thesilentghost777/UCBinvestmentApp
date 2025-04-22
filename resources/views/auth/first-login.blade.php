@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8">
        <div class="text-center">
            <i class="fas fa-gift text-5xl text-blue-500 mb-4"></i>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Bienvenue sur UCBinvestment !
            </h2>
            <p class="text-gray-600 mb-6">
                Votre compte a été créé avec succès. Vous avez reçu un bonus d'inscription de <span class="font-semibold text-blue-600">{{ number_format(auth()->user()->bonus_inscription, 2) }} XAF</span>.
            </p>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg mb-6">
            <h3 class="font-semibold text-blue-800 mb-2">Votre code de parrainage :</h3>
            <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-blue-200">
                <span class="font-mono text-lg tracking-wider">{{ auth()->user()->code_parrainage }}</span>
                <button id="copy-code" class="text-blue-600 hover:text-blue-800" onclick="copyCode()">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p class="text-sm text-blue-700 mt-2">
                Partagez ce code avec vos amis pour gagner des bonus lorsqu'ils investissent !
            </p>
        </div>

        <div class="space-y-4 mb-6">
            <div class="border-l-4 border-green-500 pl-3 py-2">
                <h3 class="font-semibold text-gray-900">Comment ça marche ?</h3>
                <p class="text-gray-600 text-sm">Investissez dans un package, complétez vos tâches quotidiennes et gagnez de l'argent.</p>
            </div>

            <div class="border-l-4 border-yellow-500 pl-3 py-2">
                <h3 class="font-semibold text-gray-900">Découvrez nos packages</h3>
                <p class="text-gray-600 text-sm">Des options d'investissement adaptées à tous les budgets avec un retour sur investissement garanti.</p>
            </div>

            <div class="border-l-4 border-blue-500 pl-3 py-2">
                <h3 class="font-semibold text-gray-900">Parrainez vos amis</h3>
                <p class="text-gray-600 text-sm">Recevez 25% du montant d'investissement de vos filleuls directement sur votre compte.</p>
            </div>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center py-3 px-6 border border-transparent rounded-md shadow-lg text-base font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-arrow-circle-right mr-2"></i> Accéder à mon compte
            </a>
        </div>
    </div>
</div>

<script>
function copyCode() {
    const code = "{{ auth()->user()->code_parrainage }}";
    navigator.clipboard.writeText(code).then(() => {
        const button = document.getElementById('copy-code');
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.remove('text-blue-600', 'hover:text-blue-800');
        button.classList.add('text-green-600');

        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-copy"></i>';
            button.classList.remove('text-green-600');
            button.classList.add('text-blue-600', 'hover:text-blue-800');
        }, 2000);
    });
}
</script>
@endsection