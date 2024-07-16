<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Providers\ContadorService;
use Illuminate\Http\Request;
use App\Models\Guia;
use App\Models\Paquete;
use App\Models\Almacen;
use App\Models\Venta;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

class VentasAdminController extends Controller
{
    protected $contadorService;
    public function __construct(ContadorService $contadorService)
    {
        $this->contadorService = $contadorService;
    }
    public function index()
    {
        $nombre = 'ventas.admin.index';
        $pagina = $this->contadorService->contador($nombre);
        $ventas = Venta::with(['guia.user', 'pago'])
            ->paginate(20);
        return view('GestionarVentas.ventas.admin.index', compact('ventas'))->with('visitas', $pagina);
    }
    public function create()
    {
        $nombre = 'ventas.admin.create';
        $pagina = $this->contadorService->contador($nombre);
        $users = User::all();
        $almacenes = Almacen::All();
        $servicios = Servicio::All();
        $guias = Guia::all();
        $ventasInvalidas = Venta::where('estado', 2)->pluck('guia_id')->toArray();
        $guiasFiltradas = $guias->reject(function ($guia) use ($ventasInvalidas) {
            return in_array($guia->id, $ventasInvalidas);
        });
        return view('GestionarVentas.ventas.admin.create')->with("users", $users)
            ->with("guias", $guiasFiltradas)
            ->with("almacenes", $almacenes)
            ->with("servicios", $servicios)
            ->with('visitas', $pagina);
    }

    public function edit($venta_id)
    {
        $nombre = 'ventas.admin.edit';
        $pagina = $this->contadorService->contador($nombre);

        $venta = Venta::findOrFail($venta_id);
        return view('GestionarVentas.ventas.admin.edit')->with("venta", $venta)->with('visitas', $pagina);
    }

    public function update($venta_id)
    {
        $venta_existente = Venta::findOrFail($venta_id);
        if ($venta_existente) {
            $venta_existente->estado = 2;
            $venta_existente->save();

            $pago_existente = Pago::where('id_venta', $venta_id)->first();
            if ($pago_existente) {
                $pago_existente->estado = 2;
                $pago_existente->save();
            }

            return response()->json(['message' => 'Estado actualizado', 'venta_id' => $venta_id], 200);
        }

        return response()->json(['message' => 'Error al actualizar los datos de venta/pago', 'venta_id' => $venta_id], 450);
    }
    public function store(Request $request)
    {

        $venta = Venta::create([
            'user_id' => $request->user_id,
            'fecha' => $request->fecha,
            'metodopago' => $request->metodopago,
            'montototal' => $request->montototal,
            'estado' => $request->estado,
        ]);

        return Redirect::route('admin.ventas.create');
    }
    public function destroy($venta_id)
    {
        $venta = Venta::find($venta_id);
        $venta->delete();
        Session::flash('success', 'Venta deleted successfully!');
        return Redirect::route('admin.ventas');
    }

}

