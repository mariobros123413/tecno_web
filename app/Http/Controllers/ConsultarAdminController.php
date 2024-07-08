<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\Venta;
use App\Models\DetalleVenta;


class ConsultarAdminController extends Controller{
    /**
     * Handle the incoming request.
     */
    public function __invoke($venta_id){

        $ventaEnCurso = Venta::findOrFail($venta_id);

                $idUltimaVenta = $venta_id;//$ultimaVenta->id;
                $loClientEstado = new Client();
                $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";
                $laHeaderEstadoTransaccion = [
                    'Accept' => 'application/json'
                ];

                $laBodyEstadoTransaccion = [
                    "TransaccionDePago" => $idUltimaVenta
                ];
                $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
                    'headers' => $laHeaderEstadoTransaccion,
                    'json' => $laBodyEstadoTransaccion
                ]);

               // Decode the JSON response
                      $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());
                    if ($laResultEstadoTransaccion && isset($laResultEstadoTransaccion->values->messageEstado)) {
                            $cadenaCompleta = $laResultEstadoTransaccion->values->messageEstado;
                                $elementos = explode(' - ', $cadenaCompleta);
                                if (count($elementos) >= 2) {
                                    $textoExtraido = $elementos[0] . '-' . $elementos[1];
                                    return $textoExtraido;

                                } else {
                                    return "Error";
                                }
                            }
                            }
                      //  }
    //}

}
