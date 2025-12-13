<?php

namespace App\Http\Controllers;

use App\Models\Prenotazione;
use App\Models\Professionista;
use App\Models\Utente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class prenotazioniController extends Controller
{
    public function crea_prenotazione (Request $request, $id)
    {
        if(!Auth::check())
        {
            return back()->with('error', 'Effettua il login per prenotare una visita.');
        }

        $request->validate([
            'data'=>'required|date|after_or_equal:today',
            'ora'=>'required'
        ]);

        $giaPrenotato = Prenotazione::where('professionista_id', $id)
            ->where('data_visita', $request->data)
            ->where('ora_visita', $request->ora)
            ->exists();

        if ($giaPrenotato) 
        {
            return back()->with('error', 'Questo orario è già stato prenotato. Scegli un altro orario.');
        }

        Prenotazione::create([
            'user_id'=> Auth::id(),
            'professionista_id'=>$id,
            'data_visita'=>$request->data,
            'ora_visita'=>$request->ora,
            'note'=>$request->note
        ]);

        $dottore = Professionista::find($id);
        if($dottore)
        {
            $dottore->increment('n_prenotazioni');
        }

        $user = Utente::find(Auth::id());
        if($user)
        {
            if (is_null($user->n_prenotazioni)) 
            {
                $user->n_prenotazioni = 0;
                $user->save();
            }
            
            $user->increment('n_prenotazioni');
        }

        return back()->with('success', 'Visita prenotata con successo!');
    }
}
