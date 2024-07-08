<?php

namespace App\Http\Controllers;

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
    public function index(){
        $ventas = Venta::paginate(20);
       return view('GestionarVentas.ventas.admin.index',compact('ventas'));
    }
    public function create(){
        $users  = User::all();
        $paquetes = Paquete::All();
        $almacenes = Almacen::All();
        $servicios = Servicio::All();
        $guias = Guia::All();
        return view('GestionarVentas.ventas.admin.create')->with("users", $users)
                                                            ->with("guias", $guias)
                                                            ->with("almacenes", $almacenes)
                                                            ->with("servicios", $servicios);
    }


    public function store(Request $request) {

        $venta = Venta::create([
            'user_id' => $request->user_id,
            'fecha' => $request->fecha,
            'metodopago' => $request->metodopago,
            'montototal' => $request->montototal,
            'estado' => $request->estado,
        ]);

        return Redirect::route('admin.ventas.create');
    }

    public function edit($venta_id){
        $venta = Venta::findOrFail($venta_id);
        $detalleventas= DetalleVenta::all();
        $users= User::all();
        return view('GestionarVentas.ventas.admin.edit')->with("venta", $venta)->with("detalleventas", $detalleventas)->with("users", $users);
    }

    public function update(Request $request, $venta_id){
        $venta = Venta::findOrFail($venta_id);
        $venta->fill($request->all());
        $venta->save();
        return Redirect::route('admin.ventas');
    }
    public function destroy($venta_id){
        $venta = Venta::find($venta_id);
        $venta->delete();
        Session::flash('success', 'Venta deleted successfully!');
        return Redirect::route('admin.ventas');
    }

}

