<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Paquete;
use App\Models\Guia;
use App\Models\Almacen;
use App\Models\Servicio;
use App\Models\Pago;
use App\Models\Venta;
use App\Models\Vertice;
use App\Models\Ruta;
use App\Models\Arco;
use GuzzleHttp\Client;
use App\Models\Ruta_Rastreo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class RutaRastreoController extends Controller
{

    public function checkIn(Request $request)
{
    $guia_id = $request->guia_id;
    $almacen_id = $request->almacen_id;
    $almacen = Almacen::find($almacen_id);
    if (!$guia_id || !$almacen_id || !$almacen) {
        return response()->json(['message' => 'Los datos proporcionados son inválidos'], 400);
    }

    $guia = Guia::find($guia_id);

    if (!$guia) {
        return response()->json(['message' => 'La guía con el código proporcionado no fue encontrada'], 404);
    }

    $rutaRastreo = $guia->ruta_rastreo()->where('almacen_id', $almacen_id)->first();

    if (!$rutaRastreo) {
        return response()->json(['message' => 'No se encontró ninguna ruta de rastreo con ese id de almacen'], 404);
    }

    $rutaRastreo->estado = 1;
    $rutaRastreo->save();

    return response()->json([
        'numero' => $guia->user->celular,
        'message' => "Estimad@ *" . $guia->user->name . "*. Su paquete fue registrado en *" .
        $almacen->nombre ."* ubicado en *".$almacen->direccion . "*, en fecha *" . now() . "*. Puede realizar el seguimiento con el *MMCA: " .
         $guia->codigo . "*."
    ], 200);
}


}
