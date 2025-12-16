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
        $testo_cerca = $request->input('search'); 
        $filtro_citta = $request->input('citta');
        $filtro_spec = $request->input('specializzazione');

        $medici_db = Professionista::leftJoin(
            'specializzazioni', 
            'professionisti.specializzazione', 
            '=', 
            'specializzazioni.tipo')
            ->select(
                'professionisti.*', 
                'specializzazioni.pic');

        if ($testo_cerca) 
        {
            $medici_db->where(function($q) use ($testo_cerca) 
            {
                $q->where(
                    'professionisti.nome', 
                    'LIKE', 
                    "%{$testo_cerca}%")

                  ->orWhere(
                    'professionisti.specializzazione', 
                    'LIKE', 
                    "%{$testo_cerca}%")

                  ->orWhere(
                    'professionisti.citta', 
                    'LIKE', 
                    "%{$testo_cerca}%");
            });
        }

        if ($filtro_citta) 
        {
            $medici_db->where(
                'professionisti.citta', 
                $filtro_citta);
        }

        if ($filtro_spec) 
        {
            $medici_db->where(
                'professionisti.specializzazione', 
                $filtro_spec);
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

            ->select('professionisti.*')
                
            ->where('professionisti.id', $id)
            
            ->firstOrFail();

        $appuntamenti = Prenotazione::where('professionista_id', $id)
            ->where('data_visita', '>=', now()
            ->toDateString())
            ->get(['data_visita', 'ora_visita']);

        return view('doc', [
            'dottore' => $dottore,
            'prenotazioni' => $appuntamenti
        ]);
    }
}