<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Providers\ContadorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class AlmacenController extends Controller
{
    protected $contadorService;
    public function __construct(ContadorService $contadorService)
    {
        $this->contadorService = $contadorService;
    }
    public function index()
    {
        $almacenes = Almacen::paginate(20);
        $nombre = 'almacenes.index';
        $pagina = $this->contadorService->contador($nombre);

        return view('GestionarAlmacenes.almacenes.index', compact('almacenes'))->with('visitas', $pagina);
    }

    public function create()
    {
        $nombre = 'almacenes.create';
        $pagina = $this->contadorService->contador($nombre);
        return view('GestionarAlmacenes.almacenes.create')->with('visitas', $pagina);
    }
    public function edit($almacen_id)
    {
        $almacen = Almacen::findOrFail($almacen_id);
        $nombre = 'almacenes.edit';
        $pagina = $this->contadorService->contador($nombre);
        return view('GestionarAlmacenes.almacenes.edit')->with("almacen", $almacen)->with('visitas', $pagina);
    }
    public function store(Request $request)
    {

        $almacen = Almacen::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'tax' => $request->tax
        ]);

        return Redirect::route('admin.almacenes');
    }

    public function update(Request $request, $id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->fill($request->all());
        $almacen->save();
        return Redirect::route('admin.almacenes');
    }



    public function destroy($almacen_id)
    {
        $almacen = Almacen::find($almacen_id);
        $almacen->delete();
        return Redirect::route('admin.almacenes');
    }
}
