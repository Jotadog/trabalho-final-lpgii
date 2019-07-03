<?php

namespace App\Http\Middleware;

use Closure;

class FinishRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->profile->role->name == 'pendente' && auth()->user()->profile->status == 'Pendente') {
            auth()->logout();
            return redirect('/')->with('error', 'Seu perfil ainda não foi aprovado!');
        } else if (auth()->user()->profile->role->name == 'pendente' && auth()->user()->profile->status == 'Aprovado') {
            return redirect("profiles/" . auth()->user()->profile->id . "/edit");
        }

        return $next($request);
    }
}
