<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\ChatbotController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD complets
    Route::resource('patients',    PatientController::class);
    Route::resource('medecins',    MedecinController::class);
    Route::resource('rendezvous',  RendezVousController::class);
    Route::resource('medicaments', MedicamentController::class);
    Route::resource('hospitals',   HospitalController::class);

    // Chatbot
    Route::get('/chatbot',                [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot/envoyer',       [ChatbotController::class, 'envoyer'])->name('chatbot.envoyer');
    Route::get('/chatbot/effacer',        [ChatbotController::class, 'effacerHistorique'])->name('chatbot.effacer');
});

require __DIR__ . '/auth.php';
