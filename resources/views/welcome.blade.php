
@extends('layouts.app')

@section('content')
<div class="bg-primary-500 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    <span class="block">TRUSTIX</span>
                    <span class="block text-secondary-400">Transferts d'argent sécurisés par blockchain</span>
                </h1>
                <p class="mt-6 text-xl max-w-3xl">
                    Envoyez de l'argent à vos proches de manière sécurisée, rapide et transparente grâce à notre plateforme basée sur la blockchain.
                </p>
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="inline-block bg-white text-primary-600 hover:bg-gray-100 py-3 px-8 rounded-lg text-lg font-semibold shadow-md">Commencer</a>
                    <a href="{{ route('login') }}" class="ml-4 inline-block text-white border border-white hover:bg-primary-600 py-3 px-8 rounded-lg text-lg font-semibold">Se connecter</a>
                </div>
            </div>
            <div class="md:w-1/2">
                <img src="{{ asset('logo/trustix-removebg-preview.png') }}" alt="TRUSTIX" class="rounded-lg shadow-xl">
            </div>

        </div>
    </div>
</div>

<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Pourquoi choisir TRUSTIX?
            </h2>
            <p class="mt-4 text-lg text-gray-500">
                Notre plateforme offre de nombreux avantages par rapport aux services de transfert traditionnels.
            </p>
        </div>

        <div class="mt-20">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="pt-6">
                    <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-primary-500 rounded-md shadow-lg">
                                    <!-- Hero icon placeholder -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Sécurité maximale</h3>
                            <p class="mt-5 text-base text-gray-500">
                                Toutes les transactions sont sécurisées par la technologie blockchain, garantissant une sécurité inégalée.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-primary-500 rounded-md shadow-lg">
                                    <!-- Hero icon placeholder -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Transferts rapides</h3>
                            <p class="mt-5 text-base text-gray-500">
                                Envoyez de l'argent en quelques secondes, peu importe la distance ou le montant.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                        <div class="-mt-6">
                            <div>
                                <span class="inline-flex items-center justify-center p-3 bg-primary-500 rounded-md shadow-lg">
                                    <!-- Hero icon placeholder -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Transparence totale</h3>
                            <p class="mt-5 text-base text-gray-500">
                                Suivez vos transactions en temps réel et visualisez l'historique complet de vos transferts.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-secondary-500 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold sm:text-4xl">
            Prêt à commencer?
        </h2>
        <p class="mt-4 text-lg">
            Créez votre compte gratuitement et commencez à transférer de l'argent en toute sécurité.
        </p>
        <div class="mt-8">
            <a href="{{ route('register') }}" class="inline-block bg-white text-secondary-600 hover:bg-gray-100 py-3 px-8 rounded-lg text-lg font-semibold shadow-md">S'inscrire maintenant</a>
        </div>
    </div>
</div>
@endsection
