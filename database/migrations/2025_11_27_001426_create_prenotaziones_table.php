<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{public function up(): void
{
    Schema::create('prenotazioni', function (Blueprint $table) {
        $table->id();
        
        $table->unsignedBigInteger('user_id'); 
        $table->unsignedBigInteger('professionista_id');
        
        $table->date('data_visita');
        $table->string('ora_visita');
        $table->timestamps();
    });
}
};
