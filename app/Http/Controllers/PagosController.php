<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Curso;
use App\Models\Video;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\User;
use App\Models\DetalleVenta;
use App\Models\Progreso;
use Illuminate\Support\Facades\Redirect;
class PagosController extends Controller{

    public function index(){
        $pagos = Pago::latest('created_at')->paginate(20);

        return view('GestionarVentas.pagos.admin.index',compact('pagos'));
    }

    public function store(Request $request) {
       $user_id = $request->user_id_direct;
       $user = User::find($user_id);
        $ultimaVenta = Venta::where('user_id', $user_id)
        ->orderBy('id', 'desc')
        ->first();

        $existingPago = $ultimaVenta->pago_id;
        $pago = Pago::find($existingPago);
            $pago->fechapago = now();
            $pago->estado = 2;
            $pago->update();

            $ultimaVenta->estado = 2;
            $ultimaVenta->update();

            $detalleVenta = DetalleVenta::where('venta_id', $ultimaVenta->id)->first(['curso_id']);
            // falta preguntar si el progreso existe, si existe no se va a agregar. verificar user_id y curso_id para ver que se hace
    

       session()->flash('mensaje', '¡Pago realizado exitosamente!');
       return Redirect::route('admin.ventas.create');
    }


    // GENERAR COBRO
    public function generarCobro(Request $request){
        $estudianteId = $request->tcUserId;

        do {
            $nroPago = rand(100000, 999999);
            $existe = Pago::where('id', $nroPago)->exists();
        } while ($existe);

        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";  // credencia dado por pagofacil
            $lnMoneda              = 1;
            $lnTelefono            = $request->tnTelefono;
            $lcNombreUsuario       = $request->tcRazonSocial;
            $lnCiNit               = $request->tcCiNit;
            $lcNroPago             = $nroPago; // Genera un número aleatorio entre 100,000 y 999,999   sirve para callback , pedidoID
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo              = $request->tcCorreo;
            $lcUrlCallBack         = route('admin.pagos.callback'); //"https://mail.tecnoweb.org.bo/inf513/grupo03sa/ultimo/public/cursos/pagos/callback";
            $lcUrlReturn           = "";
            $laPedidoDetalle       = $request->taPedidoDetalle;
            $lcUrl                 = "";

            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle,
            ];
            //dd($laBody);
            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                $csrfToken = csrf_token();
                $laValues = explode(";", $laResult->values)[1];
                $nroTransaccion= explode(";", $laResult->values)[0];

                $pago = Pago::create([
                    'id' =>  $nroPago,
                    'fechapago' => now(),
                    'estado' => 1,
                    'metodopago' => 4,   // 4 es Qr
                ]);

                $venta = Venta::create([
                    'id' => $nroTransaccion,
                    'user_id' =>$estudianteId,
                    'pago_id' =>$lcNroPago,
                    'fecha' =>now(),
                    'metodopago' => 4,  // 4 = Qr , 2 = tigo Money
                    'montototal' =>$request->tnMonto,
                    'estado' =>1, // 1 = pendiente , 2 = pago exitos0 , 3 = revertido , 4 = anulado
                ]);



                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                echo $laQrImage ;





            } elseif ($request->tnTipoServicio == 2) {
                $venta = Venta::create([
                    'id' => $laResult->values,
                    'user_id' =>$estudianteId,
                    'fecha' =>now(),
                    'metodopago' =>2,  // 1 = Qr , 2 = tigo Money
                    'montototal' =>$request->tnMonto,
                    'estado' =>1, // 1 = pendiente , 2 = pago exitos0 , 3 = revertido , 4 = anulado
                ]);

                foreach ($laPedidoDetalle as $detalle) {
                $detalleVenta = DetalleVenta::create([
                    'venta_id' =>  $laResult->values,   // tiene el id del pedido por tigo money
                    'curso_id' => $detalle['Serial'],   // Tiene el ID del producto, en este caso, el curso
                    'cantidad' => $detalle['Cantidad'],
                    'total' =>  $detalle['Total'],
                ]);
            }
            $this->numeroPedido = $laResult->values;   // numero de pedido globlal
                $csrfToken = csrf_token();
                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p>
                <p id="tnTransaccion" class="blue-text">'. $laResult->values . '</p><br>';
                echo '<iframe name="QrImage" style="width: 100%; height: 300px;"></iframe>';
                echo '<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>';

                echo '<script>
                        $(document).ready(function() {
                            function hacerSolicitudAjax(numero) {
                                // Agrega el token CSRF al objeto de datos
                                var data = { _token: "' . $csrfToken . '", tnTransaccion: numero };

                                $.ajax({
                                    url: \'/cursos/pagos/consultar\',
                                    type: \'POST\',
                                    data: data,
                                    success: function(response) {
                                        var iframe = document.getElementsByName(\'QrImage\')[0];
                                        iframe.contentDocument.open();
                                        iframe.contentDocument.write(response.message);
                                        iframe.contentDocument.close();
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }

                            setInterval(function() {
                                hacerSolicitudAjax(' . $laResult->values . ');
                            }, 5000);
                        });
                    </script>';
            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }

}
