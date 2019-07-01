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
        if (auth()->user()->profile->status == 'Pendente') {
            return redirect("profiles/" . auth()->user()->profile->id . "/edit");
        }

        return $next($request);
    }
}
