<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('EDITAR PAGO') }}
        </h2>
    </x-slot>

    <x-guest-layout>
    <form method="POST" action="{{ route('admin.pagos.update', ['pago_id' => $pago->id]) }}" >
    @csrf
    @method('PATCH')
    <!-- Name -->
    <!-- New ComboBox Field -->
    <div class="mt-4">
        <x-input-label for="venta_id" :value="__('Seleccionar el u')" />
        <div class="mt-4">

      <select id="user_id" name="user_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

      @foreach($users as $user)
            @if($user->id === $venta->user_id)
             <option value="{{$user->id}}" selected>{{$user->id}} - {{$user->name}}</option>
             @else
              <option value="{{$user->id}}">{{$user->id}} - {{$user->name}}</option>
            @endif

        @endforeach
      </select>
      </div>

    </div>



    <!-- Descripcion -->
    <div class="mt-4">
        <x-input-label for="fecha" :value="__('fecha')" />
         @php
                 $formattedDate = $venta->fecha ? \Carbon\Carbon::parse($venta->fecha)->format('Y-m-d') : '';
         @endphp
        <x-text-input id="fecha" class="block mt-1 w-full" type="date"  name="fecha" :value="old('fecha',$formattedDate)" />
    </div>
<!-- metodo pago -->
    <div class="mt-4">
        <x-input-label for="custom_field" :value="__('Seleccionar Metodo de Pago')" />
        <div class="mt-4">
      <select id="metodopago" name="metodopago" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
       @if($venta->metodopago === 1)
            <option value= "1"  selected>Pago con Qr</option>
             <option value="2">Pago con Tigo Money</option>
            @else
            <option value="1">Pago con Qr</option>
            <option value="2" selected>Pago con Tigo Money</option>

        @endif
      </select>
      </div>
        <!-- You can modify the options and values accordingly -->
    </div>
<!-- end metodo pago -->

    <div class="mt-4">
        <x-input-label for="montototal" :value="__('Monto total')" />
        <x-text-input id="montototal" class="block mt-1 w-full" type="text"  name="montototal" :value="old('montototal', $venta->montototal)" />
    </div>

    <!-- estado pago venta -->
    <div class="mt-4">
        <x-input-label for="custom_field" :value="__('Seleccionar el estado de la venta')" />
        <div class="mt-4">
      <select id="estado" name="estado" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
       @if($venta->estado === 1)
            <option value= "1"  selected>No cancelado</option>
             <option value="2">Pagado con exito</option>
            @else
            <option value="1">No cancelado</option>
            <option value="2" selected>Pagado con exito</option>

        @endif
      </select>
      </div>

    </div>
<!-- end estado pago venta -->


    <div class="flex items-center justify-center mt-4">
        <x-primary-button class="ms-4">
            {{ __('Guardar') }}
        </x-primary-button>
    </div>
</form>

</x-guest-layout>

</x-app-layout>
