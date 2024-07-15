<?php

namespace App\Http\Controllers;

use App\Providers\ContadorService;
use Illuminate\Http\Request;
use App\Models\Guia;
use Illuminate\Database\Eloquent\Builder;

class GuiasFindController extends Controller
{
    protected $contadorService;
    public function __construct(ContadorService $contadorService)
    {
        $this->contadorService = $contadorService;
    }

    public function __invoke()
    {
        $nombre = 'guias.find';
        $pagina = $this->contadorService->contador($nombre);
        $guia = Guia::query()
            ->withCount('ruta_rastreo')
            ->when(request('search'), function (Builder $query, $value) {
                $query->where('guias.codigo', '=', $value);
            })
            ->first();

        $guiaFound = $guia !== null;

        return view('GestionarGuias.guias.find', compact('guia', 'guiaFound'))->with('visitas', $pagina);
    }
}
