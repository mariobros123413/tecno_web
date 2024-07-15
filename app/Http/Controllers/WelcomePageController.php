<?php

namespace App\Http\Controllers;

use App\Providers\ContadorService;

class WelcomePageController extends Controller
{
    protected $contadorService;
    public function __construct(ContadorService $contadorService)
    {
        $this->contadorService = $contadorService;
    }
    public function __invoke()
    {
        $nombre = 'welcome';
        $pagina = $this->contadorService->contador($nombre);
        return view('welcome')->with('visitas', $pagina);
    }
}
