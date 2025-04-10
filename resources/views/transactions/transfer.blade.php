
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="max-w-md mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('dashboard') }}" class="mr-2 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Transfert</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6 p-4 bg-blue-50 rounded-md text-blue-800 text-sm">
                <strong>Frais:</strong> 0.1% du montant transféré
            </div>

            <form method="POST" action="{{ route('transactions.transfer') }}">
                @csrf

                <div class="mb-4">
                    <label for="recipient_type" class="block text-sm font-medium text-gray-700 mb-1">
                        Type de destinataire
                    </label>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input type="radio" id="recipient_type_friend" name="recipient_type" value="friend" checked
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <label for="recipient_type_friend" class="ml-2 block text-sm text-gray-700">
                                Ami
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="recipient_type_manual" name="recipient_type" value="manual"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <label for="recipient_type_manual" class="ml-2 block text-sm text-gray-700">
                                Saisie manuelle
                            </label>
                        </div>
                    </div>
                </div>

                <div id="friends_section" class="mb-4">
                    <label for="friend_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Sélectionnez un ami
                    </label>
                    <select name="friend_id" id="friend_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un ami</option>
                        @foreach(Auth::user()->friends() as $friend)
                            <option value="{{ $friend->id }}">{{ $friend->name }} ({{ $friend->username ?: $friend->telephone }})</option>
                        @endforeach
                    </select>
                    @error('friend_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="manual_section" class="mb-4 hidden">
                    <label for="recipient" class="block text-sm font-medium text-gray-700 mb-1">
                        Destinataire (nom d'utilisateur, email ou téléphone)
                    </label>
                    <input type="text" name="recipient" id="recipient"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('recipient') }}">
                    @error('recipient')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Montant (XAF)</label>
                    <input type="number" name="amount" id="amount" min="10" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('amount') }}">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pin" class="block text-sm font-medium text-gray-700 mb-1">Code PIN</label>
                    <input type="password" name="pin" id="pin" maxlength="4" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('pin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Solde disponible</label>
                    <div class="text-lg font-semibold">{{ number_format($balance, 2) }} XAF</div>
                </div>

                <div class="mb-6">
                    <div class="text-sm text-gray-600" id="fee-display">Frais: 0 XAF</div>
                    <div class="text-sm text-gray-600" id="total-display">Total à débiter: 0 XAF</div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Effectuer le transfert
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const feeDisplay = document.getElementById('fee-display');
    const totalDisplay = document.getElementById('total-display');
    const recipientTypeInputs = document.querySelectorAll('input[name="recipient_type"]');
    const friendsSection = document.getElementById('friends_section');
    const manualSection = document.getElementById('manual_section');

    // Function to update fee and total
    function updateFee() {
        const amount = parseFloat(amountInput.value) || 0;
        const fee = amount * 0.001; // 0.1%
        const total = amount + fee;

        feeDisplay.textContent = `Frais: ${fee.toFixed(2)} XAF`;
        totalDisplay.textContent = `Total à débiter: ${total.toFixed(2)} XAF`;
    }

    // Function to toggle recipient sections
    function toggleRecipientSections() {
        const selectedType = document.querySelector('input[name="recipient_type"]:checked').value;

        if (selectedType === 'friend') {
            friendsSection.classList.remove('hidden');
            manualSection.classList.add('hidden');
            document.getElementById('recipient').required = false;
            document.getElementById('friend_id').required = true;
        } else {
            friendsSection.classList.add('hidden');
            manualSection.classList.remove('hidden');
            document.getElementById('recipient').required = true;
            document.getElementById('friend_id').required = false;
        }
    }

    // Add event listeners
    amountInput.addEventListener('input', updateFee);
    recipientTypeInputs.forEach(input => {
        input.addEventListener('change', toggleRecipientSections);
    });

    // Initialize
    updateFee();
    toggleRecipientSections();
});
</script>
@endsection
