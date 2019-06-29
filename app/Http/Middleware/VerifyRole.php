<?php

namespace App\Http\Middleware;

use Closure;

class VerifyRole
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
        if (auth()->user()->profile->role->name == 'pendente') {
            return redirect("profiles/" . auth()->user()->profile->id . "/edit");
        }

        return $next($request);
    }
}
