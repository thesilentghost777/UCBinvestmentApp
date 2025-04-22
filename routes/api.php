<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestissementPaiementController;

// API pour vérifier l’état du paiement
Route::middleware('auth:sanctum')->get('/api/payment-status/{id}', [InvestissementPaiementController::class, 'apiStatus']);
