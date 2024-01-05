<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // Periksa apakah pengguna telah terotentikasi dan memiliki role yang valid
        if ($user && $user->role && in_array($user->role->role, $roles)) {
            return $next($request);
        }
        dd('Unauthorized access');
        // Jika tidak memiliki role yang sesuai, arahkan ke halaman login dengan pesan kesalahan
        abort(403, 'Unauthorized.');
    }
}
