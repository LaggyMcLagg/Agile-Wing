<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $userType)
    {
        //user() verifica se não devolve null && depois é verificado se esse user_type_id é o esperado pelo middleware
        if ($request->user() && $request->user()->user_type_id == $userType) {
            return $next($request); // Permite o acesso se o tipo de user for o esperado
        }
    
        return redirect('/home')->with('error', 'Sem permissões de acesso'); // Redireciona para uma página e mostrar uma mensagem a dizer que não tem acesso
    }    
}
