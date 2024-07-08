<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'guia'; // Si la tabla se llama 'guia'

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function paquete(){
        return $this->belongsTo(Paquete::class);
    }

    public function almacenSalida()
    {
        return $this->belongsTo(Almacen::class, 'almacen_inicio');
    }

    public function almacenLlegada()
    {
        return $this->belongsTo(Almacen::class, 'almacen_final');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function ruta_rastreo(){
        return $this->hasMany(Ruta_Rastreo::class, 'guia_id', 'id');
    }
}
