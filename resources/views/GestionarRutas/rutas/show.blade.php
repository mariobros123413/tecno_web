<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obologistic</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="w-full fixed top-0 z-50 bg-white">
        <!-- Navbar -->
        @include('layouts.navigation')
        <!-- Incluye tu navegación aquí -->
    </div>

    <div class="mt-20 mx-auto max-w-6xl px-6 lg:py-20">
        <div class="flex justify-center">
            <div class="w-full lg:w-3/4 xl:w-2/3 text-center">
                <h3 class="text-3xl font-bold">Creación de Caminos</h3>

                <!-- Formulario para agregar vértices -->
                <div class="bg-white shadow-md rounded-md p-6 mt-4">
                    <h5 class="text-center mb-4 text-lg font-semibold">Agregar almacen (Vértice)</h5>

                    <form id="formAgregarVertice" method="POST" action="{{ route('admin.ruta.verticestore') }}">
                        @csrf
                        <input type="hidden" name="ruta_id" value="{{ $ruta->id }}" />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Campo Vertice -->
                            <div class="flex flex-col">
                                <label for="nombre" class="px-3">almacen (Vertice)</label>
                                <input type="text" id="nombre" name="nombre" required placeholder="Introducir vértice"
                                    class="border p-2 rounded-md">
                            </div>
                            <div class="flex flex-col">
                                <label for="direccion" class="px-3">Direccion del Almacen</label>
                                <input type="text" id="direccion" name="direccion" required placeholder="Introducir direccion"
                                    class="border p-2 rounded-md">
                            </div>

                            <!-- Botón para agregar vértice -->
                            <div class="flex justify-center items-center">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </form>
                     <!-- MASIVO -->
    <form id="formAgregarVerticeMasivo" method="POST" action="{{ route('admin.ruta.verticestoreMasivo') }}" class="mt-4 flex justify-end">
        @csrf
        <input type="hidden" name="ruta_id" value="{{ $ruta->id }}" />
        <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
           masivo
        </button>
    </form>
                </div>

                <!-- Formulario para agregar arcos -->
                <div class="bg-white shadow-md rounded-md p-6 mt-4">
                    <h5 class="text-center mb-4 text-lg font-semibold">Agregar Arco</h5>

                    <form id="formAgregarArco" method="POST" action="{{ route('admin.ruta.arcostore') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Campo Distancia -->
                            <div class="flex flex-col">
                                <label for="peso" class="px-3">Distancia</label>
                                <input type="text" id="peso" name="peso"
                                    class="border p-2 rounded-md">
                            </div>

                            <!-- Select para Vertice Origen -->
                            <div class="flex flex-col">
                                <label for="vertice_origen_id" class="px-3">Almacen de Origen (Vertice de Origen)</label>
                                <select id="vertice_origen_id" name="vertice_origen_id"
                                    class="border p-2 rounded-md">
                                    @foreach($ruta->vertices as $vertice)
                                    <option value="{{ $vertice->id }}">{{ $vertice->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select para Vertice Llegada -->
                            <div class="flex flex-col">
                                <label for="vertice_destino_id" class="px-3">Almacen de Destino (Vertice de Destino)</label>
                                <select id="vertice_destino_id" name="vertice_destino_id"
                                    class="border p-2 rounded-md">
                                    @foreach($ruta->vertices as $vertice)
                                    <option value="{{ $vertice->id }}">{{ $vertice->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Botón para agregar arco -->
                        <div class="flex justify-center mt-4">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Agregar Arco
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#formAgregarVertice').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.post($(this).attr('action'), formData, function (response) {
                    console.log('Vértice agregado:', response);
                   var selectOrigen = $('select[name="vertice_origen_id"]');
                    var selectDestino = $('select[name="vertice_destino_id"]');
                    selectOrigen.empty();
                    selectDestino.empty();
                    $.each(response.vertices, function(index, vertice) {
                        selectOrigen.append($('<option></option>').attr('value', vertice.id).text(vertice.nombre));
                        selectDestino.append($('<option></option>').attr('value', vertice.id).text(vertice.nombre));
                    });
                    selectOrigen.val(response.last_inserted_id);
                    selectDestino.val(response.last_inserted_id);
                    alert('Vértice agregado correctamente');
                    $('#nombre').val('');
                    $('#direccion').val('');
                });
            });
            $('#formAgregarArco').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.post($(this).attr('action'), formData, function (response) {
                    console.log('Arco agregado:', response);
                });
            });
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para enviar formulario mediante AJAX
        function enviarFormularioAjax(form, callback) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(form);
                const action = form.action;

                fetch(action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    callback(data);
                })
                .catch(error => console.error('Error:', error));
            });
        }

        // Formulario de agregar vértice
        const formAgregarVertice = document.getElementById('formAgregarVertice');
        enviarFormularioAjax(formAgregarVertice, function(data) {
            console.log('Vértice agregado:', data);

        });

        // Formulario de agregar vértice masivo
        const formAgregarVerticeMasivo = document.getElementById('formAgregarVerticeMasivo');
        enviarFormularioAjax(formAgregarVerticeMasivo, function(data) {
            console.log('Vértices masivos agregados:', data);

        });
    });
</script>
</body>

</html>
