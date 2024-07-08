<style>
        .timeline-circle {
            position: relative;
            display: block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-top: .25rem;
        }
        .bg-green {
            background-color: #00FF00; /* verde */
        }
        .bg-gray {
            background-color: #707070; /* gris */
        } .text-white {
            color: white;
        }
    </style>
        <div class="relative flex items-center mb-6">
        <div class="timeline-circle {{ $ruta->estado == 0 ? 'bg-gray' : 'bg-green' }} left-2.5 -ml-1.5"></div>
            <div class="ml-8">
                <div class="font-semibold {{ $ruta->estado == 0 ? 'text-gray-400' : 'text-white' }}">{{$ruta->almacen->nombre}}</div>
                <div class="text-sm text-gray-400">
                <?php
                if($ruta->estado == 1){
                    echo $ruta->updated_at;
                }
                ?>
                <br>
                <?php
                if($ruta->estado == 1){
                    echo $ruta->almacen->direccion;
                }
                ?>
                </div>
            </div>
        </div>
