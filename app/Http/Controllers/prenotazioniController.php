<?php

namespace App\Http\Controllers;

use App\Models\Prenotazione;
use App\Models\Professionista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrenotazioniController extends Controller 
{
    public function crea_prenotazione(Request $request, $id)
    {
        if (!Auth::check()) 
        {
            return back()->with('error', 'Effettua il login per prenotare una visita.');
        }

        $request->validate([
            'data' => 'required|date|after_or_equal:today',
            'ora'  => 'required'
        ]);

        $prenotato = Prenotazione::where('professionista_id', $id)
            ->where('data_visita', $request->data)
            ->where('ora_visita', $request->ora)
            ->exists();

        if ($prenotato) {
            return back()->with('error', 'Questo orario è già occupato. Scegli un altro orario.');
        }

        Prenotazione::create([
            'user_id'           => Auth::id(),
            'professionista_id' => $id,
            'data_visita'       => $request->data,
            'ora_visita'        => $request->ora,
            'note'              => $request->note
        ]);

        $professionista = Professionista::find($id);
        if ($professionista) 
        {
            $professionista->increment('n_prenotazioni');
        }

        $user = \App\Models\Utente::find(Auth::id()); 
        if($user) 
        {
            $user->increment('n_prenotazioni');

            return back()->with('success', 'Visita prenotata con successo!');
        }
    }
}