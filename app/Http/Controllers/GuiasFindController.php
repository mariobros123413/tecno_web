<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Guia;
use Illuminate\Database\Eloquent\Builder;

class GuiasFindController extends Controller
{

    public function __invoke(){
        $guia = Guia::query()
            ->withCount('ruta_rastreo')
            ->when(request('search'), function(Builder $query, $value){
                $query->where('guias.codigo', '=', $value);
            })
            ->first();

        $guiaFound = $guia !== null;

        return view('GestionarGuias.guias.find', compact('guia', 'guiaFound'));
    }
}
