<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) 
    {
        $email_or_username = trim($request->input('email') ?? $request->input('username'));
        $password = ($request->input('password'));

        if(empty($email_or_username))
        {
            return response()->json([
                "success" => false,
                "messaggio"=>"Inserire un Username o un'email valida."
            ], 422);
        }
        if(empty($password))
        {
            return response()->json([
                "success" => false,
                "messaggio"=>"Inserire una Password valida."
            ], 422);
        }

        $controllo = filter_var($email_or_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        if (Auth::attempt([$controllo => $email_or_username, 'password' => $password])) 
        {
            $user = Auth::user();
            return response()->json([
                "success" => true,
                "username" => $user->name,
                "messaggio" => "Login effettuato correttamente"
            ],200);
        }
        return response()->json([
        "success" => false,
        "messaggio" => ["Login fallito! Credenziali non valide."]
        ], 401); 
    }
}
