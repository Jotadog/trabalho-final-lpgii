<?php

namespace App\Http\Middleware;

use Closure;

class SetSessionData
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
        session([
            'profile' => [
                'idUser' => auth()->user()->id,
            ],
        ]);
        // dd(auth()->user()->id);
        return $next($request);
    }
}
