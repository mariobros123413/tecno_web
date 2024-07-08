<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('EDITAR SERVICIO') }}
        </h2>
    </x-slot>

    <x-guest-layout>
    <form method="POST" action="{{ route('admin.servicio.update', ['servicio_id' => $servicio->id]) }}" >
    @csrf
    @method('PATCH')
    <!-- Name -->
    <div>
        <x-input-label for="nombre" :value="__('Nombre del servicio')" />
        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $servicio->nombre)" required autofocus autocomplete="nombre" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>



    <!-- Descripcion -->
    <div class="mt-4">
        <x-input-label for="descripcion" :value="__('Descripcion del servicio')" />
        <x-text-input id="peso" class="block mt-1 w-full"
                        type="text"
                        name="descripcion"
                        :value="old('descripcion', $servicio->descripcion)"
                        />
    </div>

     <!-- Peso por kilo -->
     <div class="mt-4">
        <x-input-label for="precio_kilo" :value="__('Precio por kilo')" />
        <x-text-input id="precio_kilo" class="block mt-1 w-full"
                        type="text"
                        name="precio_kilo"
                        :value="old('precio_kilo', $servicio->precio_kilo)"
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
