<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CREAR VENTA') }}
        </h2>
    </x-slot>
    @if(session('mensaje'))
        <div id="mensaje-flash" class="bg-green-200 border border-green-600 text-green-800 px-4 py-3 rounded relative"
            role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('mensaje') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <button class="close-button">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path fill-rule="evenodd"
                            d="M3.293 3.293a1 1 0 011.414 0L10 8.586l5.293-5.293a1 1 0 111.414 1.414L11.414 10l5.293 5.293a1 1 0 01-1.414 1.414L10 11.414l-5.293 5.293a1 1 0 01-1.414-1.414L8.586 10 3.293 4.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </span>
        </div>
    @endif
    <div class="py-2">
        <div class="mx-auto max-w-7xl sm:px-6 lg:py-5">
            <div class="flex justify-center">
                <div class="w-full md:w-1/2 text-center">
                    <h3 class="text-3xl font-bold">PagoFacil QR y Tigo Money</h3>
                    <p class="text-blue-500">integración de servicios PagoFacil.</p>
                    <div class="bg-white shadow-md rounded-md p-6 mt-4">
                        <h5 class="text-center mb-4 text-lg font-semibold">Datos para la factura</h5>
                        <form method="POST" action="{{ route('admin.pagos.generarCobro') }}" target="QrImage">
                            @csrf
                            <x-text-input type="hidden" name="tcUserId" />
                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                <div class="flex flex-col">
                                    <label class="px-3">Buscar Guia</label>
                                    <select id="mySelect" name="tcGuiaCodigo"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        data-twe-select-filter="true">
                                        @foreach($guias as $guia)
                                            <option value="{{ $guia->id }}" data-paquete-id="{{ $guia->paquete_id }}"
                                                data-servicio-id="{{ $guia->servicio_id }}"
                                                data-precio="{{ $guia->precio }}">
                                                {{ $guia->codigo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-text-input type="hidden" id="tcGuiaId" name="tcGuiaId" />
                                    <x-text-input type="hidden" id="tcGuiaCodigo" name="tcGuiaCodigo" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Monto total -->
                                <div class="flex flex-col">
                                    <label class="px-3">Total</label>
                                    <x-text-input type="number" id="tnMonto" name="tnMonto" :value="0.01"
                                        class="border p-2 rounded-md" readonly />
                                </div>
                                <!-- Tipo de servicio -->
                                <div class="flex flex-col">
                                    <label class="px-3">Tipo de Servicio</label>
                                    <select name="tnTipoServicio" class="border p-2 rounded-md">
                                        <option value="1">Servicio QR</option>
                                        <option value="2">Tigo Money</option>
                                    </select>
                                </div>
                            </div>
                            <!-- ... Otros elementos y formulario existentes ... -->
                            <h5 class="text-center mt-4  font-semibold">Datos del Paquete</h5>
                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">

                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex flex-col">
                                    <label class="px-3">ID Paquete</label>
                                    <input type="text" required pattern="[0-9]*" id="taPedidoDetalleSerial"
                                        name="taPedidoDetalle[0][Serial]" class="border p-2 rounded-md"
                                        title="Ingresa solo números" pattern="[0-9]*" required readonly />
                                </div>
                                <div class="flex flex-col">
                                    <label class="px-3">Servicio de envio</label>
                                    <x-text-input type="text" required name="taPedidoDetalle[0][Servicio]"
                                        id="taPedidoDetalleServicio" :value="old('servicio')"
                                        class="border p-2 rounded-md" required readonly />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                <div class="flex flex-col">
                                    <label class="px-3">Descuento</label>
                                    <x-text-input type="number" required name="taPedidoDetalle[0][Descuento]" :value="0"
                                        class="border p-2 rounded-md" required readonly />
                                </div>
                                <div class="flex flex-col">
                                    <label class="px-3">Total</label>
                                    <x-text-input type="text" required name="taPedidoDetalle[0][Total]"
                                        id="taPedidoDetalleTotal" :value="old('precio')" class="border p-2 rounded-md"
                                        required readonly />
                                </div>
                            </div>
                            <!-- ... Otros elementos del formulario ... -->

                            <div class="flex justify-center mt-4">
                                <div class="w-full md:w-1/2">
                                    <x-primary-button class="ms-4">
                                        {{ __('Pagar') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- ... Tu segunda columna existente ... -->
                <div class="md:block md:w-1/2 py-5 justify-center">
                    <div class="flex justify-center">
                        <iframe name="QrImage" style="width: 100%; height: 495px;"></iframe>
                    </div>
                    <div class="flex justify-center">
                        <div class="flex justify-center mt-4">

                            <div id="userModal"
                                class="hidden fixed inset-0 bg-blue-500 bg-opacity-75 flex justify-center items-center">
                                <div class="bg-white p-8 rounded shadow-lg  justify-center items-center">
                                    <p id="mensaje" class="text-xl font-bold mb-4"></p>
                                    @if(Auth::check() && Auth::user()->is_admin == 1)
                                        <div class="  flex justify-center mt-4">
                                            <form method="GET" action="{{ route('admin.ventas') }}">
                                                <x-primary-button id="closeModal" class="mt-4">
                                                    {{ __('Cerrar') }}
                                                </x-primary-button>
                                            </form>
                                        </div>
                                        <div class=" hidden flex justify-center mt-4">
                                            <form method="GET" action="{{ route('admin.ventas') }}">
                                                <x-primary-button id="closeModal" class="mt-4">
                                                    {{ __('Cerrar') }}
                                                </x-primary-button>
                                            </form>
                                        </div>
                                    @endif

                                    @if(Auth::check() && Auth::user()->is_admin == 0)
                                        <div class="  hidden flex justify-center mt-4">
                                            <form method="GET" action="{{ route('admin.ventas') }}">
                                                <x-primary-button id="closeModal" class="mt-4">
                                                    {{ __('Cerrar') }}
                                                </x-primary-button>
                                            </form>
                                        </div>
                                        <div class=" flex justify-center mt-4">
                                            <form method="GET" action="{{ route('admin.ventas') }}">
                                                <x-primary-button id="closeModal" class="mt-4">
                                                    {{ __('Cerrar') }}
                                                </x-primary-button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            window.addEventListener('message', function (event) {
                const scriptReceived = event.data;
                eval(scriptReceived);
            });
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var almacenes = @json($almacenes);
        var users = @json($users);
        var servicios = @json($servicios);
        $(document).ready(function () {
            $('#mySelect').select2({
                placeholder: "Select an option",
                allowClear: true
            }).on('change', function () {
                var valorSeleccionadoString = $(this).val();
                var valorSeleccionado = JSON.parse(valorSeleccionadoString);
                if (valorSeleccionado) {
                    const cedulaUser = users.find(user => user.id === valorSeleccionado.user_id)?.cedula;
                    const celularUser = users.find(user => user.id === valorSeleccionado.user_id)?.celular;
                    const correoUser = users.find(user => user.id === valorSeleccionado.user_id)?.email;
                    const servicio = servicios.find(servicio => servicio.id === valorSeleccionado.servicio_id)?.nombre;
                    // const nombreAlmacen = almacenes.find(almacen => almacen.almacen_id === valorSeleccionado.almacen_id)?.nombre;


                    // Llenar los campos con los valores obtenidos
                    $('input[name="tcGuiaId"]').val(valorSeleccionado.id);
                    $('input[name="tcGuiaCodigo"]').val(valorSeleccionado.codigo);
                    $('input[name="tcUserId"]').val(valorSeleccionado.user_id);
                    $('input[name="tcCiNit"]').val(cedulaUser);
                    $('input[name="tnTelefono"]').val(celularUser);
                    $('input[name="tcCorreo"]').val(correoUser);
                    $('input[name="taPedidoDetalle[0][Serial]"]').val(valorSeleccionado.paquete_id);
                    $('input[name="taPedidoDetalle[0][Servicio]"]').val(servicio);
                    $('input[name="taPedidoDetalle[0][Total]"]').val(valorSeleccionado.precio);
                }
            });
        });
    </script>

    <script>
        document.getElementById('mySelect').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var paqueteId = selectedOption.getAttribute('data-paquete-id');
            var servicioId = selectedOption.getAttribute('data-servicio-id');
            var precio = selectedOption.getAttribute('data-precio');
            console.log(paqueteId);
            console.log(servicioId);
            console.log(precio);
            document.getElementById('tcGuiaId').value = this.value;
            document.getElementById('tcGuiaCodigo').value = selectedOption.text;
            document.getElementById('taPedidoDetalleSerial').value = paqueteId;
            document.getElementById('taPedidoDetalleServicio').value = servicioId;
            document.getElementById('taPedidoDetalleTotal').value = precio;
            document.getElementById('tnMonto').value = precio;
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</x-app-layout>