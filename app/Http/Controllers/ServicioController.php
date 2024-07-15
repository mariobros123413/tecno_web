<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Providers\ContadorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ServicioController extends Controller
{
    protected $contadorService;
    public function __construct(ContadorService $contadorService)
    {
        $this->contadorService = $contadorService;
    }
    public function index()
    {
        $nombre = 'servicios.index';
        $pagina = $this->contadorService->contador($nombre);
        $servicios = Servicio::paginate(20);
        return view('GestionarServicios.servicios.index', compact('servicios'))->with('visitas', $pagina);
    }

    public function create()
    {
        $nombre = 'servicios.create';
        $pagina = $this->contadorService->contador($nombre);
        $servicios = Servicio::all();
        return view('GestionarServicios.servicios.create')->with("servicios", $servicios)->with('visitas', $pagina);
    }
    public function edit($servicio_id)
    {
        $nombre = 'servicios.edit';
        $pagina = $this->contadorService->contador($nombre);
        $servicio = Servicio::findOrFail($servicio_id);
        return view('GestionarServicios.servicios.edit')->with("servicio", $servicio)->with('visitas', $pagina);
    }
    public function store(Request $request)
    {

        $Servicio = Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_kilo' => $request->precio_kilo,
        ]);

        return Redirect::route('admin.servicio.create');
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->fill($request->all());
        $servicio->save();
        return Redirect::route('admin.servicios');
    }



    public function destroy($servicio_id)
    {
        $servicio = Servicio::find($servicio_id);
        $servicio->delete();
        return Redirect::route('admin.servicios');
    }
}
