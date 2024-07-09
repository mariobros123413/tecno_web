<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Paquete;
use App\Models\Guia;
use App\Models\Almacen;
use App\Models\Servicio;
use App\Models\Ruta_Rastreo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GuiaController extends Controller
{
    public function index()
    {
        $guias = Guia::paginate(10);
        return view('GestionarGuias.guias.index', compact('guias'));
    }

    public function create()
    {
        $paquetes = Paquete::all();
        $users = User::all();
        $servicios = Servicio::all();
        $almacenes = Almacen::all();
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
    public function store(Request $request)
    {
        //dd($request->all());
        $codigo = $this->generarCodigoUnico(20);
        try {
            // Datos del cliente
            $user_id = $request->input('user_id');
            $nombre = $request->input('nombre');
            $cedula = $request->input('cedula');
            $celular = $request->input('celular');
            $direccion = $request->input('direccion');
            $correo = $request->input('correo');

            // Datos del paquete
            $dimensiones = $request->input('dimensiones');
            $peso = $request->input('peso');
            $fecha_recepcion = $request->input('fecha_recepcion');
            $fecha_entrega = $request->input('fecha_entrega');
            $servicio_id = $request->input('servicio_id');
            $monto_total = $request->input('monto_total');

            // Datos del almacén final
            $almacen_id_final = $request->input('almacen_id_final');
            $almacen_id_inicio = $request->input('almacen_id_inicio');

            if (!$user_id) {
                $user = User::create([
                    'name' => $nombre,
                    'cedula' => $cedula,
                    'celular' => $celular,
                    'direccion' => $direccion,
                    'email' => $correo,
                    'password' => Hash::make("12313123"),
                    'is_admin' => 0,
                ]);
            } else {
                $user = User::findOrFail($user_id);
            }
            $paquete = Paquete::create([
                'dimensiones' => $dimensiones,
                'peso' => $peso,
            ]);

            $userId = $user->id;
            $paqueteId = $paquete->id;
            $guiac = Guia::create([
                'user_id' => $userId,
                'paquete_id' => $paqueteId,
                'almacen_inicio' => $almacen_id_final,
                'almacen_final' => $almacen_id_inicio,
                'fecha_recepcion' => $fecha_recepcion,
                'fecha_entrega' => $fecha_entrega,
                'estado' => false,
                'servicio_id' => $servicio_id,
                'precio' => $monto_total,
                'codigo' => $codigo,
            ]);

            Ruta_Rastreo::create([
                'guia_id' => $guiac->id,
                'almacen_id' => $almacen_id_final,
                'fecha_registro' => date('Y-m-d'),
                'estado' => false
            ]);
            return response()->json([
                'message' => 'Datos guardados correctamente',
                'MMCA' => $codigo,
                'celular' => $user->celular,
            ], 200);
        } catch (\Exception $e) {

            //\Log::error('Error al procesar la solicitud: ' . $e->getMessage());

            return response()->json(['error' => 'Error interno del servidor : ', $e], 501);
        }
    }

    public function update(Request $request, $id)
    {
        $paquete = Paquete::findOrFail($id);
        $paquete->fill($request->all());
        $paquete->save();
        return Redirect::route('admin.guias');
    }

    public function edit($paquete_id)
    {
        $paquete = Paquete::findOrFail($paquete_id);
        return view('GestionarPaquetes.paquetes.edit')->with("paquete", $paquete);
    }

    public function show($guia_id)
    {
        $guia = Guia::findOrFail($guia_id);
        return view('GestionarGuias.guias.show')->with("guia", $guia);
    }

    public function destroy($guia_id)
    {
        $guia = Guia::find($guia_id);
        if ($guia) {
            $paquete_id = $guia->paquete_id;
            $paquete = Paquete::find($paquete_id);
            $ruta_rastreos = Ruta_Rastreo::where('guia_id', $guia_id)->get();

            if ($paquete) {
                $paquete->delete();
            }
            foreach ($ruta_rastreos as $ruta_rastreo) {
                $ruta_rastreo->delete();
            }
            $guia->delete();
        }
        return Redirect::route('admin.guias');
    }

}
