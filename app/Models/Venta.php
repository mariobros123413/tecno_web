<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $guarded=[];
    protected $table = 'venta'; // Si la tabla se llama 'guia'
    public $timestamps = false; // Desactiva las marcas de tiempo automáticas


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function guia(){
        return $this->belongsTo(Guia::class);
    }

    public function pago(){
        return $this->hasOne(Pago::class, 'id_venta');
    }
}
