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
        $searchText = $request->input('search'); 
        $searchCitta = $request->input('citta');
        $searchSpec = $request->input('specializzazione');

        $query = Professionista::leftJoin(
            'specializzazioni', 
            'professionisti.specializzazione', 
            '=', 
            'specializzazioni.tipo')
            ->select(
                'professionisti.*', 
                'specializzazioni.pic');

        if ($searchText) 
        {
            $query->where(function($q) use ($searchText) 
            {
                $q->where(
                    'professionisti.nome', 
                    'LIKE', 
                    "%{$searchText}%")
                  ->orWhere(
                    'professionisti.specializzazione', 
                    'LIKE', 
                    "%{$searchText}%")
                  ->orWhere(
                    'professionisti.citta', 
                    'LIKE', 
                    "%{$searchText}%");
            });
        }

        if ($searchCitta) 
        {
            $query->where('professionisti.citta', $searchCitta);
        }

        if ($searchSpec) 
        {
            $query->where('professionisti.specializzazione', $searchSpec);
        }

        $items = $query->paginate(18);
        
        $specializzazioni = Specializzazione::orderBy('tipo', 'asc')->get();

        $citta = Professionista::select('citta')->distinct()->orderBy('citta', 'asc')->get();

        return view('homepage', compact(
            'items', 
            'specializzazioni', 
            'citta'));
    }

    public function show($id)
    {
        $item = Professionista::leftJoin(
            'specializzazioni',
            'professionisti.specializzazione', 
            '=', 
            'specializzazioni.tipo')
            ->select('professionisti.*', 
            'specializzazioni.pic')
            ->where('professionisti.id', $id)
            ->firstOrFail();

        $prenotazioni = Prenotazione::where('professionista_id', $id)
            ->where('data_visita', 
            '>=', now()->toDateString())
            ->get(['data_visita', 
            'ora_visita']);

        return view(
            'doc', compact(
            'item', 
            'prenotazioni'));
    }
}