<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'almacen'; // Si la tabla se llama 'paquete'
    public $timestamps = false; // Desactiva las marcas de tiempo automáticas


}
