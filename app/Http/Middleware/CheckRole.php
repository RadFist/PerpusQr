<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role != "admin") {
            // Bisa redirect, abort, atau tampilkan error sesuai kebutuhan
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }


        return $next($request);
    }
}
