<?php

namespace App\Providers;

use App\Models\Contador_Pagina;

class ContadorService
{
    public function contador($nombre)
    {
        $pagina = Contador_Pagina::firstOrCreate(['nombre' => $nombre], ['visitas' => 0]);
        $pagina->increment('visitas');
        return $pagina->visitas;
    }
}
