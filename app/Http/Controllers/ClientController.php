<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Guia;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class ClientController extends Controller
{
    public function index(){
        $userId = Auth::id();

        // Obtener solo los paquetes que pertenecen al usuario autenticado
        $guias = Guia::where('user_id', $userId)->paginate(20);
    
        $ventas = Venta::whereIn('guia_id', $guias->pluck('id'))->get();

        // Pasar los registros paginados y las ventas a la vista
        return view('cliente.index', compact('guias', 'ventas'));

    }

    
/*
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
    }*/
}
