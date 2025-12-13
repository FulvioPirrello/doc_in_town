<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\Concerns\Has;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try 
        {
            $username = trim($request->input('username'));
            $email = trim($request->input('email'));
            $password = $request->input('password');
            $password_confirm = $request->input('password_confirm');

            if(empty($username)) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"Inserire un Username valido."
                ], 422);
            }
            
            if (strlen($username) < 3) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"L'username deve contenere almeno 3 caratteri."
                ], 422);
            }
            
            if(Utente::where('name', $username)->exists())
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"Username già in uso."
                ], 422);
            }

            if(empty($email)) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"Inserire un'email valida."
                ], 422);
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"Formato email non valido."
                ], 422);
            }
            
            if(Utente::where('email', $email)->exists())
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"Email già registrata."
                ], 422);
            }

            if(empty($password)) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"Inserire una password."
                ], 422);
            }
            
            if(strlen($password) < 8 || strlen($password) > 16) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"La password deve essere tra 8 e 16 caratteri."
                ], 422);
            }
            
            if(!preg_match('/[A-Z]/', $password)) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"La password deve contenere almeno una lettera maiuscola."
                ], 422);
            }
            
            if(!preg_match('/[0-9]/', $password)) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"La password deve contenere almeno un numero."
                ], 422);
            }
            
            if(!preg_match('/[\@\£\$\!\?]/', $password)) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"La password deve contenere almeno un carattere speciale (@, £, $, !, ?)."
                ], 422);
            }
            
            if($password != $password_confirm) 
            {
                return response()->json([
                    "success" => false,
                    "messaggio"=>"Le password non coincidono."
                ], 422);
            }

            $utente = Utente::create([
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            Auth::login($utente);

            return response()->json([
                "success" => true,
                "username" => $utente->name,
                "messaggio" => "Registrazione effettuata con successo!"
            ], 201);
        } 
        catch (\Exception $e) 
        {
            Log::error("Errore durante la registrazione: " . $e->getMessage());
            return response()->json([
                "success" => false,
                "messaggio" => "Errore del server durante la registrazione."
            ], 500);
        }
    }
}