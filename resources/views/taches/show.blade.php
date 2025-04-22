@extends('layouts.app')

@section('title', 'Réalisation de tâche')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('taches.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Retour à mes tâches
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-600 p-6 text-white">
            <h1 class="text-2xl font-bold">Réalisation de la tâche</h1>
            <p class="text-blue-100">Rémunération: {{ number_format($tacheJournaliere->remuneration, 0, ',', ' ') }} XAF</p>
        </div>

        <div class="p-6">
            <div class="flex items-start mb-6">
                @if($tacheJournaliere->tache->type == 'youtube')
                    <div class="h-14 w-14 rounded bg-red-100 flex items-center justify-center text-red-600 mr-4">
                        <i class="fab fa-youtube text-2xl"></i>
                    </div>
                @elseif($tacheJournaliere->tache->type == 'tiktok')
                    <div class="h-14 w-14 rounded bg-black flex items-center justify-center text-white mr-4">
                        <i class="fab fa-tiktok text-2xl"></i>
                    </div>
                @else
                    <div class="h-14 w-14 rounded bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                        <i class="fas fa-globe text-2xl"></i>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $tacheJournaliere->tache->description }}</h2>
                    <p class="text-gray-600 mt-1">Suivez les instructions ci-dessous pour compléter cette tâche.</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">Instructions</h3>

                <div class="space-y-4">
                    <div class="flex">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                            <span class="text-sm font-bold">1</span>
                        </div>
                        <div>
                            <p class="text-gray-800">
                                @if($tacheJournaliere->tache->type == 'youtube')
                                Prenez le temps de regarder la vidéo pendant au moins 60 secondes, puis likez, commentez et abonnez-vous !
                                @else
                                    Cliquez sur le lien ci-dessous pour accéder au contenu.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                            <span class="text-sm font-bold">2</span>
                        </div>
                        <div>
                            @if($tacheJournaliere->tache->type == 'youtube')
                                <p class="text-gray-800">Assurez-vous de regarder la vidéo pendant au moins 60 secondes et ne quittez pas la page.</p>
                            @elseif($tacheJournaliere->tache->type == 'tiktok')
                                <p class="text-gray-800">Visionnez la vidéo TikTok,commentez et mettez un "j'aime" et abonnez vous.</p>
                            @else
                                <p class="text-gray-800">Interagissez avec le contenu selon les instructions.</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                            <span class="text-sm font-bold">3</span>
                        </div>
                        <div>
                            <p class="text-gray-800">Une fois que vous avez terminé, cliquez sur le bouton "J'ai terminé" ci-dessous.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    @if($tacheJournaliere->tache->type == 'youtube')
                        <div class="video-container" id="player-container">
                            <!-- Le lecteur YouTube sera inséré ici par JavaScript -->
                            <div id="youtube-player" class="w-full"></div>
                            <div id="progress-container" class="hidden mt-4 p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-blue-700">Progression :</span>
                                    <span id="watch-time" class="text-sm font-medium text-blue-700">0 / 60 secondes</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    @else

                    @endif
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-yellow-600 mr-3"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-yellow-800 mb-1">Important</h4>
                        <p class="text-yellow-700 text-sm">Vous devez réellement effectuer la tâche demandée. Des contrôles aléatoires sont effectués et la triche peut entraîner la suspension de votre compte.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('taches.complete', $tacheJournaliere->id) }}" method="POST" id="complete-form">
                @csrf
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <input type="checkbox" id="confirmation" name="confirmation" required class="h-4 w-4 text-blue-600 border-gray-300 rounded mr-2">
                        <label for="confirmation" class="text-gray-700">Je confirme avoir effectué cette tâche</label>
                    </div>

                    <button type="submit" id="complete-button" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition-colors" {{ $tacheJournaliere->tache->type == 'youtube' ? 'disabled' : '' }}>
                        <i class="fas fa-check mr-2"></i> J'ai terminé
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($tacheJournaliere->tache->type == 'youtube')
<script>
    // Extraction de l'ID de la vidéo YouTube à partir de l'URL
    function extractYoutubeVideoId(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[7].length === 11) ? match[7] : false;
    }

    // Variables pour le suivi du temps de visionnage
    let player;
    let timerStarted = false;
    let watchTime = 0;
    let timer;
    let videoVerified = false;
    let videoId = null;

    // Fonction appelée lorsque l'API du lecteur est prête
    function onYouTubeIframeAPIReady() {
        const youtubeUrl = "{{ $tacheJournaliere->tache->lien }}";
        videoId = extractYoutubeVideoId(youtubeUrl);

        if (!videoId) {
            document.getElementById('player-container').innerHTML = '<div class="p-4 bg-red-100 text-red-700 rounded">Erreur: Impossible de charger la vidéo YouTube.</div>';
            return;
        }

        player = new YT.Player('youtube-player', {
            height: '360',
            width: '640',
            videoId: videoId,
            playerVars: {
                'autoplay': 0,
                'controls': 1,
                'rel': 0
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // Lorsque le lecteur est prêt
    function onPlayerReady(event) {
        document.getElementById('progress-container').classList.remove('hidden');
    }

    // Lorsque l'état du lecteur change
    function onPlayerStateChange(event) {
        // Si la vidéo est en cours de lecture
        if (event.data === YT.PlayerState.PLAYING) {
            if (!timerStarted) {
                // Démarrer le chronomètre pour suivre le temps de visionnage
                timerStarted = true;
                timer = setInterval(updateWatchTime, 1000);
            }
        } else {
            // Si la vidéo est en pause ou terminée
            timerStarted = false;
            clearInterval(timer);
        }
    }

    // Mise à jour du temps de visionnage
    function updateWatchTime() {
        watchTime++;
        const requiredTime = 60; // 60 secondes minimum

        // Mise à jour de la barre de progression
        const progressPercentage = Math.min((watchTime / requiredTime) * 100, 100);
        document.getElementById('progress-bar').style.width = `${progressPercentage}%`;
        document.getElementById('watch-time').textContent = `${watchTime} / ${requiredTime} secondes`;

        // Vérifier si le temps requis a été atteint
        if (watchTime >= requiredTime && !videoVerified) {
            verifyWatchTime();
        }
    }

    // Envoyer la vérification du temps de visionnage au serveur
    function verifyWatchTime() {
        fetch("{{ route('taches.verify-watch-time', $tacheJournaliere->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                watchTime: watchTime,
                videoId: videoId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                videoVerified = true;
                // Activer le bouton de complétion
                document.getElementById('complete-button').disabled = false;
                // Ajouter un message de succès
                document.getElementById('progress-container').innerHTML += `
                    <div class="mt-2 p-2 bg-green-100 text-green-700 rounded">
                        <i class="fas fa-check-circle mr-1"></i> Temps de visionnage validé !
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Erreur lors de la vérification du temps de visionnage:', error);
        });
    }

    // Charger l'API YouTube
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // Empêcher l'envoi du formulaire si la vidéo n'a pas été regardée
    document.getElementById('complete-form').addEventListener('submit', function(e) {
        if ("{{ $tacheJournaliere->tache->type }}" === 'youtube' && !videoVerified) {
            e.preventDefault();
            alert('Vous devez regarder la vidéo pendant au moins 30 secondes avant de valider la tâche.');
        }
    });
</script>
@else
    <div class="mt-6">
        <a href="{{ $tacheJournaliere->tache->lien }}"
           target="_blank"
           id="content-link"
           onclick="startTracking()"
           class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors inline-flex items-center">
            <i class="fas fa-external-link-alt mr-2"></i> Accéder au contenu
        </a>
        <div id="progress-container" class="hidden mt-4 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-700">Progression :</span>
                <span id="visit-time" class="text-sm font-medium text-blue-700">0 / 60 secondes</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <script>
        let visitStartTime = null;
        let visitTimer = null;
        let visitVerified = false;
        const completeButton = document.getElementById('complete-button');
        if (completeButton) completeButton.disabled = true;

        function startTracking() {
            visitStartTime = new Date();
            document.getElementById('progress-container').classList.remove('hidden');
            visitTimer = setInterval(updateVisitTime, 1000);

            // Ouvrir le lien dans un nouvel onglet
            window.open('{{ $tacheJournaliere->tache->lien }}', '_blank');
        }

        function updateVisitTime() {
            if (!visitStartTime) return;

            const currentTime = new Date();
            const visitTime = Math.floor((currentTime - visitStartTime) / 1000);
            const requiredTime = 60;

            const progressPercentage = Math.min((visitTime / requiredTime) * 100, 100);
            document.getElementById('progress-bar').style.width = `${progressPercentage}%`;
            document.getElementById('visit-time').textContent = `${visitTime} / ${requiredTime} secondes`;

            if (visitTime >= requiredTime && !visitVerified) {
                verifyVisitTime(visitTime);
            }
        }

        function verifyVisitTime(visitTime) {
            fetch("{{ route('taches.verify-visit-time', $tacheJournaliere->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ visitTime: visitTime })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    visitVerified = true;
                    clearInterval(visitTimer);
                    if (completeButton) completeButton.disabled = false;

                    document.getElementById('progress-container').innerHTML += `
                        <div class="mt-2 p-2 bg-green-100 text-green-700 rounded">
                            <i class="fas fa-check-circle mr-1"></i> Temps de visite validé !
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Erreur lors de la vérification du temps de visite:', error);
            });
        }

        // Empêcher l'envoi du formulaire si le lien n'a pas été visité assez longtemps
        document.getElementById('complete-form').addEventListener('submit', function(e) {
            if (!visitVerified) {
                e.preventDefault();
                alert('Vous devez visiter le lien pendant au moins 1 minute avant de valider la tâche.');
            }
        });
    </script>
@endif
@endsection
