<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruta;
use App\Models\Ruta_Rastreo;
use App\Models\Arco;
use App\Models\Vertice;
use App\Models\Almacen;
use Illuminate\Support\Facades\Redirect;
class RutasController extends Controller
{
    public function index(){
        $rutas  =Ruta::paginate(20);
       return view('GestionarRutas.rutas.index',compact('rutas'));
    }

    public function create(){
        return view('GestionarRutas.rutas.create');
    }

    public function store(Request $request) {

        $ruta = Ruta::create([
            'nombre' => $request->nombre,
        ]);

        return Redirect::route('admin.rutas');
    }

    public function update(Request $request, $id){
        $ruta = Ruta::findOrFail($id);
        $ruta->fill($request->all());
        $ruta->save();
        return Redirect::route('admin.rutas');
    }

    public function show($ruta_id){
        $ruta = Ruta::findOrFail($ruta_id);
        return view('GestionarRutas.rutas.show')->with("ruta", $ruta);
    }


    public function edit($ruta_id){
        $ruta = Ruta::findOrFail($ruta_id);
        return view('GestionarRutas.rutas.edit')->with("ruta", $ruta);
    }

    public function destroy($ruta_id){
        $ruta = Ruta::find($ruta_id);
        $ruta->delete();
        return Redirect::route('admin.rutas');
    }


     // AGREGAR VERTICE
     public function verticestore(Request $request)
    {
        // Validar y guardar el vértice
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'ruta_id' => 'required|integer', // Ajusta según tus requisitos
        ]);

        $vertice = new Vertice();
        $vertice->nombre = $validatedData['nombre'];
        $vertice->ruta_id = $validatedData['ruta_id'];
        $vertice->save();

        $almacen = new Almacen();
        $almacen->nombre = $validatedData['nombre'];
        $almacen->direccion =$request->direccion;
        $almacen->save();

        // Obtener los vértices actualizados para la ruta
    $ruta = Ruta::find($validatedData['ruta_id']);
    $vertices = $ruta->vertices;

    // Devolver una respuesta JSON con los vértices actualizados
    return response()->json([
        'vertices' => $vertices,
        'last_inserted_id' => $vertice->id // Opcional: devolver el ID del vértice recién agregado
    ], 200);
    }


 // AGREGAR ARCO
 public function arcostore(Request $request)
 {
     // Validar y guardar el arco
     $validatedData = $request->validate([
         'peso' => 'required|numeric',
         'vertice_origen_id' => 'required|integer',
         'vertice_destino_id' => 'required|integer',
     ]);

     $arco = new Arco();
     $arco->peso = $validatedData['peso'];
     $arco->vertice_origen_id = $validatedData['vertice_origen_id'];
     $arco->vertice_destino_id = $validatedData['vertice_destino_id'];
     $arco->save();

     // Obtener los arcos actualizados
     $arcos = Arco::all(); // O cualquier lógica para obtener los arcos que necesites

     // Devolver una respuesta JSON con los arcos actualizados
     return response()->json([
         'arcos' => $arcos,
     ], 200);
 }
// CHECK-IN SHOW
 public function checkInShow(){
    $almacenes =Almacen::paginate(20);
   return view('GestionarRutas.checkin.show',compact('almacenes'));
}

public function verticestoreMasivo(Request $request)
{
    $paisesDirecciones = [
        ['nombre' => 'Argentina', 'direccion' => 'Av. 9 de Julio, Buenos Aires, Argentina'],
        ['nombre' => 'Bolivia', 'direccion' => 'Av. Mariscal Santa Cruz, La Paz, Bolivia'],
        ['nombre' => 'Brasil', 'direccion' => 'Av. Paulista, São Paulo, Brasil'],
        ['nombre' => 'Chile', 'direccion' => 'Av. Libertador Bernardo O\'Higgins, Santiago, Chile'],
        ['nombre' => 'Colombia', 'direccion' => 'Cra. 7, Bogotá, Colombia'],
        ['nombre' => 'Ecuador', 'direccion' => 'Av. 6 de Diciembre, Quito, Ecuador'],
        ['nombre' => 'Paraguay', 'direccion' => 'Av. Eusebio Ayala, Asunción, Paraguay'],
        ['nombre' => 'Perú', 'direccion' => 'Av. Arequipa, Lima, Perú'],
        ['nombre' => 'Uruguay', 'direccion' => 'Av. 18 de Julio, Montevideo, Uruguay'],
        ['nombre' => 'Venezuela', 'direccion' => 'Av. Libertador, Caracas, Venezuela'],
    ];

    $validatedData = $request->validate([
        'ruta_id' => 'required|integer',
    ]);

    $ruta_id = $validatedData['ruta_id'];

    $vertices = [];
    $almacenes = [];

    foreach ($paisesDirecciones as $paisDireccion) {
        $vertices[] = [
            'nombre' => $paisDireccion['nombre'],
            'ruta_id' => $ruta_id,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $almacenes[] = [
            'nombre' => $paisDireccion['nombre'],
            'direccion' => $paisDireccion['direccion'],
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    Vertice::insert($vertices);
    Almacen::insert($almacenes);

    $ruta = Ruta::find($ruta_id);
    $verticesActualizados = $ruta->vertices;

    // Agregar arcos masivo
    foreach ($verticesActualizados as $vertice) {
        $arcosExistentes = [];
        $numeroDeArcos = rand(2, 4);
        $verticesDestino = $verticesActualizados->where('id', '!=', $vertice->id)->random($numeroDeArcos);

        foreach ($verticesDestino as $destino) {
            if (!in_array($destino->id, $arcosExistentes)) {
                $arcosExistentes[] = $destino->id;

                $arco = new Arco();
                $arco->peso = rand(1, 100);
                $arco->vertice_origen_id = $vertice->id;
                $arco->vertice_destino_id = $destino->id;
                $arco->save();
            }
        }
    }

    return response()->json([
        'vertices' => $verticesActualizados,
        'last_inserted_ids' => Vertice::where('ruta_id', $ruta_id)->pluck('id')->take(count($paisesDirecciones))
    ], 200);
}

}
