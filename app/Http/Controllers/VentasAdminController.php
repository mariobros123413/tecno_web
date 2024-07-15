<?php

namespace App\Http\Controllers;

use App\Providers\ContadorService;
use Illuminate\Http\Request;
use App\Models\Guia;
use App\Models\Paquete;
use App\Models\Almacen;
use App\Models\DetalleVenta;
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
        $ventas = Venta::paginate(20);
        return view('GestionarVentas.ventas.admin.index', compact('ventas'))->with('visitas', $pagina);
    }
    public function create()
    {
        $nombre = 'ventas.admin.create';
        $pagina = $this->contadorService->contador($nombre);
        $users = User::all();
        $paquetes = Paquete::All();
        $almacenes = Almacen::All();
        $servicios = Servicio::All();
        $guias = Guia::All();
        return view('GestionarVentas.ventas.admin.create')->with("users", $users)
            ->with("guias", $guias)
            ->with("almacenes", $almacenes)
            ->with("servicios", $servicios)
            ->with('visitas', $pagina);
    }

    public function edit($venta_id)
    {
        $nombre = 'ventas.admin.edit';
        $pagina = $this->contadorService->contador($nombre);
        $venta = Venta::findOrFail($venta_id);
        $detalleventas = DetalleVenta::all();
        $users = User::all();
        return view('GestionarVentas.ventas.admin.edit')->with("venta", $venta)->with("detalleventas", $detalleventas)->with("users", $users)->with('visitas', $pagina);
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



    public function update(Request $request, $venta_id)
    {
        $venta = Venta::findOrFail($venta_id);
        $venta->fill($request->all());
        $venta->save();
        return Redirect::route('admin.ventas');
    }
    public function destroy($venta_id)
    {
        $venta = Venta::find($venta_id);
        $venta->delete();
        Session::flash('success', 'Venta deleted successfully!');
        return Redirect::route('admin.ventas');
    }

}

