<?php

namespace App\Http\Controllers;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class ServicioController extends Controller
{
    public function index(){
        $servicios  =Servicio::paginate(20);
       return view('GestionarServicios.servicios.index',compact('servicios'));
    }

    public function create(){
        $servicios  = Servicio::all();
        return view('GestionarServicios.servicios.create')->with("servicios", $servicios);
    }

    public function store(Request $request) {

        $Servicio = Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_kilo' => $request->precio_kilo,
        ]);

        return Redirect::route('admin.servicio.create');
    }

    public function update(Request $request, $id){
        $servicio = Servicio::findOrFail($id);
        $servicio->fill($request->all());
        $servicio->save();
        return Redirect::route('admin.servicios');
    }

    public function edit($servicio_id){
        $servicio = Servicio::findOrFail($servicio_id);
        return view('GestionarServicios.servicios.edit')->with("servicio", $servicio);
    }

    public function destroy($servicio_id){
        $servicio = Servicio::find($servicio_id);
        $servicio->delete();
        return Redirect::route('admin.servicios');
    }
}
