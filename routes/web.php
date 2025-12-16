<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfessionistaController;
use App\Http\Controllers\PrenotazioniController;
use App\Http\Controllers\UtenteController;

Route::post(
    '/register', 
    [RegisterController::class, 
    'register']);
    
Route::post(
    '/login', 
    [LoginController::class, 
    'login']);
    
Route::post(
    '/logout', 
    [LogoutController::class, 
    'logout'])
    ->name('logout');

Route::post(
    '/prenota/{id}', 
    [PrenotazioniController::class, 
    'crea_prenotazione'])
    ->name('aggiungi_professionista');

Route::post(
    '/profilo/modifica', 
    [UtenteController::class, 
    'aggiorna_dati_utente']) 
    ->name('aggiorna_profilo')
    ->middleware('auth');

Route::get(
    '/profilo/modifica', 
    [UtenteController::class, 
    'modifica_utente']) 
    ->name('modifica_profilo')
    ->middleware('auth');
    
Route::get(
    '/', 
    [ProfessionistaController::class, 
    'professionisti'])
    ->name('login'); 

Route::get(
    '/professionista/{id}', 
    [ProfessionistaController::class, 
    'mostra_dottore'])
    ->name('mostra_professionista');

Route::get(
    '/profilo', 
    [UtenteController::class, 
    'profilo_utente'])
    ->name('profilo_utente')
    ->middleware('auth');

Route::delete(
    '/prenotazione/{id}', 
    [UtenteController::class, 
    'cancella_prenotazione'])
    ->name('cancella_prenotazione')
    ->middleware('auth');