<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class officer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()) {
            return to_route('index');
        }
        $role = auth()->user()->role->name;
        $allowed = $role === 'Petugas' || $role === 'Admin';

        if ($allowed) {
            return $next($request);
        } else {
            return to_route('index');
        }
    }
}
