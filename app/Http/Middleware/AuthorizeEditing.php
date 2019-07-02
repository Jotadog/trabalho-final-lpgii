<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeEditing
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
        if ($request->route('profile') != auth()->user()->profile->id) {
            session()->flash('error', 'Você não pode editar esse perfil!');
            return redirect('home');
        }
        return $next($request);
    }
}
