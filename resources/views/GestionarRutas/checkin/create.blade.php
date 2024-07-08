<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CREAR RUTA') }}
        </h2>
    </x-slot>

    <x-guest-layout>
    <form method="POST" action="{{ route('admin.ruta.store') }}">
    @csrf

    <!-- Nombre -->
    <div>
        <x-input-label for="nombre" :value="__('Nombre de la Ruta')" />
        <x-text-input id="nombre" class="block mt-1 w-full" type="text"
        name="nombre" :value="old('nombre')"
        required autofocus autocomplete="Nombre de la Ruta" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>



    <div class="flex items-center justify-center mt-4">
        <x-primary-button class="ms-4">
            {{ __('Guardar') }}
        </x-primary-button>
    </div>
</form>

</x-guest-layout>

</x-app-layout>
