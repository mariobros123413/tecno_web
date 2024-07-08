<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Obologistic</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('layouts.whatsapp')
        <script>
    setTimeout(function() {
        document.getElementById('mensaje-flash').style.display = 'none';
    }, 5000);
</script>


    </head>
    <body class="font-sans antialiased " >

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full fixed top-0 z-5 bg-white ">
        <!-- nav -->
        @include('layouts.navigation')
        <!-- /nav -->
        </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="mb-8" >
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" >
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>

                {{ $slot }}
            </main>
        </div>
        @if(session('mensaje'))
             <div id="mensaje-flash" class="bg-green-200 border border-green-600 text-green-800 px-4 py-3 rounded relative" role="alert">
                 <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('mensaje') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <button class="close-button">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path fill-rule="evenodd" d="M3.293 3.293a1 1 0 011.414 0L10 8.586l5.293-5.293a1 1 0 111.414 1.414L11.414 10l5.293 5.293a1 1 0 01-1.414 1.414L10 11.414l-5.293 5.293a1 1 0 01-1.414-1.414L8.586 10 3.293 4.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
             </div>
       @endif

<div class="box box-default" style="display: none;" id="cargador_proyectoFinal" align="center">

    <div class="col-md-12">

        <div class="box box-default" style="margin-top: 10px;">

            <br>

            <div style="text-align: center">

                <label style="color: #1a2226; background-color: #ADD7F0; text-align: center;">&nbsp;&nbsp;&nbsp;Cargando... &nbsp;&nbsp;&nbsp;</label>

            </div>



            <div style="text-align: center; margin-top: 8px;"><label style="color: #bce8f1;"> Realizando tarea solicitada ...</label></div>

            <br>

            <hr style="color: whitesmoke; margin-top: -1px;" width="50%">

            <br>

        </div>

    </div>

</div>
@if(Session::has('success'))
                 <x-modal name='#' :show="true" focusable >
                        <form method="#" action="#" class="p-6  bg-green-200">
                                <h2 class=" mt-4 flex justify-center text-lg font-medium text-gray-900  dark:text-gray-100">
                                    {{ ('Eliminado exitosamente!') }}
                                </h2>
                                <div class="mt-4 flex justify-center">
                                    <x-secondary-button class="bg-green-200" x-on:click="$dispatch('close')">
                                        {{ __('Aceptar') }}
                                    </x-secondary-button>
                                </div>
                        </form>

                </x-modal>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif
    </body>
</html>
