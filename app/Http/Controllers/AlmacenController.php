<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class AlmacenController extends Controller
{
    public function index(){
        $almacenes  =Almacen::paginate(20);
       return view('GestionarAlmacenes.almacenes.index',compact('almacenes'));
    }

    public function create(){
        return view('GestionarAlmacenes.almacenes.create');
    }

    public function store(Request $request) {

        $almacen = Almacen::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
        ]);

        return Redirect::route('admin.almacen.create');
    }

    public function update(Request $request, $id){
        $almacen = Almacen::findOrFail($id);
        $almacen->fill($request->all());
        $almacen->save();
        return Redirect::route('admin.almacenes');
    }

    public function edit($almacen_id){
        $almacen = Almacen::findOrFail($almacen_id);
        return view('GestionarAlmacenes.almacenes.edit')->with("almacen", $almacen);
    }

    public function destroy($almacen_id){
        $almacen = Almacen::find($almacen_id);
        $almacen->delete();
        return Redirect::route('admin.almacenes');
    }
}
