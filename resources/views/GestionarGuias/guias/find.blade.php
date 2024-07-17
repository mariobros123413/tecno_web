<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envío de Paquetes - Find</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100 dark:bg-gray-600 justify-between">


    <!-- Navbar -->
    @include('layouts.nav')
    <!-- /Navbar -->


    <div class="max-w-md mx-auto mt-10 p-6 bg-gray-800 rounded-xl shadow-lg mb-10">
        <!-- Date Section -->
        @if ($guiaFound == true)
                <div class="flex items-center justify-between">
                    <div>

                        <div class="text-5xl font-bold text-white">
                            <?php
            $timestamp = strtotime($guia->fecha_recepcion);
            $dia = date('d', $timestamp);
            echo $dia;
                                                        ?>
                        </div>
                        <div class="text-xl uppercase text-white">
                            <?php
            $timestamp = strtotime($guia->fecha_recepcion);
            $nombre_dia = date('l', $timestamp);
            echo $nombre_dia;
                                                        ?>
                        </div>
                        <div class="uppercase tracking-wide text-white">
                            <?php
            $timestamp = strtotime($guia->fecha_recepcion);
            $nombre_mes = date('F', $timestamp);
            $nombre_mes = ucfirst($nombre_mes);
            echo $nombre_mes;
                                                        ?>
                        </div>
                    </div>
                    @if($guia->estado == true)
                        <div class="text-green-500 font-semibold text-2xl">En destino final</div>
                    @else
                        <div class="text-red-500 font-semibold text-2xl">En camino</div>
                    @endif
                </div>

                <!-- Tracking Information -->
                <div class="mt-4 relative">
                    <div class="absolute h-full border-l-2 border-gray-600 left-3 top-2.5"></div>
                    @foreach($guia->ruta_rastreo as $ruta)
                        <x-ruta-rastreo-card :ruta="$ruta" />
                    @endforeach
                </div>

                <!-- Additional Information -->
                <div class="mt-4">
                    <a href="#" class="text-blue-500 block">Track the Status on [OBOLOGISTIC]</a>
                    <div class="mt-2">
                        <div class="text-sm text-white">Destination</div>
                        <div class="text-sm text-green-500">{{$guia->almacenLlegada->nombre}}</div>
                    </div>
                    <div class="mt-2 text-white">
                        <div class="text-sm ">MMCA</div>
                        <div class="text-lg text-green-500">{{$guia->codigo}}</div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-blue-500">Obologistic.com</a>
                    </div>
                </div>
        @else
            <div class="flex items-center justify-between">
                <div class="text-5xl font-bold text-white">
                    No se encontró
                </div>
            </div>
        @endif

    </div>
    <footer class="text-center mt-4">
        <p class="text-gray-600 dark:text-gray-300">Número de visitas: {{ $visitas }}</p>
    </footer>
</body>

</html>