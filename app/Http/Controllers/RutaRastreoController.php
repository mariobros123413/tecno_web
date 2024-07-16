<?php
namespace App\Http\Controllers;

use App\Models\Guia;
use App\Models\Almacen;
use App\Models\Ruta_Rastreo;
use App\Providers\ContadorService;
use Illuminate\Http\Request;

class RutaRastreoController extends Controller
{
    protected $contadorService;
    public function __construct(ContadorService $contadorService)
    {
        $this->contadorService = $contadorService;
    }
    public function checkInShow()
    {
        $nombre = 'checkin.show';
        $pagina = $this->contadorService->contador($nombre);
        $almacenes = Almacen::paginate(20);
        return view('GestionarRutas.checkin.show', compact('almacenes'))->with('visitas', $pagina);
    }
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
            return response()->json(['message' => 'La guía con el código proporcionado no fue encontrada'], 405);
        }

        $rutaRastreo = $guia->ruta_rastreo()->where('almacen_id', $almacen_id)->first();

        if (!$rutaRastreo) {
            Ruta_Rastreo::create([
                'guia_id' => $guia->id,
                'almacen_id' => $almacen_id,
                'fecha_registro' => date('Y-m-d'),
                'estado' => true
            ]);
            return response()->json([
                'numero' => $guia->user->celular,
                'message' => "Estimad@ *" . $guia->user->name . "*. Su paquete fue registrado en *" .
                    $almacen->nombre . "* ubicado en *" . $almacen->direccion . "*, en fecha *" . now() . "*. Puede realizar el seguimiento con el *MMCA: " .
                    $guia->codigo . "*."
            ], 200);
        }
        $guia->estado = true;
        $guia->save();

        $rutaRastreo->estado = true;
        $rutaRastreo->fecha_registro = date('Y-m-d'); // Asignar la fecha actual
        $rutaRastreo->save();

        return response()->json([
            'numero' => $guia->user->celular,
            'message' => "Estimad@ *" . $guia->user->name . "*. Su paquete fue registrado en *" .
                $almacen->nombre . "* ubicado en *" . $almacen->direccion . "*, en fecha *" . now() . "*. Puede realizar el seguimiento con el *MMCA: " .
                $guia->codigo . "*."
        ], 200);
    }
}