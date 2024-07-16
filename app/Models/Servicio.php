<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'servicio'; // Si la tabla se llama 'paquete'
    public $timestamps = false; // Desactiva las marcas de tiempo automáticas

    public function guias(){
        return $this->hasMany(Guia::class);
    }
}
