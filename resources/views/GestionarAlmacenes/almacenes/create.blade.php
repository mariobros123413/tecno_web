<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CREAR ALMACEN') }}
        </h2>
    </x-slot>

    <x-guest-layout>
        <form method="POST" action="{{ route('admin.almacen.store') }}">
            @csrf

            <!-- Nombre -->
            <div>
                <x-input-label for="nombre" :value="__('Nombre del almacen')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                    required autofocus autocomplete="Nombre del almacen" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Descripcion -->
            <div class="mt-4">
                <x-input-label for="direccion" :value="__('Direccion del almacen')" />
                <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion"
                    :value="old('direccion')" required autocomplete="Direccion del almacen" />
            </div>

            <!-- Tax -->
            <div class="mt-4">
                <x-input-label for="tax" :value="__('Taxes en el almacen')" />
                <x-text-input id="tax" class="block mt-1 w-full" type="number" name="tax" :value="old('tax')" required
                    autocomplete="Taxes en el almacen" step="0.01" />
            </div>


            <div class="flex items-center justify-center mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Guardar') }}
                </x-primary-button>
            </div>
        </form>

    </x-guest-layout>
    <footer class="text-center mt-4">
        <p class="text-gray-600 dark:text-gray-300">Número de visitas: {{ $visitas }}</p>
    </footer>
</x-app-layout>