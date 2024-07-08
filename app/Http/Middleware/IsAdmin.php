<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //validar que el usuario sea administrador
        //si no es admin retrona una pagina de error o que le falta algun permiso
        if(auth()->user()->isAdmin()){
            return $next($request);
        }

        abort(403);

    }
}
