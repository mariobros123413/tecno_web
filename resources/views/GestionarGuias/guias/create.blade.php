<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Obologistic</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.whatsapp')
</head>

<body class="bg-gray-100">

    <div class="w-full fixed top-0 z-50 bg-white">
        <!-- Navbar -->
        @include('layouts.navigation')
        <!-- /Navbar -->
    </div>

    <div class="mt-20 mx-auto max-w-6xl px-6 lg:py-20">
        <div class="flex justify-center">
            <div class="w-full lg:w-3/4 xl:w-2/3 text-center">
                <h3 class="text-3xl font-bold">Realiza el registro paso a paso</h3>
                <!-- Barra de progreso -->
                <div class="mt-6 w-full bg-gray-200 h-6 rounded-lg overflow-hidden">
                    <div class="bg-blue-500 h-full transition-all duration-500" style="width: 33%;"></div>
                </div>
                <!-- Formulario -->
                <div class="bg-white shadow-md rounded-md p-6 mt-4">
                    <form method="POST" action="{{ route('admin.guia.store') }}">
                        @csrf
                        <fieldset>
                            <h2 class="text-xl font-semibold mb-4">Paso 1: Seleccionar o Crear Usuario</h2>

                            <div class="mb-4">
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Seleccionar
                                    Usuario</label>
                                <select id="user_id" name="user_id" class="mt-1 p-2 w-full border rounded-md">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }}</option>
                                    @endforeach
                                    <option value="">-- Crear nuevo usuario --</option>

                                </select>
                            </div>

                            <div id="nuevoUsuario" class="hidden">
                                <div class="mb-4">
                                    <label for="dto_nombres"
                                        class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text" id="dto_nombres" name="dto_nombres" placeholder="Nombres"
                                        class="mt-1 p-2 w-full border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="dto_cedula"
                                        class="block text-sm font-medium text-gray-700">Cedula</label>
                                    <input type="number" id="dto_cedula" name="dto_cedula"
                                        placeholder="Cedula de identidad" class="mt-1 p-2 w-full border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="direccion"
                                        class="block text-sm font-medium text-gray-700">Direccion</label>
                                    <input type="text" id="direccion" name="direccion" placeholder="Direccion"
                                        class="mt-1 p-2 w-full border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="correo" class="block text-sm font-medium text-gray-700">E-mail</label>
                                    <input type="text" id="correo" name="correo" placeholder="Correo Electronico"
                                        class="mt-1 p-2 w-full border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                                    <input type="number" id="celular" name="celular" placeholder="Celular"
                                        class="mt-1 p-2 w-full border rounded-md">
                                </div>
                            </div>

                            <button type="button" name="next"
                                class="next bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Siguiente
                            </button>
                        </fieldset>

                        <!-- Paso 2: Agregar Paquete -->
                        <fieldset class="hidden">
                            <h2 class="text-xl font-semibold mb-4">Paso 2: Registra el Paquete</h2>
                            <div class="mb-4">
                                <label for="dimensiones"
                                    class="block text-sm font-medium text-gray-700">Dimensiones</label>
                                <input type="text" id="dimensiones" name="dto_dimensiones" placeholder="Dimensiones"
                                    class="mt-1 p-2 w-full border rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="peso" class="block text-sm font-medium text-gray-700">Peso</label>
                                <input type="text" id="peso" name="dto_peso" placeholder="Peso del Paquete"
                                    class="mt-1 p-2 w-full border rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="fecha_recepcion" class="block text-sm font-medium text-gray-700">Fecha de
                                    Salida</label>
                                <input type="date" id="fecha_recepcion" name="dto_fechaSalida"
                                    class="mt-1 p-2 w-full border rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="fecha_entrega" class="block text-sm font-medium text-gray-700">Fecha de
                                    Llegada</label>
                                <input type="date" id="fecha_entrega" name="dto_fechaLlegada"
                                    class="mt-1 p-2 w-full border rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="almacen_id_inicio"
                                    class="block text-sm font-medium text-gray-700">Seleccionar
                                    Almacen Inicio</label>
                                <select id="almacen_id_inicio" name="almacen_id_inicio"
                                    class="mt-1 p-2 w-full border rounded-md">
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->id }} - {{ $almacen->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="almacen_id_final"
                                    class="block text-sm font-medium text-gray-700">Seleccionar
                                    Almacen Destino</label>
                                <select id="almacen_id_final" name="almacen_id_final"
                                    class="mt-1 p-2 w-full border rounded-md">
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->id }} - {{ $almacen->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="servicio_id" :value="__('Seleccionar Servicio')" />
                                <div class="mt-4">
                                    <select id="servicio_id" name="dto_servicio_id" onchange="actualizarPrecio()"
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @foreach($servicios as $servicio)
                                            <option value="{{$servicio->id}}" data-atributo="{{$servicio->precio_kilo}}">
                                                {{$servicio->nombre}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="montoTotal" class="block text-sm font-medium text-gray-700">Monto Total a
                                    Pagar</label>
                                <input type="number" id="monto_total" name="monto_total"
                                    class="mt-1 p-2 w-full border rounded-md" required>
                            </div>

                            <button type="button" name="previous"
                                class="previous bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Previo
                            </button>
                            <button type="button" id="btnCapturar"
                                class="submit bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Enviar
                            </button>
                        </fieldset>
                    </form>
                    <div class="flex justify-center">
                        <div class="flex justify-center mt-4">
                            <div class="flex justify-center">
                                <div id="userModal"
                                    class="hidden fixed inset-0 bg-blue-500 bg-opacity-75 flex justify-center items-center">
                                    <div class="bg-white p-8 rounded shadow-lg  justify-center items-center">
                                        <p id="mensaje" class="text-xl font-bold mb-4"></p>
                                        <div class="flex justify-center mt-4">
                                            <form method="GET" action="{{ route('admin.guias') }}">
                                                @csrf
                                                <x-primary-button id="closeModal" class="mt-4">
                                                    {{ __('Cerrar') }}
                                                </x-primary-button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const btnCapturar = $('#btnCapturar');

            if (btnCapturar.length) {
                btnCapturar.click(function () {
                    const requiredFields = [
                        '#user_id',
                        '#dimensiones', '#peso', '#fecha_recepcion', '#fecha_entrega', '#servicio_id',
                        '#monto_total', '#almacen_id_inicio', '#almacen_id_final'
                    ];

                    let valid = true;
                    requiredFields.forEach(function (field) {
                        if (!$(field).val()) {
                            valid = false;
                            $(field).addClass('border-red-500');
                        } else {
                            $(field).removeClass('border-red-500');
                        }
                    });

                    if (!valid) {
                        alert('Por favor, complete todos los campos requeridos.');
                        return;
                    }
                    const user_id = $('#user_id').val();
                    const nombre = $('#dto_nombres').val();
                    const cedula = $('#dto_cedula').val();
                    const celular = $('#celular').val();
                    const direccion = $('#direccion').val();
                    const correo = $('#correo').val();
                    const dimensiones = $('#dimensiones').val();
                    const peso = $('#peso').val();
                    const fecha_recepcion = $('#fecha_recepcion').val();
                    const fecha_entrega = $('#fecha_entrega').val();
                    const servicio_id = $('#servicio_id').val();
                    const monto_total = $('#monto_total').val();
                    const almacen_id_inicio = $('#almacen_id_inicio').val();
                    const almacen_id_final = $('#almacen_id_final').val();
                    const datos = {
                        user_id,
                        nombre,
                        cedula,
                        celular,
                        direccion,
                        correo,
                        dimensiones,
                        peso,
                        fecha_recepcion,
                        fecha_entrega,
                        servicio_id,
                        monto_total,
                        almacen_id_inicio,
                        almacen_id_final,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };
                    console.log(datos);
                    $.ajax({
                        url: '/admin-guia/store',
                        type: 'POST',
                        data: datos,
                        headers: {
                            'X-CSRF-TOKEN': datos._token
                        },
                        success: function (response, status, xhr) {
                            console.log(xhr.status);
                            if (xhr.status === 200) {
                                const mensaje = "Su pedido fue registrado exitosamente :) , Puede realizar el seguimiendo de su pedido en nuestra aplicacion movil.";
                                notificacionCliente(response.celular, mensaje);
                                $('#userModal').removeClass('hidden');
                                $('#mensaje').text(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            } else {
                console.error('No se encontró el botón btnCapturar.');
            }
        });
        function notificacionCliente(numeroCelular, mensaje) {
            var enlace = "https://wa.me/" + numeroCelular + "?text=" + encodeURIComponent(mensaje);
            window.open(enlace, '_blank');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSelect = document.getElementById('user_id');
            const nuevoUsuarioDiv = document.getElementById('nuevoUsuario');
            const nextButton = document.querySelector('button[name="next"]');
            const submitButton = document.querySelector('button[type="submit"]');
            const fieldsets = document.querySelectorAll('fieldset');

            userSelect.addEventListener('change', function () {
                if (this.value === '') {
                    nuevoUsuarioDiv.classList.remove('hidden');
                } else {
                    nuevoUsuarioDiv.classList.add('hidden');
                }
            });

            nextButton.addEventListener('click', function () {
                fieldsets[0].classList.add('hidden');
                fieldsets[1].classList.remove('hidden');
            });

            submitButton.addEventListener('click', function () {
                // Validar el formulario si es necesario
                document.querySelector('form').submit();
            });
        });
    </script>
    <script>
        function actualizarPrecio() {
            const servicioSelect = document.getElementById('servicio_id');
            const selectedServiceOption = servicioSelect.options[servicioSelect.selectedIndex];
            const precioKilo = parseFloat(selectedServiceOption.getAttribute('data-atributo'));
            if (!isNaN(precioKilo)) {
                const peso = parseFloat(document.getElementById('peso').value);
                const montoTotal = peso * precioKilo;
                document.getElementById('monto_total').value = montoTotal.toFixed(2);
            } else {
                console.error('Precio por kilo no válido.');
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let current = 1;
            const steps = document.querySelectorAll("fieldset").length;
            const progressBar = document.querySelector(".bg-blue-500");

            document.querySelectorAll(".next").forEach(button => {
                button.addEventListener("click", () => {
                    const currentStep = button.closest("fieldset");
                    const nextStep = currentStep.nextElementSibling;
                    if (nextStep) {
                        currentStep.classList.add("hidden");
                        nextStep.classList.remove("hidden");
                        current++;
                        setProgressBar(current);
                    }
                });
            });

            document.querySelectorAll(".previous").forEach(button => {
                button.addEventListener("click", () => {
                    const currentStep = button.closest("fieldset");
                    const previousStep = currentStep.previousElementSibling;
                    if (previousStep) {
                        currentStep.classList.add("hidden");
                        previousStep.classList.remove("hidden");
                        current--;
                        setProgressBar(current);
                    }
                });
            });

            function setProgressBar(curStep) {
                const percent = ((curStep - 1) / (steps - 1)) * 100;
                progressBar.style.width = percent + "%";
                progressBar.innerHTML = percent.toFixed(0) + "%";

                console.log("Current Step: " + curStep);
                console.log("Percent: " + percent);
            }

            setProgressBar(current);
        });
    </script>
</body>

</html>