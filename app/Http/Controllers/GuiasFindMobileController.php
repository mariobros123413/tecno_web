<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Guia;
use Illuminate\Database\Eloquent\Builder;

class GuiasFindMobileController extends Controller
{

    public function search($guia_codigo)
    {
        $guia = Guia::with(['ruta_rastreo.almacen'])->where('codigo', $guia_codigo)->first();
        if ($guia) {
            // Formatear la respuesta para incluir el nombre del almacén y la dirección
            $ruta_rastreo = $guia->ruta_rastreo->map(function($ruta) {
                return [
                    'estado' => $ruta->estado,
                    'updated_at' => $ruta->updated_at,
                    'almacen_nombre' => $ruta->almacen->nombre,
                    'almacen_direccion' => $ruta->almacen->direccion,
                ];
            });

            $guia->ruta_rastreo = $ruta_rastreo;

            return response()->json(['success' => true, 'guia' => $guia], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Guía no encontrada'], 404);
        }
    }


}
