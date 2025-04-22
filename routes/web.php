<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\TacheController as AdminTacheController;
use App\Http\Controllers\Admin\InvestissementController as AdminInvestissementController;
use App\Http\Controllers\Admin\RetraitController as AdminRetraitController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\TacheJournaliereController;
use App\Http\Controllers\InvestissementController;
use App\Http\Controllers\RetraitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\FirstLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestissementPaiementController;
use App\Http\Controllers\Admin\ConfigDepotController;


require __DIR__.'/auth.php';
require __DIR__.'/api.php';

Route::middleware(['auth'])->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::get('/api/payment-status/{{ $investissement->id }}', [InvestissementPaiementController::class, 'apiStatus']);

// Routes publiques
Route::get('/', function () {
    return view('welcome');
});
//routes pour l'admin

Route::prefix('/admin')->name('admin.')->middleware(['auth','admin'])->group(function () {
    // Dashboard admin
    Route::get('/index', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/taches/{tache}/toggle-status', [\App\Http\Controllers\Admin\TacheController::class, 'toggleStatus'])->name('taches.toggle-status');
    Route::get('/config-depots/edit', [ConfigDepotController::class, 'edit'])->name('config-depots.edit');
    Route::post('/config-depots/update', [ConfigDepotController::class, 'update'])->name('config-depots.update');
    Route::delete('/config-depots/destroy', [ConfigDepotController::class, 'destroy'])->name('config-depots.destroy');
    // Gestion des soldes
    Route::get('/solde', [AdminController::class, 'soldeForm'])->name('solde');
    Route::post('/solde', [AdminController::class, 'updateSolde'])->name('solde.update');
    // Prévisions de profit
    Route::get('/profit-prediction', [AdminController::class, 'profitPrediction'])->name('profit-prediction');

    // Statistiques utilisateurs
    Route::get('/user-stats', [AdminController::class, 'userStats'])->name('user-stats');

    // Gestion des packages
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');
    Route::patch('/packages/{package}/toggle', [PackageController::class, 'toggleStatus'])->name('packages.toggle');

    // Gestion des tâches
    Route::get('/taches', [AdminTacheController::class, 'index'])->name('taches.index');
    Route::get('/taches/create', [AdminTacheController::class, 'create'])->name('taches.create');
    Route::post('/taches', [AdminTacheController::class, 'store'])->name('taches.store');
    Route::get('/taches/{tache}/edit', [AdminTacheController::class, 'edit'])->name('taches.edit');
    Route::put('/taches/{tache}', [AdminTacheController::class, 'update'])->name('taches.update');
    Route::get('/taches/{tache}', [AdminTacheController::class, 'show'])->name('taches.show');
    Route::patch('/taches/{tache}/toggle', [AdminTacheController::class, 'toggleStatus'])->name('taches.toggle');
    Route::get('/taches-stats', [AdminTacheController::class, 'statistics'])->name('taches.statistics');

    // Gestion des investissements
    Route::get('/investissements', [AdminInvestissementController::class, 'index'])->name('investissements.index');
    Route::get('/investissements/pending', [AdminInvestissementController::class, 'pending'])->name('investissements.pending');
    Route::post('/investissements/{investissement}/validate', [AdminInvestissementController::class, 'validate'])->name('investissements.validate');
    Route::post('/investissements/{investissement}/reject', [AdminInvestissementController::class, 'reject'])->name('investissements.reject');
    Route::get('/investissements/{investissement}', [AdminInvestissementController::class, 'show'])->name('investissements.show');
    Route::get('/investissements-stats', [AdminInvestissementController::class, 'statistics'])->name('investissements.statistics');

    // Gestion des retraits
    Route::get('/retraits', [AdminRetraitController::class, 'index'])->name('retraits.index');
    Route::get('/retraits/pending', [AdminRetraitController::class, 'pending'])->name('retraits.pending');
    Route::post('/retraits/{retrait}/validate', [AdminRetraitController::class, 'validate'])->name('retraits.validate');
    Route::post('/retraits/{retrait}/reject', [AdminRetraitController::class, 'reject'])->name('retraits.reject');
    Route::get('/retraits/{retrait}', [AdminRetraitController::class, 'show'])->name('retraits.show');
    Route::get('/retraits-stats', [AdminRetraitController::class, 'statistics'])->name('retraits.statistics');

    // Gestion des utilisateurs
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/u8000sers/{user}/referrals', [UserController::class, 'referrals'])->name('users.referrals');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');




// Routes pour les parrainages
Route::get('/parrainages', [ParrainageController::class, 'index'])->name('parrainages.index');


// Route pour le premier login
Route::get('/first-login', function() {
    return view('auth.first-login');
})->name('first.login');

Route::get('/apropos', function() {
    return view('a_propos');
});


// Gestion des investissements
Route::get('/investissements', [InvestissementController::class, 'index'])->name('investissements.index');
Route::post('/investissements', [InvestissementController::class, 'store'])->name('investissements.store');
Route::get('/investissements/create', [InvestissementController::class, 'create'])->name('investissements.create');

Route::get('/investissements/{investissement}', [InvestissementController::class, 'show'])->name('investissements.show');

// Gestion des retraits
Route::get('/retraits', [RetraitController::class, 'index'])->name('retraits.index');
Route::get('/retraits/create', [RetraitController::class, 'create'])->name('retraits.create');
Route::post('/retraits/store', [RetraitController::class, 'store'])->name('retraits.store');

// Vue d’attente de validation de dépôt
Route::get('/investissements/paiement/attente/{id}', [InvestissementPaiementController::class, 'attente'])->name('investissements.paiement.attente');

// Vue de succès de paiement/validation dépôt
Route::get('/investissements/paiement/success', [InvestissementPaiementController::class, 'success'])->name('payment.success');

Route::get('/investissements/paiement/require/{investissement}', [InvestissementPaiementController::class, 'index'])->name('payment.required');

// Vue d'échec
Route::get('/investissements/paiement/failed', [InvestissementPaiementController::class, 'failed'])->name('payment.failed');

// Vue d’état manuel (optionnel pour quand le délai max est dépassé)
Route::get('/investissements/paiement/status/{id}', [InvestissementPaiementController::class, 'status'])->name('payment.status');

Route::post('/investissements/{investissement}/attente', [App\Http\Controllers\InvestissementController::class, 'attente'])->name('investissements.attente');

Route::middleware(['auth'])->group(function () {
    Route::get('/taches', [TacheJournaliereController::class, 'index'])->name('taches.index');
    Route::get('/taches/{tacheJournaliere}/realiser', [TacheJournaliereController::class, 'show'])->name('taches.show');
    Route::post('/taches/{tacheJournaliere}/complete', [TacheJournaliereController::class, 'complete'])->name('taches.complete');
    Route::post('/taches/{tacheJournaliere}/verify-watch-time', [TacheJournaliereController::class, 'verifyWatchTime'])->name('taches.verify-watch-time');
    Route::post('/taches/{tacheJournaliere}/verify-visit-time', [TacheJournaliereController::class, 'verifyVisitTime'])->name('taches.verify-visit-time');

});