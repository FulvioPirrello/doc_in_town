<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prenotazione;

class UserController extends Controller
{
    public function profilo()
    {
        $user = Auth::user();

        $appuntamenti = Prenotazione::where('user_id', $user->id)
            ->join('professionisti', 'prenotazioni.professionista_id', '=', 'professionisti.id')
            ->select(
                'prenotazioni.*', 
                'professionisti.nome as nome_dottore', 
                'professionisti.specializzazione',
                'professionisti.sede_studio',
                'professionisti.citta'
            )
            ->orderBy('data_visita', 'asc')
            ->orderBy('ora_visita', 'asc')
            ->get();

        return view('utente', compact('user', 'appuntamenti'));
    }
}