

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GESTIONAR RUTAS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">



                <section id="contenido_principal">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="box box-default" style="border: 1px solid #574B90; min-height: 35px;">
                        <a href="{{ route('admin.ruta.create') }}" class="btn btn-success" style="font-size: 13px; margin-top: 5px; margin-left: 5px;"> Agregar </a>
                        </div>
                    </div>

                        <div class="col-md-12">
                            <div class="box box-default" style="border: 1px solid #0c0c0c;">
                            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" style="padding: 5px;">
    <div style="height: 100%; overflow: auto;">
        <table class="table table-bordered table-condensed table-striped" id="tabla-empresas" style="width: 100%;">
            <!-- Encabezados de la tabla -->
            <thead>
                <th colspan="2"></th>
            </thead>
            <thead style="background-color: #dff1ff;">
                <th style="text-align: center;">id</th>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Acción</th>
            </thead>
            @foreach($rutas as $ruta)

                <tr>
                        <td style="text-align: center;">{{$ruta->id}}</td>
                        <td style="text-align: center;">{{$ruta->nombre}}</td>

                        <td style="text-align: center;">
                        <x-custom-button :url="'admin-ruta/show/'" :valor="$ruta" >{{ __('Show') }}</x-custom-button>
                        <x-custom-button :url="'admin-ruta/edit/'" :valor="$ruta" >{{ __('Editar') }}</x-custom-button>
                        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal','{{$ruta->id}}')">{{ __('Eliminar') }}</x-danger-button>
                        <x-modal name='{{$ruta->id}}' :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="POST" action="{{ route('admin.ruta.destroy', ['ruta_id' => $ruta->id]) }}" class="p-6">
                       @csrf
                       @method('DELETE')

                      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('¿Estás seguro que deseas eliminar la Ruta ') }}{{ $ruta->id }}{{ __('?') }}
                      </h2>

                      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                         {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
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
                </div>
            </div>
    </div>
 </div>

</x-app-layout>
<!--MODAL PARA ELIMINAR-->




