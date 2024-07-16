<!-- resources/views/index.blade.php -->
<x-client-layout>
    <!-- Contenido específico de la página -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ __('Bienvenido a Obologistic') }}</h1>
                <p class="mt-4 text-gray-600 dark:text-gray-400">{{ __('Aquí puedes gestionar tus paquetes y envíos.') }}</p>
                <table class="min-w-full table-auto text-center text-sm">
                                    <thead>
                                        <tr class="bg-blue-100">
                                            {{-- <th class="py-2 px-4" data-order="id">ID</th>
                                            <th class="py-2 px-4">Nombre del Cliente</th> --}}
                                            <th class="py-2 px-4">ID de Paquete</th>
                                            <th class="py-2 px-4">Servicio</th>
                                            <th class="py-2 px-4">Almacen de Recepción</th>
                                            <th class="py-2 px-4">Almacen de Entrega</th>
                                            <th class="py-2 px-7" data-order="fecha_recepcion">Fecha de Recepción</th>
                                            <th class="py-2 px-7" data-order="fecha_entrega">Fecha de Entrega</th>
                                            {{-- <th class="py-2 px-4">Precio Total</th> --}}
                                            <th class="py-2 px-7" data-order="estado">Detalles</th>
                                            <th class="py-2 px-7" data-order="pagar_servicio">Pagar servicio</th>
                                            {{-- <th class="py-2 px-4">Acción</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($guias as $guia)
                                           @foreach($ventas as $venta)
                                            <tr class="border-b">
                                                <td>{{ $guia->id }}</td>
                                                <td>{{ $guia->user->name }}</td>
                                                <td>{{ $guia->paquete_id }}</td>
                                                <td>{{ $guia->servicio->nombre }}</td>
                                                <td>{{ $guia->almacenSalida->nombre }}</td>
                                                <td>{{ $guia->almacenLlegada->nombre }}</td>
                                                <td>{{ $guia->fecha_recepcion }}</td>
                                                <td>{{ $guia->fecha_entrega }}</td>
                                                {{-- <td>{{ $guia->precio }}</td> --}}
                                                <td>
                                                    @if($guia->estado)
                                                        El paquete llegó al almacén destino
                                                    @else
                                                        Está en camino
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($venta->image_qr)
                                                      <a href="{{ asset('path/to/qr/' . $venta->image_qr) }}" 
                                                      class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">Ver QR
                                                      </a>
                                                    @else
                                                      Cobro no disponible, espere a que OboLogistic lo genere.
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <div class="flex space-x-2 justify-center">
                                                        <a href="{{ url('admin-guia/show/' . $guia->id) }}" target="_blank"
                                                            class="btn btn-primary">Mostrar</a>
                                                        <a href="{{ url('admin-guia/edit/' . $guia->id) }}"
                                                            class="btn btn-warning">Editar</a>
                                                        <button type="button" class="btn btn-danger" x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal', '{{ $guia->id }}')">Eliminar</button>
                                                    </div>
                                                    <x-modal name='{{ $guia->id }}'
                                                        :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                        <form method="POST"
                                                            action="{{ route('admin.guia.destroy', ['guia_id' => $guia->id]) }}"
                                                            class="p-6">
                                                            @csrf
                                                            @method('DELETE')
                                                            <h2
                                                                class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                                {{ __('¿Estás seguro que deseas eliminar la guia ') }}{{ $guia->id }}{{ __('?') }}
                                                            </h2>
                                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                                {{ __('Esta acción no tiene marcha atrás. Cabe recalcar que también se eliminará el paquete asociado a esta guía.') }}
                                                            </p>
                                                            <div class="mt-6 flex justify-end">
                                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                                    {{ __('Cancelar') }}
                                                                </x-secondary-button>
                                                                <x-danger-button class="ml-3">
                                                                    {{ __('Eliminar') }}
                                                                </x-danger-button>
                                                            </div>
                                                        </form>
                                                    </x-modal>
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
            </div>
        </div>
    </div>
</x-client-layout>
