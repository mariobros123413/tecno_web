<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta_Rastreo extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'ruta_rastreo'; // Si la tabla se llama 'guia'
    public $timestamps = false; // Desactiva las marcas de tiempo automáticas

    public function Guia(){
        return $this->belongsTo(Guia::class);
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }
}
