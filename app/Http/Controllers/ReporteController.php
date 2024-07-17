<?php

namespace App\Http\Controllers;

use App\Providers\ContadorService;
use Illuminate\Http\Request;
use App\Models\Ruta_rastreo;
use App\Models\Guia;
use App\Models\Almacen;
use App\Models\Paquete;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    protected $contadorService;
    public function __construct(ContadorService $contadorService)
    {
        $this->contadorService = $contadorService;
    }
    public function index()
    {
        $nombre = 'reportes.index';
        $pagina = $this->contadorService->contador($nombre);
        // Cantidad de paquetes recibidos por almacén
        // $paquetesPorAlmacen = Ruta_rastreo::all()->groupBy('almacen_id')->map(function ($item, $key) {
        //     return $item->count();
        // });

        $paquetesPorAlmacen = DB::table('ruta_rastreo')
            ->join('guia', 'ruta_rastreo.guia_id', '=', 'guia.id')
            ->join('almacen', 'guia.almacen_inicio', '=', 'almacen.id')
            ->select('almacen.nombre', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('almacen.nombre')
            ->get();

        // Monto total de paquetes enviados
        $montoTotalEnviado = Guia::sum('precio');

        // Cantidad de paquetes enviados por cliente
        // $paquetesPorCliente = Guia::selectRaw('user_id, COUNT(*) as cantidad')
        //     ->groupBy('user_id')
        //     ->get();
        $paquetesPorCliente = DB::table('guia')
            ->join('users', 'guia.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('users.name')
            ->get();
        // Cantidad total de paquetes enviados
        $totalPaquetesEnviados = Paquete::count();

        // Cantidad de paquetes enviados por día
        $paquetesPorDia = Guia::selectRaw('DATE(fecha_recepcion) as fecha, COUNT(*) as cantidad')
            ->groupBy('fecha')
            ->get();

        // Cantidad de paquetes enviados por mes
        $paquetesPorMes = Guia::selectRaw('EXTRACT(YEAR FROM fecha_recepcion) as año, EXTRACT(MONTH FROM fecha_recepcion) as mes, COUNT(*) as cantidad')
            ->groupBy('año', 'mes')
            ->get();


        // Cantidad de paquetes enviados por año
        $paquetesPorAño = Guia::selectRaw('EXTRACT(YEAR FROM fecha_recepcion) as año, COUNT(*) as cantidad')
            ->groupBy('año')
            ->get();

        // Obtener todos los datos adicionales que ya tenías
        $guias = Guia::all();
        $almacenes = Almacen::all();
        $paquetes = Paquete::all();

        // Retornar todos los datos a la vista
        return view(
            'GestionarReportes.reportes.index',
            compact(
                'guias',
                'paquetes',
                'almacenes',
                'totalPaquetesEnviados',
                'paquetesPorDia',
                'paquetesPorMes',
                'paquetesPorAño',
                'paquetesPorAlmacen',
                'paquetesPorCliente',
                'montoTotalEnviado'
            )
        )->with('visitas', $pagina);
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
