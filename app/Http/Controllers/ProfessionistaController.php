<?php

namespace App\Http\Controllers;

use App\Models\Professionista;
use App\Models\Specializzazione;
use App\Models\Prenotazione;
use Illuminate\Http\Request;

class ProfessionistaController extends Controller
{
    public function professionisti(Request $request) 
    {
        $medici_db = Professionista::leftJoin(
            'specializzazioni', 
            'professionisti.specializzazione', 
            '=', 
            'specializzazioni.tipo')
            ->select(
                'professionisti.*', 
                'specializzazioni.pic');

        $medici_db->Medico($request->input('search'));

        if ($request->filled('citta')) 
        {
            $medici_db->where('professionisti.citta',
            $request->input('citta'));
        }

        if ($request->filled('specializzazione')) 
        {
            $medici_db->where('professionisti.specializzazione',
            $request->input('specializzazione'));
        }

        $medici = $medici_db->paginate(18);
        
        $lista_specializzazioni = Specializzazione::orderBy('tipo', 'asc')->get();
        $lista_citta = Professionista::select('citta')
        ->distinct()
        ->orderBy('citta', 'asc')
        ->get();

        return view('homepage', [
            'medici' => $medici,
            'specializzazioni' => $lista_specializzazioni, 
            'citta' => $lista_citta
        ]);
    }

    public function mostra_dottore($id)
    {
        $dottore = Professionista::leftJoin(
            'specializzazioni', 
            'professionisti.specializzazione', 
            '=', 
            'specializzazioni.tipo')
            ->select('professionisti.*', 
            'specializzazioni.pic')
            ->where('professionisti.id', $id)
            ->firstOrFail();

        $appuntamenti = Prenotazione::where('professionista_id', $id)
            ->where('data_visita', 
            '>=', 
            now()
            ->toDateString())
            ->get(['data_visita', 'ora_visita']);

        return view('doc', [
            'dottore' => $dottore,
            'prenotazioni' => $appuntamenti
        ]);
    }
}