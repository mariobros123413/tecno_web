

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                {{ __('GESTIONAR PAGOS') }}

                <section id="contenido_principal">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="box box-default" style="border: 1px solid #574B90; min-height: 35px;">
                            <x-custom-button-crear :url="route('admin.pagos.create')">
                                {{ __('Crear') }}
                            </x-custom-button-crear>
                        </div>
                    </div>

                        <div class="col-md-12">
                            <div class="box box-default" style="border: 1px solid #0c0c0c;">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
    <div style="height: 100%; overflow: auto;">
    <table class="table table-bordered table-condensed table-striped" id="tabla-empresas" style="width: 100%; border-collapse: collapse;">
            <!-- Encabezados de la tabla -->
            <thead>
                <th colspan="5"></th>
            </thead>
            <thead style="background-color: #dff1ff;">
                <th style="text-align: center; border: 1px solid #ccc;">id</th>
                <th style="text-align: center; border: 1px solid #ccc;">fecha pago</th>
                <th style="text-align: center; border: 1px solid #ccc;">Estado</th>
                <th style="text-align: center; border: 1px solid #ccc;">Metodo Pago</th>
                <th style="text-align: center; border: 1px solid #ccc;">Acción</th>
            </thead>
            @foreach($pagos as $pago)

                <tr>
                        <td style="text-align: center; border: 1px solid #ccc;">{{$pago->id}}</td>
                        <td style="text-align: center; border: 1px solid #ccc;">{{$pago->fechapago}}</td>
                        <td style="text-align: center;border: 1px solid #ccc; color:
                            @if($pago->estado == 2)
                                green; /* Color verde para pagado */
                            @else
                                red; /* Color rojo para no cancelado */
                            @endif">
                            @if($pago->estado == 2)
                                Pagado
                            @else
                                No cancelado
                            @endif
                        </td>
                        <td style="text-align: center; border: 1px solid #ccc;">@if($pago->metodopago == 4)
                                       Pago Qr
                                    @else
                                        Pago Tigo Money
                                    @endif
                        </td>

                        <td style="text-align: center; border: 1px solid #ccc;">
                        <x-custom-button :url="'admin-pagos/edit/'" :valor="$pago" >{{ __('Editar') }}</x-custom-button>
                        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal','{{$pago->id}}')">{{ __('Eliminar') }}</x-danger-button>
                        <x-modal name='{{$pago->id}}' :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="POST" action="{{ route('admin.pagos.destroy', ['pago_id' => $pago->id]) }}" class="p-6">
                        @csrf
                        @method('DELETE')
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('¿Estás seguro que deseas eliminar el pago con id :  ') }}{{ $pago->id }}{{ __('?') }}
                      </h2>
                      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                         {{ __('Presione "CANCEL" para cancelar') }}
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
                            </div>
                        </div>
                </section>
                <div class="text-gray-800 my-4 flex items-center justify-center space-x-2">
                             {{ $pagos->links() }}
                </div>
                </div>
            </div>
    </div>
 </div>

</x-app-layout>
<!--MODAL PARA ELIMINAR-->



