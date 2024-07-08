<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('EDITAR PAQUETE') }}
        </h2>
    </x-slot>

    <x-guest-layout>
    <form method="POST" action="{{ route('admin.paquete.update', ['paquete_id' => $paquete->id]) }}" >
    @csrf
    @method('PATCH')
    <!-- Name -->
    <div>
        <x-input-label for="dimensiones" :value="__('Dimensiones del Paquete')" />
        <x-text-input id="dimensiones" class="block mt-1 w-full" type="text" name="dimensiones" :value="old('dimensiones', $paquete->dimensiones)" required autofocus autocomplete="nombre" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>



    <!-- Descripcion -->
    <div class="mt-4">
        <x-input-label for="peso" :value="__('Peso del Paquete')" />
        <x-text-input id="peso" class="block mt-1 w-full"
                        type="number"
                        name="peso"
                        :value="old('peso', $paquete->peso)"
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
