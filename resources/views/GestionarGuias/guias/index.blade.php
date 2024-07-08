<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GESTIONAR GUIAS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">



                    <section id="contenido_principal">
                        <div class="col-md-12" style="margin-top: 10px;">
                            <div class="box box-default" style="border: 1px solid #574B90; min-height: 35px;">
                                <a href="{{ route('admin.guia.create') }}" class="btn btn-success"
                                    style="font-size: 13px; margin-top: 5px; margin-left: 5px;"> Agregar </a>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="box box-default" style="border: 1px solid #0c0c0c;">
                                <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="padding: 5px;">
                                    <div style="height: 100%; overflow: auto;">
                                        <table class="table table-bordered table-condensed table-striped"
                                            id="tabla-empresas" style="width: 100%;">
                                            <!-- Encabezados de la tabla -->
                                            <thead>
                                                <th colspan="2"></th>
                                            </thead>
                                            <thead style="background-color: #dff1ff;">
                                                <th style="text-align: center;">id</th>
                                                <th style="text-align: center;">Nombre del Cliente</th>
                                                <th style="text-align: center;">ID de Paquete</th>
                                                <th style="text-align: center;">Servicio</th>
                                                <th style="text-align: center;">Almacen de Salida</th>
                                                <th style="text-align: center;">Almacen de Llegada</th>
                                                <th style="text-align: center;">Fecha de Salida</th>
                                                <th style="text-align: center;">Fecha de Llegad</th>
                                                <th style="text-align: center;">Peso Total</th>
                                                <th style="text-align: center;">Precio Total</th>
                                                <th style="text-align: center;">Codigo de Rastreo</th>
                                                <th style="text-align: center;">Estado</th>
                                                <th style="text-align: center;">Acción</th>
                                            </thead>
                                            @foreach($guias as $guia)

                                                <tr>
                                                    <td style="text-align: center;">{{$guia->id}}</td>
                                                    <td style="text-align: center;">{{$guia->user->name}}</td>
                                                    <td style="text-align: center;">{{$guia->paquete_id}}</td>
                                                    <td style="text-align: center;">{{$guia->servicio->nombre}}</td>
                                                    <td style="text-align: center;">{{$guia->almacenSalida->nombre}}</td>
                                                    <td style="text-align: center;">{{$guia->almacenLlegada->nombre}}</td>
                                                    <td style="text-align: center;">{{$guia->fecha_recepcion}}</td>
                                                    <td style="text-align: center;">{{$guia->fecha_entrega}}</td>
                                                    <td style="text-align: center;">{{$guia->peso_total}}</td>
                                                    <td style="text-align: center;">{{$guia->precio}}</td>
                                                    <td style="text-align: center;">{{$guia->codigo}}</td>
                                                    <td style="text-align: center;">{{$guia->estado}}</td>
                                                    <td style="text-align: center;">
                                                        <x-custom-button :url="'admin-guia/show/'" :valor="$guia"
                                                            target="_blank">{{ __('Show') }}</x-custom-button>
                                                        <x-custom-button :url="'admin-guia/edit/'"
                                                            :valor="$guia">{{ __('Editar') }}</x-custom-button>
                                                        <x-danger-button x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal','{{$guia->id}}')">{{ __('Eliminar') }}</x-danger-button>
                                                        <x-modal name='{{$guia->id}}'
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
                                                                        {{ __('Cancel') }}
                                                                    </x-secondary-button>

                                                                    <x-danger-button class="ms-3">
                                                                        {{ __('Eliminar') }}
                                                                    </x-danger-button>
                                                                </div>
                                                            </form>
                                                        </x-modal>
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="my-4">
                                    {{$guias->links()}}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>