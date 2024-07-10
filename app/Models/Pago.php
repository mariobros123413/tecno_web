<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'pago'; // Si la tabla se llama 'guia'


    public function venta(){
        return $this->belongsTo(Venta::class);
    }
}
