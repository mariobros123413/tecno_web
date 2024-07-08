<?php

namespace App\Http\Controllers;
use App\Models\Servicio;
use App\Models\Whatsapp;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;
class WhatsAppNotificationController extends Controller
{
    public function index(){
        $whatsapps  = Whatsapp::all();
       return view('GestionarNotificaciones.whatsapp.index')->with("whatsapps", $whatsapps);
    }
    public function show(){
        return view('GestionarNotificaciones.whatsapp.show');
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
     // AGREGAR INSTANCIA
     public function instanciastore(Request $request)
     {
         $token ="664603bea607f";
         $lcUrl = "https://whatsapp.desarrollamelo.com/api/create_instance";
         $loClient = new Client();

         $Header = [
             'Accept' => 'application/json'
         ];

         $Body   = [
             'access_token' => $token,
         ];

         $Response = $loClient->get($lcUrl, [
             'headers' => $Header,
             'json' => $Body
         ]);

         $laResult = json_decode($Response->getBody()->getContents());
             $instanceId = $laResult->data->instance_id;

             $whatsapp = new Whatsapp();
             $whatsapp->numero = $instanceId;
             $whatsapp->save();

             $whatsapps = Whatsapp::all();
             return response()->json([
                 'whatsapps' => $whatsapps,
             ], 200);

     }




}
