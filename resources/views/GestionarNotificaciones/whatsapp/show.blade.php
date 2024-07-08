<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obologistic</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="w-full fixed top-0 z-50 bg-white">
        @include('layouts.navigation')
    </div>

    <div class="mt-20 mx-auto max-w-6xl px-6 lg:py-20">
        <div class="flex justify-center">
            <div class="w-full lg:w-3/4 xl:w-2/3 text-center">
                <h3 class="text-3xl font-bold">WhatsApp</h3>
                <div class="mb-4">
                            <input type="text" id="instancia_id" name="instancia_id" placeholder="Instancia ID"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>
                <div class="bg-white shadow-md rounded-md p-6 mt-4" style="display: flex; justify-content: center; align-items: center;">
                    <div id="whatsapp-container" style="width: 320px; height: 320px;">
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-md p-6 mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col">
                            <div class="flex items-center justify-center mt-4">
                                <x-primary-button class="ms-4" id="crearCuentaButton">
                                    {{ __('Crear') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-md p-6 mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Numero de whatsappp -->
    <div>

        <x-input-label for="whatsapp" :value="__('Numero de WhatsApp ')" />
        <x-text-input id="whatsapp" class="block mt-1 w-full" type="text"
        name="whatsapp" :value="old('whatsapp')"
        required autofocus autocomplete="Introduzca el numero de whatsapp a enviar el mensaje" />
        <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
    </div>
    <!-- Nombre -->
    <div>
        <x-input-label for="mensaje" :value="__('Escriba el mensaje')" />
        <x-text-input id="mensaje" class="block mt-1 w-full" type="text"
        name="mensaje" :value="old('mensaje')"
        required autofocus autocomplete="Esccriba el mensaje a enviar" />
        <x-input-error :messages="$errors->get('mensaje')" class="mt-2" />
    </div>
                        <div class="flex flex-col">
                            <div class="flex items-center justify-center mt-4">
                                <x-primary-button class="ms-4" id="enviarMensajeButton">
                                    {{ __('Enviar') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.getElementById('crearCuentaButton').addEventListener('click', function() {
            console.log('Botón "Crear" fue clickeado.');

            instanciaCreate()
                .then(instancia => {
                    if (instancia) {
                        getQr(instancia);
                        document.getElementById('instancia_id').value = instancia;
                    }
                })
                .catch(error => {
                    console.error('Error en el proceso de creación de instancia y obtención del QR:', error);
                });
        });

        document.getElementById('enviarMensajeButton').addEventListener('click', function() {
            console.log('Botón "Enviar" fue clickeado.');
            const numero = document.getElementById('whatsapp').value;
            const mensaje = document.getElementById('mensaje').value;
            EnviarWhatsApp(numero,mensaje);

        });

        function instanciaCreate() {
            const token = '664603bea607f'; // tu token de acceso
            const url = `/proxy/get_instance?access_token=${token}`;

            return axios.get(url)
                .then(response => {
                    if (response.data.status === 'success') {
                        const instancia = response.data.instance_id;  // Corregido: response.data.instance_id
                        console.log('Instancia:', instancia);
                        return instancia;
                    } else {
                        console.error('Error en la respuesta de la API:', response.data.message);
                        return null;
                    }
                })
                .catch(error => {
                    console.error('Error al crear la instancia:', error);
                    throw error;
                });
        }

        function getQr(instanceId) {
            const token = '664603bea607f'; // tu token de acceso
            const url = `/proxy/get_qrcode?instance_id=${instanceId}&access_token=${token}`;

            axios.get(url)
                .then(response => {
                    if (response.data.status === 'success') {
                        const qrCodeData = response.data.base64;
                        console.log('Código QR:', qrCodeData);
                        // Mostrar el código QR en el contenedor
                        document.getElementById('whatsapp-container').innerHTML = `<img src="${qrCodeData}" alt="Código QR de WhatsApp" />`;
                    } else {
                        console.error('Error en la respuesta de la API:', response.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener el código QR:', error);
                });
        }

        function EnviarWhatsApp(number,message) {
            const instanceId= document.getElementById('instancia_id').value;
            const token = '664603bea607f'; // tu token de acceso
            const url = `/proxy/send_message?number=${number}&type=text&message=${message}&instance_id=${instanceId}&access_token=${token}`;
            axios.post(url)
                .then(response => {
                    if (response.data.status === 'success') {

                        console.log('Message:', response.data.status);

                    } else {
                        console.error('Error en la respuesta de la API:', response.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener el código QR:', error);
                });
        }

    </script>
</body>
</html>
