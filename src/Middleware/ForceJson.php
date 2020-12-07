<?php

namespace Iamxcd\LaravelCRUD\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('accept', 'application/json');
        return $next($request);
    }
}
