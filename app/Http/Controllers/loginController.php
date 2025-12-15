<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) 
    {
       
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Inserisci username o email.',
            'password.required' => 'Inserisci la password.'
        ]);

        $tipo_login = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        if (Auth::attempt([$tipo_login => $request->input('email'), 'password' => $request->input('password')])) 
        {
            $request->session()->regenerate();

            return response()->json([
                "success"   => true,
                "username"  => Auth::user()->name,
                "messaggio" => "Login effettuato correttamente"
            ], 200);
        }

        return response()->json([
            "success"   => false,
            "messaggio" => "Credenziali non valide."
        ], 401); 
    }
}