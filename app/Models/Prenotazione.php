<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prenotazione extends Model
{
    use HasFactory;

    protected $table = 'prenotazioni';

    protected $fillable = [
        'user_id',
        'professionista_id',
        'data_visita',
        'ora_visita',
        'note'
    ];
}