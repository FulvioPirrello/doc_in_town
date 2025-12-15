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

Route::get(
    '/', 
    [ProfessionistaController::class, 
    'professionisti'])
    ->name('login'); 

Route::get(
    '/professionista/{id}', 
    [ProfessionistaController::class, 
    'show'])
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