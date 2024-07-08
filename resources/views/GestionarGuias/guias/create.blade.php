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

            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700"></label>
                <input type="file" id="fileInput" name="data[file]" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="flex items-center justify-center mt-4">
        <x-primary-button onclick="handleUpload()" class="ms-4">
            {{ __('Escanear Documento') }}
        </x-primary-button>
    </div>
                        <!-- Barra de progreso -->
            <div class="mt-6 w-full bg-gray-200 h-6 rounded-lg overflow-hidden">
                <div class="bg-blue-500 h-full transition-all duration-500" style="width: 33%;"></div>
            </div>
            <!-- Formulario -->
            <div class="bg-white shadow-md rounded-md p-6 mt-4">
                <form method="POST"  action="{{ route('admin.pagos.generarCobro') }}" >
                    @csrf
                    <!-- Paso 1: Registrar Cliente -->
                    <fieldset>
                        <h2 class="text-xl font-semibold mb-4">Paso 1: Registra al Cliente</h2>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombres</label>
                            <input type="text" id="name" name="dto_nombres" placeholder="Nombres"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="cedula" class="block text-sm font-medium text-gray-700">Cedula</label>
                            <input type="number" id="cedula" name="dto_cedula" placeholder="Cedula de identidad"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>


                        <div class="mb-4">
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Direccion</label>
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

                        <button type="button" name="next"
                            class="next bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Siguiente
                        </button>
                    </fieldset>

                    <!-- Paso 2: Agregar Paquete -->
                    <fieldset class="hidden">
                        <h2 class="text-xl font-semibold mb-4">Paso 2: Registra el Paquete</h2>
                        <div class="mb-4">
                            <label for="dimensiones" class="block text-sm font-medium text-gray-700">Dimensiones</label>
                            <input type="text" id="dimensiones" name="dto_dimensiones" placeholder="Dimensiones"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="peso" class="block text-sm font-medium text-gray-700">Peso</label>
                            <input type="text" id="peso" name="dto_peso" placeholder="Peso del Paquete"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="fecha_recepcion" class="block text-sm font-medium text-gray-700">Fecha de Salida</label>
                            <input type="date" id="fecha_recepcion" name="dto_fechaSalida"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="fecha_entrega" class="block text-sm font-medium text-gray-700">Fecha de Llegada</label>
                            <input type="date" id="fecha_entrega" name="dto_fechaLlegada"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>
                        <div class="mt-4">
                            <x-input-label for="servicio_id" :value="__('Seleccionar Servicio')" />
                            <div class="mt-4">
                                <select id="servicio_id" name="dto_servicio_id" onchange="actualizarPrecio()" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($servicios as $servicio)
                                    <option value="{{$servicio->id}}" data-atributo="{{$servicio->precio_kilo}}">{{$servicio->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="montoTotal" class="block text-sm font-medium text-gray-700">Monto Total a Pagar</label>
                            <input type="number" id="monto_total" name="monto_total"   class="mt-1 p-2 w-full border rounded-md">
                        </div>
             <!-- Formulario de selección de vértices -->
                           <!-- primer vertice -->
                           <div class="mt-4">
                                            <x-input-label for="almacen_inicio" :value="__('Almacen Salida')" />
                                                <div class="mt-4">
                                                <select id="verticeOrigenId" name="verticeOrigenId" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    @foreach($vertices as $vertice)
                                                        <option value="{{$vertice->id}}">{{$vertice->nombre}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                        </div>
                <!-- final primer vertice -->

                <!-- segundo vertice -->
                             <div class="mt-4">
                                 <x-input-label for="almacen_final" :value="__('Almacen Llegada')" />
                                    <div class="mt-4">
                                            <select id="verticeDestinoId" name="verticeDestinoId" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                @foreach($vertices as $vertice)
                                                    <option value="{{$vertice->id}}">{{$vertice->nombre}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                              </div>
                     <!-- final degundo vertice -->
                            <div class="mt-4">
                                <x-input-label for="caminoMasCorto" :value="__('Camino más corto')" />
                                <div class="mt-4">
                                    <ul id="listaCaminoMasCorto" class="list-disc pl-5">
                                    </ul>
                                </div>
                            </div>

                <!-- final degundo vertice -->

                        <button type="button" name="previous"
                            class="previous bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Previo
                        </button>
                        <button type="button" id="btnCapturar"
                            class="submit bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Enviar
                        </button>

                </form>
                <div class="flex justify-center">
                                     <div class="flex justify-center mt-4">
                                            <div class="flex justify-center">
                                                <div id="userModal" class="hidden fixed inset-0 bg-blue-500 bg-opacity-75 flex justify-center items-center">
                                                    <div class="bg-white p-8 rounded shadow-lg  justify-center items-center">
                                                        <p id="mensaje" class="text-xl font-bold mb-4"></p>
                                                        <div class="flex justify-center mt-4">
                                                        <form method="GET"  action="{{ route('admin.guias') }}" >
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
$(document).ready(function() {
    const btnCapturar = $('#btnCapturar');

    if (btnCapturar.length) {
        btnCapturar.click(function() {
            const nombre = $('#name').val();
            const apellido = $('#apellido').val();
            const fecha_nacimiento = $('#fecha_nacimiento').val();
            const cedula = $('#cedula').val();
            const celular = $('#celular').val();
            const direccion = $('#direccion').val();
            const correo = $('#correo').val();
            const dimensiones = $('#dimensiones').val();
            const peso = $('#peso').val();
            const fecha_recepcion = $('#fecha_recepcion').val();
            const fecha_entrega = $('#fecha_entrega').val();
            const servicio_id = $('#servicio_id').val();
            const verticeOrigenId = $('#verticeOrigenId').val();
            const verticeDestinoId = $('#verticeDestinoId').val();
            const monto_total = $('#monto_total').val();

            const listaCaminoMasCorto = $('#listaCaminoMasCorto');
            const valoresLista = listaCaminoMasCorto.find('li').map(function() {
                return $(this).attr('value');
            }).get();

            const datos = {
                nombre,
                apellido,
                fecha_nacimiento,
                cedula,
                celular,
                direccion,
                correo,
                dimensiones,
                peso,
                fecha_recepcion,
                fecha_entrega,
                servicio_id,
                verticeOrigenId,
                verticeDestinoId,
                monto_total,
                valoresLista
            };
            const token = $('meta[name="csrf-token"]').attr('content');
            datos._token = token;
            console.log(datos);

            $.ajax({
                url: '/admin-guia/store',
                type: 'POST',
                data: datos,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(response, status, xhr) {
                    console.log(xhr.status);
                    if (xhr.status === 200) {
                        const mensaje = "Su pedido fue registrado exitosamente :) , Puede realizar el seguimiento de su pedido en nuestra aplicación móvil con el siguiente MMCA: *" + response.MMCA+"*";
                        EnviarWhatsApp(celular,mensaje);
                        $('#userModal').removeClass('hidden');
                        $('#mensaje').text(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    } else {
        console.error('No se encontró el botón btnCapturar.');
    }
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
    var vertices = @json($vertices);
</script>
<script>
    class Grafo {
        constructor() {
            this.vertices = {};
        }

        agregarVertice(id) {
            if (!this.vertices[id]) {
                this.vertices[id] = {};
            }
        }

        agregarArco(origen, destino, costo) {
            if (!this.vertices[origen] || !this.vertices[destino]) {
                throw new Error('El vértice origen o destino no existe en el grafo.');
            }
            if (!this.vertices[origen].hasOwnProperty(destino) || this.vertices[origen][destino] > costo) {
                this.vertices[origen][destino] = costo;
            }
        }

        dijkstra(origen, destino) {
            if (!this.vertices.hasOwnProperty(destino)) {
                console.log(`El vértice ${destino} no existe en el grafo.`);
                return [];
            }

            const distancias = {};
            const anteriores = {};
            const noVisitados = {};

            for (let vertice in this.vertices) {
                distancias[vertice] = Infinity;
                anteriores[vertice] = null;
                noVisitados[vertice] = this.vertices[vertice];
            }

            distancias[origen] = 0;

            while (Object.keys(noVisitados).length > 0) {
                const verticeActual = this.minDistanciaVertice(distancias, noVisitados);
                if (verticeActual === destino || distancias[verticeActual] === Infinity) {
                    break;
                }

                delete noVisitados[verticeActual];

                for (let vecino in this.vertices[verticeActual]) {
                    const costo = this.vertices[verticeActual][vecino];
                    const distanciaNueva = distancias[verticeActual] + costo;

                    if (distanciaNueva < distancias[vecino]) {
                        distancias[vecino] = distanciaNueva;
                        anteriores[vecino] = verticeActual;
                    }
                }
            }

            return this.construirCamino(origen, destino, anteriores);
        }

        minDistanciaVertice(distancias, noVisitados) {
            let minDistancia = Infinity;
            let minVertice = null;

            for (let vertice in noVisitados) {
                if (distancias[vertice] < minDistancia) {
                    minDistancia = distancias[vertice];
                    minVertice = vertice;
                }
            }

            return minVertice;
        }

        construirCamino(origen, destino, anteriores) {
            const camino = [];
            let verticeActual = destino;

            while (verticeActual !== null) {
                camino.unshift(verticeActual);
                verticeActual = anteriores[verticeActual];
            }

            if (camino[0] === origen) {
                return camino;
            } else {
               return [];
            }
        }
    }

    var vertices = @json($vertices);
    var arcos = @json($arcos);

    const grafo = new Grafo();

    vertices.forEach(vertice => {
        grafo.agregarVertice(vertice.id);
    });


    arcos.forEach(arco => {
        grafo.agregarArco(arco.vertice_origen_id, arco.vertice_destino_id, arco.peso);
    });

    function actualizarCaminoMasCorto(camino) {
        const listaCaminoMasCorto = document.getElementById('listaCaminoMasCorto');
        listaCaminoMasCorto.innerHTML = '';

        camino.forEach(verticeId => {
            const verticeEncontrado = vertices.find(vertice => vertice.id == verticeId);

            if (verticeEncontrado) {
                const li = document.createElement('li');
                li.setAttribute('value', verticeEncontrado.id);
                li.textContent = verticeEncontrado.nombre;
                listaCaminoMasCorto.appendChild(li);
            }else {
                console.error(`No se encontró un vértice con ID ${verticeId}`);
            }
        });
    }

    $('#verticeDestinoId').on('change', function() {
        var verticeOrigenId = $('#verticeOrigenId').val();
        var verticeDestinoId = $(this).val();
        const caminoMasCorto = grafo.dijkstra(verticeOrigenId, verticeDestinoId);
        console.log('Camino más corto:', caminoMasCorto.join(' -> '));
        actualizarCaminoMasCorto(caminoMasCorto);
    });
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Grafo creado:', grafo);
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
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
<script>
    async function uploadToApi(file) {
    const formData = new FormData();
    formData.append('file', file);

    try {
        const response = await axios.post('https://api.ocr.space/parse/image', formData, {
            headers: {
                'apiKey': 'helloworld',
                'Content-Type': 'multipart/form-data'
            }
        });

        const responseBody = response.data;
        const responseBodyText = responseBody['ParsedResults'][0]['ParsedText'];
       console.log('Texto extraído:', responseBodyText);
       const notaEntregaJSON = convertirNotaEntregaATextoJSON(responseBodyText);
            const notaEntrega = JSON.parse(notaEntregaJSON);

            for (const key in notaEntrega) {
                if (notaEntrega.hasOwnProperty(key)) {
                    if(key==="Nombre del Cliente"){
                        document.getElementById('name').value = notaEntrega[key];
                    }else if(key==="DNI"){
                        document.getElementById('cedula').value = notaEntrega[key];
                    }
                    else if(key==="Direccion"){
                        document.getElementById('direccion').value = notaEntrega[key];
                    }
                    else if(key==="Ciudad"){
                        const value = notaEntrega[key];
                     const element = document.getElementById('verticeDestinoId');
                    if (element) {
                        if (element.tagName === 'SELECT'  && key === "Ciudad") {
                            for (let i = 0; i < element.options.length; i++) {
                                if (element.options[i].text === value) {
                                    element.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                    }
                    }
                    else if(key==="Celular"){
                        document.getElementById('celular').value = notaEntrega[key];
                    }else if(key==="Correo"){
                        document.getElementById('correo').value = notaEntrega[key];
                    }else if(key==="Peso Total"){
                        document.getElementById('peso').value = notaEntrega[key];
                    }

                }
            }


    } catch (error) {
        console.error('Error al enviar archivo a la API:', error);
    }
}

function handleUpload() {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];

    if (file) {
        uploadToApi(file);
    } else {
        console.error('No se ha seleccionado ningún archivo.');
    }
}
function convertirNotaEntregaATextoJSON(texto) {
    const lineas = texto.split('\n');

    let productos = [];
    let cantidades = [];
    let precios = [];
    let descripciones = [];

    const notaEntrega = {
        "Nombre del Cliente": "",
        "Direccion": "",
        "Ciudad": "",
        "Productos": [],
        "Nro de Nota": "",
        "DNI": "",
        "Celular": "",
        "Correo": "",
        "Despachado por": "",
        "Peso Total": "",
        "Precio Total": "",
        "Observaciones": "",
    };

    lineas.forEach((linea, index) => {
        if (linea.startsWith("Nombre del Cliente:")) {
            notaEntrega["Nombre del Cliente"] = obtenerValorDeLinea(linea);
        } else if (linea.startsWith("Direccion:")) {
            notaEntrega["Direccion"] = obtenerValorDeLinea(linea);
        }else if (linea.startsWith("Celular:")) {
            notaEntrega["Celular"] = obtenerValorDeLinea(linea);
        }else if (linea.startsWith("E-mail:")) {
            notaEntrega["Correo"] = obtenerValorDeLinea(linea);
        }else if (linea.startsWith("Ciudad:")) {
            notaEntrega["Ciudad"] = obtenerValorDeLinea(linea);
        } else if (linea.startsWith("Nro de Nota:")) {
            const siguienteLinea = lineas[index + 1];
            if (siguienteLinea) {
                notaEntrega["Nro de Nota"] = siguienteLinea.trim();
            }
        } else if (linea.startsWith("ONI:")) {
            const siguienteLinea = lineas[index + 1];
            if (siguienteLinea) {
                notaEntrega["DNI"] = siguienteLinea.trim();
            }
        } else if (linea.startsWith("Despachado por:")) {
            notaEntrega["Despachado por"] = obtenerValorDeLinea(linea);
        } else if (linea.startsWith("Peso Total:")) {
            const siguienteLinea = lineas[index + 1];
            if (siguienteLinea) {
                const pesoTotalConComa = siguienteLinea.trim();
                const pesoTotalConPunto = pesoTotalConComa.replace(',', '.');
                notaEntrega["Peso Total"] = pesoTotalConPunto;
            }
        } else if (linea.startsWith("Precio Total:")) {
            notaEntrega["Precio Total"] = obtenerValorDeLinea(linea);
        } else if (linea.startsWith("Observaciones:")) {
            notaEntrega["Observaciones"] = obtenerValorDeLinea(linea);
        } else if (linea.startsWith("Referencia")) {
            const indiceReferencia = index + 1;
            const indiceCantidad = lineas.findIndex(linea => linea.startsWith("Cantidad"));

            if (indiceCantidad !== -1) {
                productos = lineas.slice(indiceReferencia, indiceCantidad);
            }
        } else if (linea.startsWith("Cantidad")) {
            const indiceReferencia = index + 1;
            const indiceCantidad = lineas.findIndex(linea => linea.startsWith("Despachado por:"));
            if (indiceCantidad !== -1) {
                cantidades = lineas.slice(indiceReferencia, indiceCantidad);
            }
        } else if (linea.startsWith("Precio")) {
            const indiceReferencia = index + 1;
            const indiceCantidad = lineas.findIndex(linea => linea.startsWith("Peso Total:"));
            if (indiceCantidad !== -1) {
                precios = lineas.slice(indiceReferencia, indiceCantidad);
            }
        } else if (linea.startsWith("Descripcion del Articulo")) {
            const indiceReferencia = index + 1;
            const indiceCantidad = lineas.findIndex(linea => linea.startsWith("Precio Total:"));
            if (indiceCantidad !== -1) {
                descripciones = lineas.slice(indiceReferencia, indiceCantidad);
            }
        }
    });

    productos.forEach((producto, i) => {
        const nombreProducto = producto.trim();
        const cantidad = cantidades[i] ? parseInt(cantidades[i].trim()) : 0;
        const precio = precios[i] ? parseFloat(precios[i].trim()) : 0;
        const descripcion = descripciones[i] ? descripciones[i].trim() : "";

        notaEntrega["Productos"].push({
            "Nombre": nombreProducto,
            "Cantidad": cantidad,
            "Precio": precio,
            "Descripcion": descripcion
        });
    });

    function obtenerValorDeLinea(linea) {
        const partes = linea.split(":");
        return partes.length > 1 ? partes[1].trim() : "";
    }
    console.log('Nota de entrega en formato JSON:', notaEntrega);
    return JSON.stringify(notaEntrega, null, 4);
}

</script>
</body>
</html>
