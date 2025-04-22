@extends('layouts.app')

@section('title', 'Confirmation d\'investissement')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-600 p-6 text-white text-center">
            <i class="fas fa-check-circle text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold">Demande d'investissement initiée</h1>
        </div>

        <div class="p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">Instructions de paiement</h2>
                <p class="mb-4">Veuillez effectuer un dépôt de <strong>{{ number_format($investissement->montant, 0, ',', ' ') }} XAF</strong> sur le numéro ci-dessous pour activer votre investissement :</p>

                <div class="bg-white p-4 rounded border border-blue-200 mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Numéro de dépôt:</p>
                            <p class="text-xl font-bold" id="numero">{{ $investissement->numero_depot }}</p>
                        </div>
                        <button onclick="copyToClipboard('{{ $investissement->numero_depot }}')" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition-colors">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="text-sm text-gray-600">
                    <p class="mb-1"><i class="fas fa-info-circle mr-1 text-blue-600"></i> Utilisez le même numéro de téléphone que celui enregistré dans votre profil pour effectuer le paiement.</p>
                    <p><i class="fas fa-info-circle mr-1 text-blue-600"></i> Votre investissement sera validé dès réception de votre paiement.</p>
                </div>
            </div>

            <div class="border-t pt-4 mb-6">
                <h3 class="font-medium mb-2">Récapitulatif :</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between">
                        <span class="text-gray-600">Package :</span>
                        <span class="font-medium">{{ $investissement->package->nom }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Montant :</span>
                        <span class="font-medium">{{ number_format($investissement->montant, 0, ',', ' ') }} XAF</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Gain quotidien :</span>
                        <span class="font-medium">{{ number_format($investissement->package->gain_journalier, 0, ',', ' ') }} XAF</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Retour sur investissement :</span>
                        <span class="font-medium">{{ $investissement->package->jours_retour_investissement }} jours</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Date d'initiation :</span>
                        <span class="font-medium">{{ $investissement->date_initiation->format('d/m/Y H:i') }}</span>
                    </li>
                </ul>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('investissements.index') }}" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded text-center hover:bg-blue-700 transition-colors">
                    Mes investissements
                </a>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded text-center hover:bg-gray-300 transition-colors">
                    Tableau de bord
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Afficher une notification de succès
            const button = event.currentTarget;
            const icon = button.querySelector('i');

            if (icon) {
                icon.classList.remove('fa-copy');
                icon.classList.add('fa-check');
            }

            button.classList.remove('bg-blue-600');
            button.classList.add('bg-green-600');

            setTimeout(() => {
                if (icon) {
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-copy');
                }

                button.classList.remove('bg-green-600');
                button.classList.add('bg-blue-600');
            }, 2000);
        });
    }
</script>
@endpush
@endsection