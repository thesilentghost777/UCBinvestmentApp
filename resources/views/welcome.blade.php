@extends('layouts.app')

@section('title', 'Bienvenue - Investissez et gagnez')

@section('content')
<!-- Background bière & logo UCB -->
<style>
    body {
        background-image: url("{{ asset('background/ChatGPT Image Apr 20, 2025, 04_44_35 PM.png') }}");
        background-size: cover;
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<div class="relative min-h-screen flex flex-col items-center justify-center bg-cover bg-no-repeat bg-center" style="font-family: 'Playfair Display', serif;">
    <!-- LOGO UCB en surimpression en haut à gauche/centre (adaptable en responsive) -->
    <img src="{{ asset('background/ChatGPT Image Apr 20, 2025, 04_44_35 PM.png') }}" alt="UCB logo" class="absolute left-4 top-4 md:left-12 md:top-10 z-40 w-24 md:w-40 shadow-xl rounded-lg bg-white/80 p-2 border-2 border-amber-400">

    <div class="w-full max-w-6xl mx-auto px-2 relative z-30">
        <!-- HERO Section Biere Glassmorphism -->
        <div class="mt-24 md:mt-28 mb-10 glass-morphism rounded-2xl shadow-2xl backdrop-blur-lg bg-white/40 ring-2 ring-amber-200">
            <div class="flex flex-col md:flex-row">
                <div class="p-8 md:p-12 md:w-1/2 flex flex-col justify-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-amber-800 drop-shadow-sm tracking-widest">Investissez, Complétez des Tâches, Gagnez de l'Argent</h1>
                    <p class="text-xl mb-8 text-slate-800 opacity-90">UCBinvestment vous rémunère pour votre participation sur les réseaux sociaux. Investissez dans un pack, complétez des tâches simples et multipliez votre investissement.</p>
                    <div class="flex flex-wrap space-x-4">
                        <a href="{{ route('register') }}" class="bg-blue-500 text-white px-7 py-3 rounded-lg font-semibold shadow-lg ring-2 ring-blue-200 hover:bg-blue-600 hover:scale-105 transition-all duration-200 mb-3">Créer un compte</a>
                        <a href="#comment-ca-marche" class="bg-blue-500 text-white px-7 py-3 rounded-lg font-semibold border-2 border-blue-500 hover:bg-blue-600 hover:scale-105 transition-all duration-200 mb-3">Comment ça marche</a>
                    </div>



                </div>
                <div class="hidden md:block md:w-1/2 relative">
                    <img src="{{ asset('logo/UCB.jpeg') }}" alt="Investissement illustration, Bière" class="object-cover w-full h-full rounded-r-2xl shadow-xl ring-2 ring-white">
                </div>
            </div>
        </div>

        <!-- Stats section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-12">
            <div class="glass-morphism p-6 rounded-lg shadow-lg text-center">
                <div class="text-4xl font-bold text-amber-600 mb-2 drop-shadow">500 XAF</div>
                <p class="text-gray-900">Bonus d'inscription gratuit</p>
            </div>
            <div class="glass-morphism p-6 rounded-lg shadow-lg text-center">
                <div class="text-4xl font-bold text-amber-600 mb-2 drop-shadow">10%</div>
                <p class="text-gray-900">Bonus de parrainage sur les investissements</p>
            </div>
            <div class="glass-morphism p-6 rounded-lg shadow-lg text-center">
                <div class="text-4xl font-bold text-amber-600 mb-2 drop-shadow">7 jours</div>
                <p class="text-gray-900">Pour rentabiliser votre investissement</p>
            </div>
        </div>

        <!-- Comment ça marche -->
        <div id="comment-ca-marche" class="my-16">
            <h2 class="text-3xl font-extrabold text-center mb-12 text-amber-900 drop-shadow tracking-wide">Comment ça marche ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass-morphism rounded-xl shadow-lg p-6 border-t-4 border-amber-400">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-dollar-sign text-2xl text-amber-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-3 text-amber-900">1. Investissez</h3>
                    <p class="text-gray-900 text-center">Choisissez un package d'investissement adapté à votre budget et effectuez votre paiement.</p>
                </div>
                <div class="glass-morphism rounded-xl shadow-lg p-6 border-t-4 border-lime-400">
                    <div class="w-16 h-16 bg-lime-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tasks text-2xl text-lime-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-3 text-lime-900">2. Réalisez des tâches</h3>
                    <p class="text-gray-900 text-center">Complétez quotidiennement vos tâches simples sur les réseaux sociaux.</p>
                </div>
                <div class="glass-morphism rounded-xl shadow-lg p-6 border-t-4 border-sky-400">
                    <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wallet text-2xl text-sky-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-3 text-sky-900">3. Retirez vos gains</h3>
                    <p class="text-gray-900 text-center">Dès que vous atteignez le montant minimum, retirez votre argent facilement.</p>
                </div>
            </div>
        </div>

        <!-- Nos packages -->
        <div class="my-16">
            <h2 class="text-3xl font-bold text-center mb-4 text-amber-900">Nos packages</h2>
            <br><br>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass-morphism rounded-lg shadow-xl overflow-hidden">
                    <div class="bg-amber-600 text-blue p-4">
                        <h3 class="text-xl font-bold text-center">Pack Débutant</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <span class="text-4xl font-bold text-amber-800">5 000</span>
                            <span class="text-gray-900"> XAF</span>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>nombre de tâche: <strong>1</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Valeur par tâche: <strong>300 XAF</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Gain journalier: <strong>300 XAF</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Retour sur investissement: <strong>14 Jours</strong></span>
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{ route('register') }}" class="block text-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 shadow-lg transition-all duration-200">
                                Commencer maintenant
                            </a>
                        </div>
                    </div>
                </div>
                <div class="glass-morphism rounded-lg shadow-xl overflow-hidden transform scale-105 border-2 border-amber-600">
                    <div class="bg-amber-700 text-blue p-6">
                        <h3 class="text-xl font-bold text-center">Pack Standard</h3>
                        <p class="text-center text-amber-200 text-sm mt-1">Populaire</p>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <span class="text-4xl font-bold text-amber-800">10 000</span>
                            <span class="text-gray-900"> XAF</span>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>nombre de tâche <strong>2</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Valeur par tâche: <strong>700 XAF</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Gain journalier: <strong>1 400 XAF</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Retour sur investissement: <strong>6 jours</strong></span>
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{ route('register') }}" class="block text-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 shadow-lg transition-all duration-200">
                                Commencer maintenant
                            </a>
                        </div>

                    </div>
                </div>
                <div class="glass-morphism rounded-lg shadow-xl overflow-hidden">
                    <div class="bg-amber-600 text-blue p-4">
                        <h3 class="text-xl font-bold text-center">Pack Premium</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <span class="text-4xl font-bold text-amber-800">30 000</span>
                            <span class="text-gray-900"> XAF</span>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>nombre de tâche <strong>3</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Valeur par tâche: <strong>700 XAF</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Gain journalier: <strong>2 100 XAF</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-lime-600 mr-2"></i>
                                <span>Retour sur investissement: <strong>13 jours</strong></span>
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{ route('register') }}" class="block text-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 shadow-lg transition-all duration-200">
                                Commencer maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('register') }}" class="inline-flex items-center bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-200">
                    Voir tous nos packages <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>


        </div>

        <!-- Témoignages -->
        <div class="my-16">
            <h2 class="text-3xl font-bold text-center mb-12 text-amber-900 drop-shadow tracking-wide">Témoignages de nos investisseurs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="glass-morphism p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mr-4">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900">Talla fotsing alain</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-900">J'ai commencé avec le pack débutant et j'ai récupéré mon investissement en une semaine. Maintenant je suis passé au pack Premium et mes revenus ont augmenté considérablement !</p>
                </div>
                <div class="glass-morphism p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mr-4">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900">Nassaramadji nassaire</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-900">Je passe environ 30 minutes par jour à compléter mes tâches et je gagne plus que sur mon ancien travail à temps partiel. UCBinvestment a changé ma vision de l'argent.</p>
                </div>
                <div class="glass-morphism p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mr-4">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900">Ngono merveille</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-900">J'ai parrainé 5 amis et je gagne des commissions sur leurs investissements. C'est un excellent moyen de générer un revenu passif tout en aidant son entourage.</p>
                </div>
            </div>
        </div>

        <!-- CTA final -->
        <div class="my-16 glass-morphism rounded-xl p-8 text-amber-900 text-center bg-white/60 shadow-2xl ring-1 ring-amber-300">
            <h2 class="text-3xl font-bold mb-4 tracking-wide">Prêt à commencer votre voyage vers la liberté financière ?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Rejoignez UCBinvestment aujourd'hui et commencez à transformer votre temps sur les réseaux sociaux en revenus concrets.</p>
            <a href="{{ route('register') }}" class="inline-block bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-600 shadow-xl transition-all duration-200">Créer un compte gratuitement</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<style>
    .glass-morphism {
        background: rgba(255,255,255,0.67);
        box-shadow: 0 8px 32px 0 rgba(31,38,135,.16), 0 1.5px 32px 0 rgba(255,191,0,.13);
        backdrop-filter: blur(12px);
        border-radius: 1rem;
        border: 1.5px solid rgba(255,212,78,0.19);
    }
</style>
@endpush
