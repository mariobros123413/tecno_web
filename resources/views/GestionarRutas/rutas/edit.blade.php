<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('EDITAR ALMACEN') }}
        </h2>
    </x-slot>

    <x-guest-layout>
    <form method="POST" action="{{ route('admin.almacen.update', ['almacen_id' => $almacen->id]) }}" >
    @csrf
    @method('PATCH')
    <!-- Name -->
    <div>
        <x-input-label for="nombre" :value="__('Nombre del almacen')" />
        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $almacen->nombre)" required autofocus autocomplete="nombre" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>



    <!-- Descripcion -->
    <div class="mt-4">
        <x-input-label for="direccion" :value="__('Direccion del almacen')" />
        <x-text-input id="direccion" class="block mt-1 w-full"
                        type="text"
                        name="direccion"
                        :value="old('direccion', $almacen->direccion)"
                        />
    </div>




    <div class="flex items-center justify-center mt-4">
        <x-primary-button class="ms-4">
            {{ __('Guardar') }}
        </x-primary-button>
    </div>
</form>

</x-guest-layout>

</x-app-layout>
