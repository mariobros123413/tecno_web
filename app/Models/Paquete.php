<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'paquete'; // Si la tabla se llama 'paquete'
    public $timestamps = false; // Desactiva las marcas de tiempo automáticas


}
