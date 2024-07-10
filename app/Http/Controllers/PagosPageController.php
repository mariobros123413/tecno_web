<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Guia;
use App\Models\Almacen;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\Paquete;
use App\Models\User;
use App\Models\DetalleVenta;
use App\Models\Progreso;
use Illuminate\Support\Facades\Redirect;

class PagosPageController extends Controller
{

    public function index()
    {
        $pagos = Pago::latest('created_at')->paginate(20);

        return view('GestionarVentas.pagos.admin.index', compact('pagos'));
    }

    public function create()
    {
        $users = User::all();
        $paquetes = Paquete::All();
        $almacenes = Almacen::All();
        $guias = Guia::All();
        return view('GestionarVentas.pagos.index')->with("users", $users)->with("guias", $guias);
    }

    public function store(Request $request)
    {
        $user_id = $request->user_id_direct;
        $user = User::find($user_id);
        $ultimaVenta = Venta::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        $existingPago = $ultimaVenta->pago_id;
        $pago = Pago::find($existingPago);
        $pago->fecha_pago = now();
        $pago->estado = 2;
        $pago->update();

        $ultimaVenta->estado = 2;
        $ultimaVenta->update();

        session()->flash('mensaje', '¡Pago realizado exitosamente!');
        return Redirect::route('admin.ventas.create');
    }


    // GENERAR COBRO
    public function generarCobro(Request $request)
    {
        $guia = Guia::find($request->tcGuiaId);
        $usuario = User::find($guia->user_id);
        do {
            $nroPago = rand(100000, 999999);
            $existe = Pago::where('id', $nroPago)->exists();
        } while ($existe);

        try {
            $lcComerceID = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";  // credencia dado por pagofacil
            $lnMoneda = 1;
            $lnTelefono = (int) $usuario->celular;
            $lcNombreUsuario = $usuario->name;
            $lnCiNit = (int) $usuario->cedula;
            $lnGuiaId = $request->tcGuiaId;
            $lnGuiaCodigo = $request->tcGuiaCodigo;
            $lcNroPago = $nroPago; // Genera un número aleatorio entre 100,000 y 999,999   sirve para callback , pedidoID
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo = $usuario->email;
            $lcUrlCallBack = route('admin.pagos.callback'); //"https://mail.tecnoweb.org.bo/inf513/grupo03sa/ultimo/public/cursos/pagos/callback";
            $lcUrlReturn = "";
            $laPedidoDetalle = $request->taPedidoDetalle;
            $lcUrl = "";

            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody = [
                "tcCommerceID" => $lcComerceID,
                "tnMoneda" => $lnMoneda,
                "tnTelefono" => $lnTelefono,
                'tcNombreUsuario' => $lcNombreUsuario,
                'tnCiNit' => $lnCiNit,
                'tcNroPago' => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo" => $lcCorreo,
                'tcUrlCallBack' => $lcUrlCallBack,
                "tcUrlReturn" => $lcUrlReturn,

            ];
            // dd($laBody);
            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);
            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                $csrfToken = csrf_token();
                $laValues = explode(";", $laResult->values)[1];
                $nroTransaccion = explode(";", $laResult->values)[0];
                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;

                $venta_existente = Venta::where('guia_id', $request->tcGuiaId)->first();
                if ($venta_existente) {
                    $id_venta_ant = $venta_existente->id;
                    $venta_existente->id = $nroTransaccion;
                    $venta_existente->fecha = date('Y-m-d');
                    $venta_existente->monto_total = $request->tnMonto;
                    $venta_existente->image_qr = $laQrImage;
                    $venta_existente->save();

                    $pago_existente = Pago::where('id_venta', $id_venta_ant)->first();
                    $pago_existente->id = $nroPago;
                    $pago_existente->id_venta = $nroTransaccion;
                    $pago_existente->save();
                } else {
                    $pago = Pago::create([
                        'id' => $nroPago,
                        'fecha_pago' => date('Y-m-d'),
                        'estado' => 0,
                        'metodo_pago' => 1,   // 1 es Qr
                        'id_venta' => $nroTransaccion
                    ]);
                    $venta = Venta::create([
                        'id' => $nroTransaccion,
                        'fecha' => date('Y-m-d'),
                        'monto_total' => $request->tnMonto,
                        'estado' => 1, // 1 = pendiente , 2 = pago exitos0 , 3 = revertido , 4 = anulado
                        'guia_id' => $request->tcGuiaId,
                        'image_qr' => $laQrImage
                    ]);
                }
                // Prepara las variables para JavaScript
                $numeroCelular = $usuario->celular; // Asegúrate de tener este valor
                $mensaje = 'Hola estimado/a ' . $lcNombreUsuario . ', ya está disponible el cobro con código Qr para que pueda pagar el paquete : ' . $lnGuiaCodigo;

                echo '<script>
                        var enlace = "https://wa.me/' . $numeroCelular . '?text=" + encodeURIComponent("' . $mensaje . '");
                        window.open(enlace, "_blank");
                      </script>';

                echo '<img src="' . $laQrImage . '" alt="Imagen base64" style="display: block; margin: auto;">';
                echo ' <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
                echo '   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
                echo '<script>
                const scriptToExecute = `
                $(document).ready(function() {
                    const intervalID = setInterval(function() {
                        const xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    const response = xhr.responseText;
                                    if (response.trim() === "COMPLETADO-PROCESADO") {
                                        clearInterval(intervalID);

                                        showModal("Su pedido fue pagado con éxito!!!!");

                                    }
                                }
                            }
                        };

                        // Reemplaza nroTransaccion con el valor correcto
                        const route = ' . json_encode(route('admin.pagos.consultar', ['venta_id' => $nroTransaccion])) . ';
                        xhr.open("GET", route, true);
                        xhr.send();
                    }, 10000);

                    function showModal(mensaje) {
                        const mensaje2  ="Su pedido con MMCA: *' . $lnGuiaCodigo . '* fue cancelado con éxito!, Gracias por elegir nuestro servico.";
                                        notificacionCliente(' . $lnTelefono . ',mensaje2);
                        const modalUserName = document.getElementById("mensaje");
                        if (modalUserName) {
                            modalUserName.textContent = mensaje;
                            const modal = document.getElementById(\'userModal\');
                            if (modal) {
                                modal.classList.remove(\'hidden\');
                            }
                        } else {
                            console.error(\'El elemento con ID "mensaje" no fue encontrado en el DOM\');
                        }
                    }

                    function notificacionCliente(numeroCelular, mensaje) {
                        var enlace = "https://wa.me/" + numeroCelular + "?text=" + encodeURIComponent(mensaje);
                        window.open(enlace, \'_blank\' );
                    }

                    const btn = document.getElementById("closeModal");
                    if(btn){
                       document.getElementById("closeModal").addEventListener("click", function() {
                        const modal = document.getElementById("userModal");
                        modal.classList.add("hidden");
                       });
                     }
                });
                `;

                window.parent.postMessage(scriptToExecute, \'*\');
                
                
            </script>';



            } elseif ($request->tnTipoServicio == 2) {
                $venta = Venta::create([
                    'id' => $laResult->values,
                    'fecha' => date('Y-m-d'),
                    'monto_total' => $request->tnMonto,
                    'estado' => 1, // 1 = pendiente , 2 = pago exitos0 , 3 = revertido , 4 = anulado
                    'guia_id' => $request->tcGuiaId
                ]);
                // foreach ($laPedidoDetalle as $detalle) {
                //     $detalleVenta = DetalleVenta::create([
                //         'venta_id' => $laResult->values,   // tiene el id del pedido por tigo money
                //         'curso_id' => $detalle['Serial'],   // Tiene el ID del producto, en este caso, el curso
                //         'cantidad' => $detalle['Cantidad'],
                //         'total' => $detalle['Total'],
                //     ]);
                // }

                $this->numeroPedido = $laResult->values;   // numero de pedido globlal
                $csrfToken = csrf_token();
                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p>
                <p id="tnTransaccion" class="blue-text">' . $laResult->values . '</p><br>';
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
