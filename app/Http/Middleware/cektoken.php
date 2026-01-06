<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class cektoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = session('jwt_token');

        if (!$token) {
            // Token tidak ada di sesi, tidak valid
            return redirect()->route('home'); // Atau tanggapan lain sesuai kebijakan Anda
        }
        return $next($request);
    }
}
