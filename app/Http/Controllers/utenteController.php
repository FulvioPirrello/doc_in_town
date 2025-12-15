<?php

namespace App\Http\Controllers;

use App\Models\Prenotazione;
use App\Models\Professionista;
use App\Models\Utente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtenteController extends Controller
{
    public function profilo_utente()
    {
        $user = Auth::user();

        $appuntamenti = Prenotazione::where('user_id', $user->id)
            ->join('professionisti', 'prenotazioni.professionista_id', '=', 'professionisti.id')
            ->select(
                'prenotazioni.*',
                'professionisti.nome as nome_medico',
                'professionisti.specializzazione',
                'professionisti.sede_studio',
                'professionisti.citta'
            )
            ->orderBy('data_visita', 'asc')
            ->orderBy('ora_visita', 'asc')
            ->get();

        return view('utente', compact('user', 'appuntamenti'));
    }

    public function cancella_prenotazione($id)
    {
        $prenotazione = Prenotazione::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $profId = $prenotazione->professionista_id;
        $userId = $prenotazione->user_id;

        $prenotazione->delete();

        $professionista = Professionista::find($profId);
        if ($professionista && $professionista->n_prenotazioni > 0) {
            $professionista->decrement('n_prenotazioni');
        }

        $user = \App\Models\User::find(Auth::id());
        
        if ($user && $user->n_prenotazioni > 0) {
            $user->decrement('n_prenotazioni');
        }

        return back()->with('success', 'Appuntamento cancellato con successo.');
    }
    
    public function modifica_utente()
    {
        $utente = Auth::user();
        return view('modifica_profilo', compact('utente'));
    }

    public function aggiorna_dati_utente(Request $request)
    {
       $utente = Utente::find(Auth::id()); 

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $utente->id, 
            'password' => 'nullable|min:8|confirmed',
        ]);

        $utente->name = $request->input('username');
        $utente->email = $request->input('email');

        if ($request->filled('password')) {
            $utente->password = Hash::make($request->input('password'));
        }

        $utente->save();

        return redirect()->route('profilo_utente')->with('success', 'Profilo aggiornato con successo!');
    }
}