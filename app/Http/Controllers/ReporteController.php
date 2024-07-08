<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruta_rastreo;
use App\Models\Guia;
use App\Models\Almacen;
use App\Models\Paquete;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        // Cantidad de paquetes recibidos por almacén
        $paquetesPorAlmacen = Ruta_rastreo::all()->groupBy('almacen_id')->map(function ($item, $key) {
            return $item->count();
        });

        // Tiempo promedio de envío de un paquete
        $tiempoPromedioEnvio = Ruta_rastreo::selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as tiempo_promedio')
            ->value('tiempo_promedio');

        // Monto total de paquetes enviados
        $montoTotalEnviado = Guia::sum('precio');

        // Cantidad de paquetes enviados por cliente
        $paquetesPorCliente = Guia::selectRaw('user_id, COUNT(*) as cantidad')
            ->groupBy('user_id')
            ->get();

        // Cantidad total de paquetes enviados
        $totalPaquetesEnviados = Paquete::count();

        // Cantidad de paquetes enviados por día
        $paquetesPorDia = Guia::selectRaw('DATE(fecha_recepcion) as fecha, COUNT(*) as cantidad')
            ->groupBy('fecha')
            ->get();

        // Cantidad de paquetes enviados por mes
        $paquetesPorMes = Guia::selectRaw('YEAR(fecha_recepcion) as año, MONTH(fecha_recepcion) as mes, COUNT(*) as cantidad')
            ->groupBy('año', 'mes')
            ->get();

        // Cantidad de paquetes enviados por año
        $paquetesPorAño = Guia::selectRaw('YEAR(fecha_recepcion) as año, COUNT(*) as cantidad')
            ->groupBy('año')
            ->get();

        // Obtener todos los datos adicionales que ya tenías
        $ruta_rastreos = Ruta_rastreo::all();
        $guias = Guia::all();
        $almacenes = Almacen::all();
        $paquetes = Paquete::all();

        // Retornar todos los datos a la vista
        return view('GestionarReportes.reportes.index', compact(
            'ruta_rastreos', 'guias', 'paquetes', 'almacenes', 'totalPaquetesEnviados',
            'paquetesPorDia', 'paquetesPorMes', 'paquetesPorAño', 'paquetesPorAlmacen',
            'tiempoPromedioEnvio', 'paquetesPorCliente', 'montoTotalEnviado'
        ));
    }

    // Función para paquetes enviados por rango de fechas
    public function paquetesEnviadosPorRangoFechas(Request $request)
    {
        $inicio = Carbon::parse($request->input('inicio'));
        $fin = Carbon::parse($request->input('fin'));

        $paquetesPorRango = Paquete::whereBetween('created_at', [$inicio, $fin])->count();
        return response()->json(['paquetes_enviados' => $paquetesPorRango]);
    }

    // Función para monto total enviado por rango de fechas
    public function montoTotalEnviadoPorRangoFechas(Request $request)
    {
        $inicio = Carbon::parse($request->input('inicio'));
        $fin = Carbon::parse($request->input('fin'));

        $montoTotalPorRango = Paquete::whereBetween('created_at', [$inicio, $fin])->sum('monto');
        return response()->json(['monto_total' => $montoTotalPorRango]);
    }
}
