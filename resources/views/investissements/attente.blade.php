@extends('layouts.app')
@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center">
<div class="bg-white shadow rounded-lg p-8 flex flex-col items-center">
<div class="mb-4">
<!-- Loader (cercle qui tourne) -->
<svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
</svg>
</div>
<h2 class="text-xl font-semibold mb-1">En attente de validation</h2>
<div class="text-gray-700 text-center mb-3">Effectuez le dépôt et patientez quelques instants.La validation par l'administration peut prendre quelques minutes.<br>Vous serez redirigé automatiquement dès que le dépôt sera validé.</div>
<div class="text-sm text-gray-500">Ne quittez pas cette page.</div>
</div>
</div>

<!-- Script de polling pour vérifier l'état du paiement -->
<!-- Script de polling pour vérifier l'état du paiement -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentId = "{{ $paymentId ?? request()->query('payment_id') }}";
        const checkInterval = 5000;
        let checkCount = 0;
        const maxChecks = 60;

        function checkPaymentStatus() {
            fetch(`/api/payment-status/{{ $investissement->id }}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'validated') {
                    window.location.href = "{{ route('payment.success') }}?payment_id=" + paymentId;
                } else if (data.status === 'failed') {
                    window.location.href = "{{ route('payment.failed') }}?payment_id=" + paymentId;
                } else {
                    checkCount++;
                    if (checkCount < maxChecks) {
                        setTimeout(checkPaymentStatus, checkInterval);
                    } else {
                        document.querySelector('.text-gray-500').innerHTML =
                            'Le délai d\'attente est dépassé. <a href="{{ route("payment.status", ["id" => "' + paymentId + '"]) }}" class="text-indigo-600">Vérifier l\'état du paiement</a>';
                    }
                }
            })
            .catch(error => {
                checkCount++;
                if (checkCount < maxChecks) {
                    setTimeout(checkPaymentStatus, checkInterval);
                }
            });
        }
        setTimeout(checkPaymentStatus, checkInterval);
    });
    </script>
    @endsection
