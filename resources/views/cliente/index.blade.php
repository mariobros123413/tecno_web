<x-client-layout>
{{-- <body class="bg-gray-100 dark:bg-gray-600"> --}}


    <div class="container mx-auto md:px-20 pt-6 max-w-7xl bg-gray-200 dark:bg-gray-800">

        <!-- Hero section -->
        <div class="flex flex-col-reverse md:flex-row items-center pt-6 lg:mt-32 gap-24">
            <div class="text-left md:w-1/2 flex flex-col gap-5">
                <h1 class="text-4xl md:text-6xl font-semibold text-gray-900 leading-none dark:text-gray-100">
                    Bienvenido a Nuestro Servicio de Envío de Paquetes
                </h1>
                <p class="text-xl font-light text-gray-500 antialiased dark:text-gray-300">
                    Envíe sus paquetes con la máxima eficiencia y seguridad.
                </p>
                <a href="#servicios"
                    class="w-fit px-8 py-4 rounded-full font-normal tracking-wide bg-gradient-to-b from-blue-600 to-blue-700 text-white outline-none focus:outline-none hover:shadow-lg hover:from-blue-700 hover:to-blue-700 transition duration-200 ease-in-out">
                    Explorar Servicios
                </a>
            </div>
            <img src="https://obologistic.com/wp-content/uploads/2021/04/depositphotos_306004142-stock-photo-cropped-view-delivery-man-giving.jpg"
                alt="hero image" class="md:w-1/3 rounded-xl mb-10 shadow-md">
        </div>

        <!-- /Hero section -->

        <!-- Search section -->
        <div class="my-20 flex justify-center">
            <form action="{{ route('guia.find') }}" method="GET" class="w-full md:w-1/2">
                <div class="relative">
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-4 pl-12 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500"
                        placeholder="Ingresar la guia  que desee buscar" value="{{ request('search') }}">
                    <button type="submit"
                        class="absolute right-2.5 bottom-2.5 bg-red-500 text-white font-medium rounded-lg text-sm px-4 py-2 hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 transition duration-200 ease-in-out">
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        <div class="my-20 py-12 bg-white dark:bg-gray-800 rounded-xl" id="servicios">
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-gray-100 text-center">
                Nuestros Servicios
            </h2>
            <div class="grid md:grid-cols-3 gap-8 mt-12">

                <div
                    class="flex flex-col items-center text-center bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center w-16 h-16 bg-blue-600 text-white rounded-full mb-4">

                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12l3 9-3 9H3l3-9-3-9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Envíos Rápidos
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        Realiza envíos rápidos a nivel nacional e internacional. Entregamos tus paquetes en tiempo
                        récord.
                    </p>
                </div>

                <!-- Servicio 2 -->
                <div
                    class="flex flex-col items-center text-center bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center w-16 h-16 bg-green-600 text-white rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 9V5a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2h4l2 2v2h2l2-2V11h4a2 2 0 002-2V7a2 2 0 00-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Envíos Seguros
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        Garantizamos la seguridad de tus paquetes durante todo el proceso de envío. Ofrecemos seguros de
                        envío.
                    </p>
                </div>

                <!-- Servicio 3 -->
                <div
                    class="flex flex-col items-center text-center bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center w-16 h-16 bg-red-600 text-white rounded-full mb-4">

                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a2 2 0 00-2-2h-3a2 2 0 00-2 2v2zM9 20h2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2h2v-2h2v2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Envíos Económicos
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        Ofrecemos envíos económicos sin comprometer la calidad del servicio. Obtén la mejor tarifa.
                    </p>
                </div>
            </div>
        </div>

    </div>
    {{-- <!-- Pie de página -->
    <footer class="text-center mt-4">
        <p class="text-gray-600 dark:text-gray-300">Número de visitas: {{ $visitas }}</p>
    </footer> --}}
{{-- </body> --}}

</x-client-layout>