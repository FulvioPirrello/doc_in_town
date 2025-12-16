<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|min:3|unique:users,name',
                'email'    => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@£$!?]/',
                    'same:password_confirm'
                ],
            ], [
                'username.unique' => 'Username già in uso.',
                'email.unique'    => 'Email già registrata.',
                'password.regex'  => 'La password deve contenere maiuscole, numeri e caratteri speciali (@£$!?).',
                'password.same'   => 'Le password non coincidono.'
            ]);

            $utente = Utente::create([
                'name'     => $validated['username'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($utente);

            return response()->json([
                "success"   => true,
                "username"  => $utente->name,
                "messaggio" => "Registrazione effettuata con successo!"
            ], 201);

        } 
        catch (ValidationException $e) 
        {
            return response()->json([
                "success"   => false,
                "messaggio" => $e->validator->errors()->first()
            ], 422);

        } catch (\Exception $e) 
        {
            Log::error("Errore registrazione: " . $e->getMessage());
            
            return response()->json([
                "success"   => false,
                "messaggio" => "Errore del server. Controlla i log."
            ], 500);
        }
    }
}