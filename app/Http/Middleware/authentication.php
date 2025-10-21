<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


class authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $path = $request->path();               // Contoh: "dashboard" atau "pegawai/edit/5"
        $routeName = $request->route()->getName(); // Kalau route punya nama
        $method = $request->method();           // Contoh: GET, POST, PUT, DELETE

        // Simpan log dengan informasi path
        Log::channel('activity')->info(
            "User: " . Auth::user()->name .
                " mengakses path: {$path} [{$method}]" .
                ($routeName ? " (route: {$routeName})" : "")
        );

        return $next($request);
    }
}
