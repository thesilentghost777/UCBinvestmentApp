<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
#utiliser le auth.php avec require
Route::middleware(['auth'])->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

// Routes publiques
Route::get('/', function () {
    return view('welcome');
});


// Routes protégées
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Wallet
    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/', [WalletController::class, 'show'])->name('show');
        Route::get('/deposit', [WalletController::class, 'showDepositForm'])->name('deposit.form');
        Route::post('/deposit', [WalletController::class, 'deposit'])->name('deposit');
        Route::get('/withdraw', [WalletController::class, 'showWithdrawForm'])->name('withdraw.form');
        Route::post('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');
    });

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/transfer', [TransactionController::class, 'showTransferForm'])->name('transfer.form');
        Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transfer');
        Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show');
        Route::post('/check-user', [TransactionController::class, 'checkUser'])->name('check-user');

    });

    // Friends
    Route::prefix('friends')->name('friends.')->group(function () {
        Route::get('/', [FriendController::class, 'index'])->name('index');
        Route::get('/search', [FriendController::class, 'showSearchForm'])->name('search.form');
        Route::post('/search', [FriendController::class, 'search'])->name('search');
        Route::post('/send-request', [FriendController::class, 'sendRequest'])->name('send-request');
        Route::post('/accept-request', [FriendController::class, 'acceptRequest'])->name('accept-request');
        Route::post('/decline-request', [FriendController::class, 'declineRequest'])->name('decline-request');
        Route::post('/remove', [FriendController::class, 'remove'])->name('remove');
         // New routes for PIN management

    });
    Route::get('/set-pin', [TransactionController::class, 'showSetPinForm2'])->name('set.pin');
Route::post('/transactions/set-pin', [TransactionController::class, 'setPin'])->name('transactions.set-pin');

});