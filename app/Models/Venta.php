<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $guarded=[];

    public function detalleventa(){
        return $this->hasMany(DetalleVenta::class, 'venta_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pago(){
        return $this->belongsTo(Pago::class);
    }
}
