<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $guarded=[];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function guia(){
        return $this->belongsTo(Guia::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}
