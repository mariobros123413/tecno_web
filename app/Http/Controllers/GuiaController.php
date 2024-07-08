<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Paquete;
use App\Models\Guia;
use App\Models\Almacen;
use App\Models\Servicio;
use App\Models\Pago;
use App\Models\Venta;
use App\Models\Vertice;
use App\Models\Ruta;
use App\Models\Arco;
use GuzzleHttp\Client;
use App\Models\Ruta_Rastreo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect; // Asegúrate de importar la clase Redirect si decides usar Redirect::route()

class GuiaController extends Controller
{
    public function index(){
        $guias  =Guia::paginate(10);
       return view('GestionarGuias.guias.index',compact('guias'));
    }

    public function create(){
        $paquetes  = Paquete::all();
        $users  = User::all();
        $servicios  = Servicio::all();
        $almacenes  = Almacen::all();
        return view('GestionarGuias.guias.create')->with("users", $users)->with("paquetes", $paquetes)
        ->with("servicios", $servicios)->with("almacenes", $almacenes);
    }
    public function generarCodigoUnico($longitud = 10)
    {
        $caracteresPermitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $codigo = '';

        do {
            $codigo = '';
            for ($i = 0; $i < $longitud; $i++) {
                $codigo .= $caracteresPermitidos[rand(0, strlen($caracteresPermitidos) - 1)];
            }
            $existeCodigo = Guia::where('codigo', $codigo)->exists();
        } while ($existeCodigo);

        return $codigo;
    }
    public function store(Request $request) {
        $codigo = $this->generarCodigoUnico(20);
        try {
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $cedula = $request->input('cedula');
        $celular = $request->input('celular');
        $fecha_nacimiento = $request->input('fecha_nacimiento');
        $direccion = $request->input('direccion');
        $correo = $request->input('correo');
        $dimensiones = $request->input('dimensiones');
        $peso = $request->input('peso');
        $fecha_recepcion = $request->input('fecha_recepcion');
        $fecha_entrega = $request->input('fecha_entrega');
        $servicio_id = $request->input('servicio_id');
        $verticeOrigeniId = $request->input('verticeOrigenId');
        $verticeDestinoiId = $request->input('verticeDestinoId');
        $monto_total = $request->input('monto_total');
        $valoresLista = $request->input('valoresLista');

        $userFind = User::where('cedula', $cedula)->first();

        if(!$userFind){
        $user = User::create([
            'name' => $nombre,
            'cedula' => $cedula,
            'celular' => $celular,
            'direccion' => $direccion,
            'email' => $correo,
            'password' => Hash::make("12313123"),
            'is_admin' => 0,
        ]);

        $userUpdate = User::findOrFail($user->id);
        $userUpdate->cedula = $cedula;
        $userUpdate->celular = $celular;
        $userUpdate->direccion = $direccion;
        $userUpdate->save();

        $paquete = Paquete::create([
            'dimensiones' => $dimensiones,
            'peso' => $peso,
        ]);

        $userId = $user->id;
        $paqueteId = $paquete->id;
        $guia = Guia::create([
            'user_id' => $userId,
            'paquete_id' => $paqueteId,
            'servicio_id' => $servicio_id,
            'almacen_inicio' => $verticeOrigeniId,
            'almacen_final' => $verticeDestinoiId,
            'fecha_recepcion' => $fecha_recepcion,
            'fecha_entrega' => $fecha_entrega,
            'precio' => $monto_total,
            'codigo' => $codigo,
            'estado' => 0,
        ]);

        $guiaId = $guia->id;
        foreach ($valoresLista as $valores) {
            $rutaRastreo = Ruta_Rastreo::create([
                'guia_id' => $guiaId,
                'almacen_id' => $valores,
                'fecha_registro' => now(),
                'estado' => 0 ,
            ]);
        }

        $rutaRastreo2 = Ruta_Rastreo::where('guia_id', $guiaId)
        ->where('almacen_id', $verticeOrigeniId)
        ->orderBy('id', 'desc')
        ->first();

        $existeRuta = $rutaRastreo2->id;
        $ruta_rastreo = Ruta_Rastreo::find($existeRuta );
            $ruta_rastreo->estado = 1;
            $ruta_rastreo->save();

    }else{
        $userUpdate = User::findOrFail($userFind->id);
        $userUpdate->cedula = $cedula;
        $userUpdate->celular = $celular;
        $userUpdate->direccion = $direccion;
        $userUpdate->save();

        $paquete = Paquete::create([
            'dimensiones' => $dimensiones,
            'peso' => $peso,
        ]);

        $userId = $userFind->id;
        $paqueteId = $paquete->id;
        $guia = Guia::create([
            'user_id' => $userId,
            'paquete_id' => $paqueteId,
            'servicio_id' => $servicio_id,
            'almacen_inicio' => $verticeOrigeniId,
            'almacen_final' => $verticeDestinoiId,
            'fecha_recepcion' => $fecha_recepcion,
            'fecha_entrega' => $fecha_entrega,
            'precio' => $monto_total,
            'codigo' => $codigo,
            'estado' => 0,
        ]);

        $guiaId = $guia->id;
        foreach ($valoresLista as $valores) {
            $rutaRastreo = Ruta_Rastreo::create([
                'guia_id' => $guiaId,
                'almacen_id' => $valores,
                'fecha_registro' => now(),
                'estado' => 0 ,
            ]);
        }

        $rutaRastreo2 = Ruta_Rastreo::where('guia_id', $guiaId)
        ->where('almacen_id', $verticeOrigeniId)
        ->orderBy('id', 'desc')
        ->first();

        $existeRuta = $rutaRastreo2->id;
        $ruta_rastreo = Ruta_Rastreo::find($existeRuta );
            $ruta_rastreo->estado = 1;
            $ruta_rastreo->save();
    }
    return response()->json(['message' => 'Datos guardados correctamente', 'MMCA' => $codigo], 200);

    } catch (\Exception $e) {

        \Log::error('Error al procesar la solicitud: ' . $e->getMessage());

        return response()->json(['error' => 'Error interno del servidor'], 500);
    }
    }

    public function update(Request $request, $id){
        $paquete = Paquete::findOrFail($id);
        $paquete->fill($request->all());
        $paquete->save();
        return Redirect::route('admin.guias');
    }

    public function edit($paquete_id){
        $paquete = Paquete::findOrFail($paquete_id);
        return view('GestionarPaquetes.paquetes.edit')->with("paquete", $paquete);
    }

    public function show($guia_id){
        $guia = Guia::findOrFail($guia_id);
        return view('GestionarGuias.guias.show')->with("guia", $guia);
    }

    public function destroy($paquete_id){
        $paquete = Paquete::find($paquete_id);
        $paquete->delete();
        return Redirect::route('admin.paquetes');
    }




}
