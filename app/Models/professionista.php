<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professionista extends Model
{
    use HasFactory;
    protected $table = 'professionisti'; 

    public function scopeMedico($query, $term)
    {
        if ($term) 
        {
            return $query->where(function($q) use ($term) 
            {
                $q->where(
                    'professionisti.nome', 
                    'like', 
                    '%' . $term . '%')
                  ->orWhere(
                    'professionisti.specializzazione', 
                    'like', 
                    '%' . $term . '%')
                  ->orWhere(
                    'professionisti.citta', 
                    'like',
                     '%' . $term . '%')
                  ->orWhere(
                    'professionisti.sede_studio', 
                    'like', 
                    '%' . $term . '%');
            });
        }
        
        return $query;
    }
}
