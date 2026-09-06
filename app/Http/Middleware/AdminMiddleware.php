<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Hanya izinkan pengguna dengan peran "admin" untuk melanjutkan.
     * Daftarkan middleware ini dengan alias "admin" di app/Http/Kernel.php:
     *
     *   protected $middlewareAliases = [
     *       ...
     *       'admin' => \App\Http\Middleware\AdminMiddleware::class,
     *   ];
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
