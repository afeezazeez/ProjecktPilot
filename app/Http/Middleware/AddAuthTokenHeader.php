<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddAuthTokenHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->bearerToken()) {
            if ($request->hasCookie('access_token')) {
                $token = $request->cookie('access_token');
                $request->headers->add([
                    'Authorization' => 'Bearer ' . $token
                ]);
            }
        }
        return $next($request);
    }
}