<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obologistic</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.whatsapp')
</head>

<body class="bg-gray-100">

    <div class="w-full fixed top-0 z-50 bg-white">
        <!-- Navbar -->
        @include('layouts.navigation')

    </div>

    <div class="mt-20 mx-auto max-w-6xl px-6 lg:py-20">
        <div class="flex justify-center">
            <div class="w-full lg:w-3/4 xl:w-2/3 text-center">
                <h3 class="text-3xl font-bold">Check-In</h3>


                <div class="bg-white shadow-md rounded-md p-6 mt-4" style="display: flex; justify-content: center; align-items: center;">

                <div id="camera-container" style="width: 320px; height: 240px;">

                    <video id="camera-feed" style="width: 100%; height: 100%;" autoplay></video>
                </div>
            </div>
                <div class="bg-white shadow-md rounded-md p-6 mt-4">
                    <form id="formAgregarArco" method="POST" action="{{ route('admin.ruta.arcostore') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                             <div class="flex flex-col">
                                <label for="almacen_id" class="px-3">Seleccionar Almacen</label>
                                <select id="almacen_id" name="almacen_id" class="border p-2 rounded-md">
                                    @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </form>
                         <div class="flex justify-center">
                                     <div class="flex justify-center mt-4">
                                            <div class="flex justify-center">
                                                <div id="userModal" class="hidden fixed inset-0 bg-blue-500 bg-opacity-75 flex justify-center items-center">
                                                    <div class="bg-white p-8 rounded shadow-lg  justify-center items-center">
                                                        <p id="mensaje" class="text-xl font-bold mb-4"></p>
                                                        <div class="flex justify-center mt-4">
                                                          <x-primary-button id="closeModal" class="mt-4">
                                                            {{ __('Cerrar') }}
                                                            </x-primary-button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                 </div>
                        </div>



  <!-- TABLA -->
  <div class="bg-white shadow-md rounded-md p-6 mt-4">
                    <h5 class="text-center mb-4 text-lg font-semibold">Guia</h5>

                </div>

            </div>
        </div>
    </div>

    <script>
        async function setupCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                const videoElement = document.createElement('video');
                videoElement.srcObject = stream;
                videoElement.autoplay = true;
                videoElement.style.width = '120px'; // Ancho deseado del video
                videoElement.style.height = '140px'; // Alto deseado del video
                const cameraContainer = document.getElementById('camera-container');
                cameraContainer.appendChild(videoElement);
            } catch (error) {
                console.error('Error al acceder a la cámara:', error);
            }
        }

let qrAnterior = null;

async function leerCodigoQR() {
    await setupCamera();
    const html5QrCode = new Html5Qrcode("camera-container");
    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            var cameraId = devices[0].id;
            html5QrCode.start(
                cameraId,
                {
                    fps: 20,
                },
                (decodedText, decodedResult) => {
                    if (decodedText !== qrAnterior) {
                        qrAnterior = decodedText;
                        enviarDatosGuia(decodedText);
                    }
                },
                (errorMessage) => {
                    console.log(errorMessage);
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    }).catch(err => {
        console.log(err);
    });
}

        leerCodigoQR();



        function enviarDatosGuia(decodedText) {
    const guia_id = decodedText;
    const selectElement = document.getElementById('almacen_id');
    const almacenSeleccionado = selectElement.value;

    if (guia_id.trim() && almacenSeleccionado.trim()) {
        console.log('Guia ID:', guia_id.trim());
        console.log('Almacen ID:', almacenSeleccionado.trim());

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

axios.post('/admin-rutarastreo/checkIn', {
        guia_id: guia_id,
        almacen_id: almacenSeleccionado,
    }, {
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        console.log('Datos enviados correctamente:', response.data);
        EnviarWhatsApp(response.data.numero, response.data.message);
        const mensaje = "Estado de la ruta actualizada! :)";
                        $('#userModal').removeClass('hidden');
                        $('#mensaje').text(mensaje);
    })
    .catch(error => {
        console.error('Error:', error);
       alert(error.response.data.message);
    });

    } else {
        console.error('Error: guia_id o almacen_id es nulo');
    }
}


    </script>
<script>
    const closeModalButton = document.getElementById('closeModal');
    const userModal = document.getElementById('userModal');
    closeModalButton.addEventListener('click', function() {
        userModal.classList.add('hidden');
    });
</script>
</body>

</html>
