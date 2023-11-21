<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna memiliki salah satu dari peran yang diberikan
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak, kembalikan respons error 401 (Unauthorized)
        abort(401, 'Unauthorized');
    }
}
