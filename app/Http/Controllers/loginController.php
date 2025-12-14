<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request) 
    {
        // 1. Validazione Automatica
        // Se i campi sono vuoti, Laravel risponde automaticamente col 422 e il messaggio d'errore.
        $request->validate([
            'email'    => 'required|string', // Dal frontend arriva il campo 'email' anche se è un username
            'password' => 'required|string',
        ], [
            'email.required'    => 'Inserisci username o email.',
            'password.required' => 'Inserisci la password.'
        ]);

        // 2. Logica Username o Email
        // Capiamo se l'utente ha scritto una mail o un username
        $loginType = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        // 3. Tentativo di Login
        // Auth::attempt controlla le credenziali e avvia la sessione se corrette
        if (Auth::attempt([$loginType => $request->input('email'), 'password' => $request->input('password')])) 
        {
            $request->session()->regenerate(); // Importante per la sicurezza (Fix Session Fixation)

            return response()->json([
                "success"   => true,
                "username"  => Auth::user()->name,
                "messaggio" => "Login effettuato correttamente"
            ], 200);
        }

        // 4. Risposta in caso di fallimento
        // Ritorniamo un 401 (Unauthorized)
        return response()->json([
            "success"   => false,
            "messaggio" => "Credenziali non valide."
        ], 401); 
    }
}