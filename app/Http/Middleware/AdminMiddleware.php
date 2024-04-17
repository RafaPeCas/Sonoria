<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Guardo en esta variable si el usuario esta autenticado
        $user = auth()->user();
        //Si el usuario esta autenticado, tiene un id asignado, ese id es 1 y si tiene email y ese email es admin...., puede acceder a la vista asignada
        if ($user && $user->id->id===1 && $user->email->email === 'admin@admin.com') {
            return $next($request);
        }else{
            //En caso contrario se le redirigira a la ruta principal
            return redirect('/');
        }
    }
}
