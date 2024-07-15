<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contador_Pagina extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'contador_pagina'; // Si la tabla se llama 'contador_pagina'
    public $timestamps = false; // Desactiva las marcas de tiempo automáticas
    protected $primaryKey = 'nombre'; // Establece 'nombre' como clave primaria


}
