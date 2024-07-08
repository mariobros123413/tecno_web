<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\Area;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
class PaqueteController extends Controller
{
    public function index(){
        $paquetes  =Paquete::paginate(20);
       return view('GestionarPaquetes.paquetes.index',compact('paquetes'));
    }

    public function create(){
        $paquetes  = Paquete::all();
        return view('GestionarPaquetes.paquetes.create')->with("paquetes", $paquetes);
    }

    public function store(Request $request) {

        $paquete = Paquete::create([
            'dimensiones' => $request->dimensiones,
            'peso' => $request->peso,
        ]);

        return Redirect::route('admin.paquete.create');
    }

    public function update(Request $request, $id){
        $paquete = Paquete::findOrFail($id);
        $paquete->fill($request->all());
        $paquete->save();
        return Redirect::route('admin.paquetes');
    }

    public function edit($paquete_id){
        $paquete = Paquete::findOrFail($paquete_id);
        return view('GestionarPaquetes.paquetes.edit')->with("paquete", $paquete);
    }

    public function destroy($paquete_id){
        $paquete = Paquete::find($paquete_id);
        $paquete->delete();
        return Redirect::route('admin.paquetes');
    }
}
